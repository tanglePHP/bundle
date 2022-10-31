<?php namespace tanglePHP\SingleNodeClient\Action;

use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\AbstractAmount;
use tanglePHP\SingleNodeClient\Api\v2\Address\Ed25519;
use tanglePHP\SingleNodeClient\Api\v2\Output;
use tanglePHP\SingleNodeClient\Api\v2\OutputWithData;
use tanglePHP\SingleNodeClient\Api\v2\Response\Error;
use tanglePHP\Core\Crypto\Mnemonic;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\SingleNodeClient\Helper\TransactionHelper;
use tanglePHP\SingleNodeClient\Models\AbstractAction;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Exception\Crypto as CryptoException;
use tanglePHP\Core\Exception\Type as TypeException;
use tanglePHP\Core\Type\Ed25519Seed;
use SodiumException;
use tanglePHP\SingleNodeClient\Models\ReturnNFT;
use tanglePHP\SingleNodeClient\Models\ReturnSubmitBlock;

/**
 * Class mintNFT
 *
 * @package      tanglePHP\singlenode-client\Action
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1316
 */
final class mintNFT extends AbstractAction {
  /**
   * @var Ed25519Seed
   */
  protected Ed25519Seed $ed25519Seed;
  /**
   * @var int
   */
  protected int $accountIndex = 0;
  /**
   * @var int
   */
  protected int $addressIndex = 0;
  /**
   * @var string|null
   */
  protected ?string $addressBech32 = null;
  /**
   * @var int
   */
  protected ?int $amount = null;
  /**
   * @var string|null
   */
  protected ?string $metadata;

  /**
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   *
   * @return $this
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   * @throws TypeException
   */
  public function seedInput(Ed25519Seed|Mnemonic|string|array $seedInput): self {
    $this->ed25519Seed = new Ed25519Seed($seedInput);

    return $this;
  }

  /**
   * @param int $accountIndex
   *
   * @return $this
   */
  public function accountIndex(int $accountIndex): self {
    $this->accountIndex = $accountIndex;

    return $this;
  }

  /**
   * @param int $addressIndex
   *
   * @return $this
   */
  public function addressIndex(int $addressIndex): self {
    $this->addressIndex = $addressIndex;

    return $this;
  }

  /**
   * @param string|null $address
   *
   * @return $this
   * @throws ConverterException
   */
  public function toAddress(?string $address): self {
    if(is_null($address)) {
      $this->addressBech32 = null;

      return $this;
    }
    $this->addressBech32 = Converter::addressToBech32($address, TransactionHelper::getClientProtocol_bech32($this->client));

    return $this;
  }

  /**
   * @param string|array $data
   * @param bool         $_convertToHex
   *
   * @return $this
   * @throws HelperException
   */
  public function metadata(string|array $data, bool $_convertToHex = true): self {
    if(is_array($data)) {
      $data = (JSON::create($data))->__toString();
    }
    $this->metadata = Converter::HexString0x(($_convertToHex ? Converter::string2Hex($data) : $data));

    return $this;
  }

  /**
   * @param int|string|AbstractAmount $amount
   *
   * @return $this
   * @throws HelperException
   */
  public function amount(null|int|string|AbstractAmount $amount): self {
    if(is_null($amount)) {
      $this->amount = null;

      return $this;
    }
    $this->amount = (TransactionHelper::Amount($amount, $this->client->ENDPOINT->network))->getAmount();

    return $this;
  }

  /**
   * @return bool
   * @throws ApiException
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   * @throws SodiumException
   * @throws TypeException
   */
  private function mintNFT(): bool {
    [
      $addressSeed,
      $address,
      $addressBech32,
    ] = TransactionHelper::createAddress($this->ed25519Seed, $this->client, $this->accountIndex, $this->addressIndex);
    // check if toAddress is set, otherwise the sender is the owner
    if(!isset($this->addressBech32)) {
      $this->addressBech32 = $addressBech32;
    }
    //
    $toAddress = Converter::bech32ToEd25519($this->addressBech32);
    // create inputs from output
    [
      $inputWithData,
      $total,
    ] = TransactionHelper::createInputsFromOutputBasic($this->client, $addressSeed->keyPair(), [
      'hasStorageDepositReturn' => false,
      'hasExpiration'           => false,
      'hasTimelock'             => false,
    ]);
    // create nftOutput
    $nftOutput = new Output\NFT(0);
    $nftOutput->addFeaturesIssuer(new Ed25519($address->toAddress()), true)
              ->addUnlockConditionsAddress(new Ed25519($toAddress));
    // add metadata to nftOutput
    if(isset($this->metadata)) {
      $nftOutput->addFeaturesMetadata($this->metadata, true);
    }
    // create error message if StorageDeposit < amount and amount !== null
    $minStorageDeposit = TransactionHelper::getStorageDeposit($nftOutput, $this->client);
    if(!is_null($this->amount) && $this->amount < $minStorageDeposit) {
      return $this->error(902, "minStorageDeposit is at '$minStorageDeposit' your Amount must be above this value!", [
        'address'           => $addressBech32,
        'amount'            => $this->amount,
        'difference'        => ($minStorageDeposit - $this->amount),
        'minStorageDeposit' => $minStorageDeposit,
      ]);
    }
    else {
      // set amount to minStorageDeposit if amout === null
      $this->amount = $minStorageDeposit;
    }
    // create error message if balance < amount
    if($total == 0 || $total < $this->amount) {
      return $this->error(901, "There are not enough funds in the inputs for the required balance!", [
        'address'    => $addressBech32,
        'amount'     => $this->amount,
        'difference' => ($total - $this->amount),
        'balance'    => $total,
      ]);
    }
    $nftOutput->amount = $this->amount;
    // create outputWithData
    $outputWithData = [new OutputWithData($nftOutput)];
    if($total - $this->amount > 0) {
      $outputWithData[] = new OutputWithData((new Output\Basic(($total - $this->amount)))->addUnlockConditionsAddress(new Ed25519($address->toAddress())));
    }
    // create transactionPayload
    $payload = TransactionHelper::createTransactionPayload($this->client->ENDPOINT->network->info['networkId'], $inputWithData, $outputWithData, $addressSeed);
    // create TransactionId
    $essenceHash = TransactionHelper::createTransactionId($payload);
    // create nftId
    $nftId        = TransactionHelper::resolveIdFromOutputId($essenceHash . '0000');
    $nftId_bech32 = TransactionHelper::nftId2Bech32($nftId, $this->client);
    //
    $this->blocks->add($payload, $this->settings, 'mintNFT', new ReturnNFT([
      'transactionId' => $essenceHash,
      'nftId'         => $nftId,
      'nftId_bech32'  => $nftId_bech32,
      'explorerUrl'   => $this->client->ENDPOINT->network->getExplorerUrlNFT($nftId_bech32),
      'data'          => TransactionHelper::parseData($this->metadata),
    ], $this->client->ENDPOINT->network));

    return true;
  }

  /**
   * @return ReturnSubmitBlock|Error
   * @throws ApiException
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   * @throws SodiumException
   * @throws TypeException
   */
  public function run(): ReturnSubmitBlock|Error {
    if($this->client->getProtocolVersion() == '1') {
      $this->error(905, "NFTs are not supported in protocol V1");
    }
    else {
      $this->mintNFT();
      // submit Blocks
      $this->result = $this->blocks->submit()[0];
    }

    return $this->result;
  }
}