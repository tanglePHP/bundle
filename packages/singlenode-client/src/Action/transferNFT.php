<?php namespace tanglePHP\SingleNodeClient\Action;

use tanglePHP\SingleNodeClient\Api\v2\Address\Ed25519;
use tanglePHP\SingleNodeClient\Api\v2\InputWithData;
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
 * Class transferNFT
 *
 * @package      tanglePHP\singlenode-client\Action
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1316
 */
final class transferNFT extends AbstractAction {
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
   * @var string|null
   */
  protected ?string $nftId = null;

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
   * @param string $nftId
   *
   * @return $this
   */
  public function nftId(string $nftId): self {
    $this->nftId = $nftId;

    return $this;
  }

  /**
   * @param string $address
   *
   * @return $this
   * @throws ConverterException
   */
  public function toAddress(string $address): self {
    $this->addressBech32 = Converter::addressToBech32($address, TransactionHelper::getClientProtocol_bech32($this->client));

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
  private function transferNFT(): bool {
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
    ] = TransactionHelper::createInputsFromOutputNftId($this->client, $this->nftId, $addressSeed->keyPair(), []);
    // todo@st: check if NFTid Exists
    // create nftOutput
    $outputWithData = [];
    /**
     * @var $inputWD InputWithData
     */
    foreach($inputWithData as $inputWD) {
      $nftOutput                   = $inputWD->consumingOutput;
      $nftOutput->unlockConditions = [];
      $nftOutput->addUnlockConditionsAddress(new Ed25519($toAddress));
      //
      $outputWithData[] = new OutputWithData($nftOutput);
    }
    // create transactionPayload
    $payload = TransactionHelper::createTransactionPayload($this->client->ENDPOINT->network->info['networkId'], $inputWithData, $outputWithData, $addressSeed);
    // create TransactionId
    $essenceHash = TransactionHelper::createTransactionId($payload);
    // create nftId
    $nftId        = TransactionHelper::resolveIdFromOutputId($essenceHash . '0000');
    $nftId_bech32 = TransactionHelper::nftId2Bech32($nftId, $this->client);
    //
    $this->blocks->add($payload, $this->settings, 'transferNFT', new ReturnNFT([
      'transactionId' => $essenceHash,
      'nftId'         => $nftId,
      'nftId_bech32'  => $nftId_bech32,
      'explorerUrl'   => $this->client->ENDPOINT->network->getExplorerUrlNFT($nftId_bech32),
      //'data'          => TransactionHelper::parseData($this->metadata),
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
      $this->transferNFT();
      // submit Blocks
      $this->result = $this->blocks->submit()[0];
    }

    return $this->result;
  }
}