<?php namespace tanglePHP\SingleNodeClient\Action;

use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\AbstractAmount;
use tanglePHP\SingleNodeClient\Api\v1\Address;
use tanglePHP\SingleNodeClient\Api\v1\Ed25519Signature;
use tanglePHP\SingleNodeClient\Api\v1\EssenceTransaction;
use tanglePHP\SingleNodeClient\Api\v1\Input;
use tanglePHP\SingleNodeClient\Api\v1\PayloadIndexation;
use tanglePHP\SingleNodeClient\Api\v1\PayloadTransaction;
use tanglePHP\SingleNodeClient\Api\v1\RequestSubmitMessage;
use tanglePHP\SingleNodeClient\Api\v1\UnlockBlocksReference;
use tanglePHP\SingleNodeClient\Api\v1\UnlockBlocksSignature;
use tanglePHP\SingleNodeClient\Api\v2\Address\Ed25519;
use tanglePHP\SingleNodeClient\Api\v2\Output;
use tanglePHP\SingleNodeClient\Api\v2\OutputWithData;
use tanglePHP\SingleNodeClient\Api\v2\Payload\TaggedData;
use tanglePHP\SingleNodeClient\Api\v2\Response\Error;
use tanglePHP\SingleNodeClient\Api\v2\Response\SubmitBlock;
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
use tanglePHP\SingleNodeClient\Models\ReturnSubmitBlock;

/**
 * Class sendTransaction
 *
 * @package      tanglePHP\singlenode-client\Action
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.25-1624
 */
final class sendTransaction extends AbstractAction {
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
  protected int $amount = 0;
  /**
   * @var TaggedData|PayloadIndexation|null
   */
  protected TaggedData|PayloadIndexation|null $payload = null;

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
   * @param string       $tag
   * @param array|string $data
   * @param bool         $_convertToHex
   *
   * @return $this
   * @throws HelperException
   */
  public function message(string $tag = '', array|string $data = '', bool $_convertToHex = true): self {
    if(is_array($data)) {
      $data = (JSON::create($data))->__toString();
    }
    $this->payload = $this->client->getProtocolVersion() == '2' ? new TaggedData($tag, $data, $_convertToHex) : new PayloadIndexation($tag, $data, $_convertToHex);

    return $this;
  }

  /**
   * @param int|string|AbstractAmount $amount
   *
   * @return $this
   * @throws HelperException
   */
  public function amount(int|string|AbstractAmount $amount): self {
    $this->amount = (TransactionHelper::Amount($amount, $this->client->ENDPOINT->network))->getAmount();

    return $this;
  }

  /**
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   * @throws SodiumException
   * @throws TypeException
   */
  private function run_V1(): ReturnSubmitBlock|false {
    [
      $addressSeed,
      $address,
      $addressBech32,
    ] = TransactionHelper::createAddress($this->ed25519Seed, $this->client, $this->accountIndex, $this->addressIndex);
    //
    $toAddress = Converter::bech32ToEd25519($this->addressBech32);
    // get outputs
    $_outputs = $this->client->v1->addressesed25519Output($address->toAddress());
    if($_outputs->count == 0) {
      $_outputs = $this->client->v1->addressesed25519Output($address->toAddress(), 1);
    }
    // create essence
    $essenceTransaction = new EssenceTransaction();
    // add Indexation
    if(isset($this->payload)) {
      $essenceTransaction->payload = $this->payload;
    }
    // parse outputs
    $total = 0;
    foreach(($_outputs)->outputIds as $_id) {
      $_output = $this->client->output($_id);
      if(!$_output->isSpent && $this->amount > $total) {
        $essenceTransaction->inputs[] = new Input(0, $_output->transactionId, $_output->outputIndex);
        $total                        += (int)$_output->output->amount;
      }
    }
    if($total == 0 || $total < $this->amount) {
      return $this->error(901, "There are not enough funds in the inputs for the required balance!", [
        'address'    => $addressBech32,
        'amount'     => $this->amount,
        'difference' => ($total - $this->amount),
        'balance'    => $total,
      ]);
    }
    // transfer to new address
    $essenceTransaction->outputs[] = new \tanglePHP\SingleNodeClient\Api\v1\Output(0, new Address(0, $toAddress), $this->amount);
    // sending remainder back, if amount not zero
    if($total - $this->amount > 0) {
      $essenceTransaction->outputs[] = new \tanglePHP\SingleNodeClient\Api\v1\Output(0, new Address(0, $address->toAddress()), ($total - $this->amount));
    }
    // sort inputs / outputs
    sort($essenceTransaction->inputs);
    sort($essenceTransaction->outputs);
    //
    $payloadTransaction = new PayloadTransaction($essenceTransaction);
    // unlockBlocks
    $_list = [];
    foreach($essenceTransaction->inputs as $ignored) {
      $_publicKey = ($addressSeed->keyPair())->public;
      if(isset($_list[$_publicKey])) {
        $payloadTransaction->unlockBlocks[] = new UnlockBlocksReference($_list[$_publicKey]);
      }
      else {
        $payloadTransaction->unlockBlocks[] = new UnlockBlocksSignature(new Ed25519Signature($_publicKey, \tanglePHP\Core\Crypto\Ed25519::sign(($addressSeed->keyPair())->secret, $essenceTransaction->serializeToHash())));
        $_list[$_publicKey]                 = count($payloadTransaction->unlockBlocks) - 1;
      }
    }
    $ret = $this->client->v1->messageSubmit(new RequestSubmitMessage($payloadTransaction));
    //
    if($this->settings['checkTransaction']) {
      $checked = isset($ret->messageId) ? $this->checkTransaction($ret->messageId) : null;
    }
    //
    if($this->settings['addMarketData']) {
      $marketData         = $this->client->ENDPOINT->network->marketServer->price();
      $marketData_balance = TransactionHelper::calcMarketData($this->amount, $marketData->__toArray());
    }

    //
    return new ReturnSubmitBlock([
      'blockId'            => $ret->messageId,
      'check'              => $checked ?? null,
      'marketData'         => $marketData ?? null,
      'marketData_balance' => $marketData_balance ?? null,
      'explorerUrl'        => $this->client->ENDPOINT->network->getExplorerUrlMessage($ret->messageId),
    ], $this->client->ENDPOINT->network);
  }

  /**
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   * @throws SodiumException
   * @throws TypeException
   */
  private function run_V2(): ReturnSubmitBlock|Error|false {
    [
      $addressSeed,
      $address,
      $addressBech32,
    ] = TransactionHelper::createAddress($this->ed25519Seed, $this->client, $this->accountIndex, $this->addressIndex);
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
    // create error message if balance < amount
    if($total == 0 || $total < $this->amount) {
      return $this->error(901, "There are not enough funds in the inputs for the required balance!", [
        'address'    => $addressBech32,
        'amount'     => $this->amount,
        'difference' => ($total - $this->amount),
        'balance'    => $total,
      ]);
    }
    // create output
    $basicOutput = new Output\Basic(0);
    $basicOutput->addUnlockConditionsAddress(new Ed25519($toAddress));
    // add Tag and MetaData if exists
    if(isset($this->payload)) {
      $basicOutput->addFeaturesMetadata($this->payload->data);
      $basicOutput->addFeaturesTag($this->payload->tag);
      $this->payload = null;
    }
    // create error message if StorageDeposit < amount
    $minStorageDeposit = TransactionHelper::getStorageDeposit($basicOutput, $this->client);
    if($this->amount < $minStorageDeposit) {
      return $this->error(902, "minStorageDeposit is at '$minStorageDeposit' your Amount must be above this value!", [
        'address'           => $addressBech32,
        'amount'            => $this->amount,
        'difference'        => ($minStorageDeposit - $this->amount),
        'minStorageDeposit' => $minStorageDeposit,
      ]);
    }
    $basicOutput->amount = $this->amount;
    // create outputWithData
    $outputWithData = [new OutputWithData($basicOutput)];
    if($total - $this->amount > 0) {
      $outputWithData[] = new OutputWithData((new Output\Basic(($total - $this->amount)))->addUnlockConditionsAddress(new Ed25519($address->toAddress())));
    }
    // create transactionPayload
    $transactionPayload = TransactionHelper::createTransactionPayload($this->client->ENDPOINT->network->info['networkId'], $inputWithData, $outputWithData, $addressSeed, $this->payload ?? null);




    // Submit transactionPayload
    return TransactionHelper::submit($this->client, $transactionPayload, $this->settings);
  }

  /**
   * @return SubmitBlock|JSON|Error
   * @throws ApiException
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   * @throws SodiumException
   * @throws TypeException
   */
  public function run(): ReturnSubmitBlock|Error {
    $ret = ($this->client->getProtocolVersion() == '2' ? $this->run_V2() : $this->run_V1());

    return !$ret ? $this->result : $ret;
  }
}