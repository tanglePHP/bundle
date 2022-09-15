<?php namespace tanglePHP\SingleNodeClient\Helper;

use tanglePHP\Core\Exception\Helper;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Helper\Hash;
use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Helper\Keys;
use tanglePHP\Core\Helper\Simplifier;
use tanglePHP\Core\Models\AbstractAmount;
use tanglePHP\Network\Connect as Network;
use tanglePHP\SingleNodeClient\Action\checkTransaction;
use tanglePHP\SingleNodeClient\Api\v2\Ed25519Signature;
use tanglePHP\SingleNodeClient\Api\v2\Input;
use tanglePHP\SingleNodeClient\Api\v2\InputWithData;
use tanglePHP\SingleNodeClient\Api\v2\NativeToken;
use tanglePHP\SingleNodeClient\Api\v2\Output;
use tanglePHP\SingleNodeClient\Api\v2\Payload\TaggedData;
use tanglePHP\SingleNodeClient\Api\v2\Payload\Transaction;
use tanglePHP\SingleNodeClient\Api\v2\Response\Error;
use tanglePHP\SingleNodeClient\Api\v2\Response\Info\Protocol;
use tanglePHP\SingleNodeClient\Api\v2\TokenScheme;
use tanglePHP\SingleNodeClient\Api\v2\Transaction\Essence;
use tanglePHP\SingleNodeClient\Api\v2\Unlock\Reference;
use tanglePHP\SingleNodeClient\Api\v2\Unlock\Signature;
use tanglePHP\SingleNodeClient\Api\v2\UnlockCondition\Address;
use tanglePHP\SingleNodeClient\Api\v2\UnlockCondition\Expiration;
use tanglePHP\SingleNodeClient\Api\v2\UnlockCondition\GovernorAddress;
use tanglePHP\SingleNodeClient\Api\v2\UnlockCondition\ImmutableAliasAddress;
use tanglePHP\SingleNodeClient\Api\v2\UnlockCondition\StateControllerAddress;
use tanglePHP\SingleNodeClient\Api\v2\UnlockCondition\StorageDepositReturn;
use tanglePHP\SingleNodeClient\Api\v2\UnlockCondition\Timelock;
use tanglePHP\SingleNodeClient\Api\v2\Address\Ed25519 as AddressEd25519;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Alias;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Basic;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Foundry;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\NFT;
use tanglePHP\SingleNodeClient\Connector;
use tanglePHP\Core\Crypto\Ed25519;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Type as TypeException;
use tanglePHP\Core\Exception\Crypto as CryptoException;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Type\Ed25519Address;
use tanglePHP\Core\Type\Ed25519Seed;
use SodiumException;
use tanglePHP\SingleNodeClient\Models\ReturnSubmitBlock;

/**
 * Class TransactionHelper
 *
 * @package      tanglePHP\SingleNodeClient\Helper
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0818
 */
final class TransactionHelper {
  /**
   *
   */
  const OUTPUT_ID_LENGTH = 34;
  /**
   *
   */
  const OUTPUT_INDEX_LENGTH = 4;
  /**
   *
   */
  const INPUT_ID_LENGTH = 34;
  /**
   *
   */
  const BLOCK_ID_LENGTH = 32;
  /**
   *
   */
  const CONFIRMED_MILESTONE_INDEX_LENGTH = 4;
  /**
   *
   */
  const CONFIRMED_UINIX_TIMESTAMP_LENGTH = 4;

  /**
   * @param int             $networkId
   * @param array           $inputWithData
   * @param array           $outputWithData
   * @param Ed25519Seed     $addressSeed
   * @param TaggedData|null $taggedData
   *
   * @return Transaction
   * @throws ConverterException
   * @throws SodiumException
   */
  static public function createTransactionPayload(int $networkId, array $inputWithData, array $outputWithData, Ed25519Seed $addressSeed, TaggedData $taggedData = null): Transaction {
    //sort($inputWithData);
    //sort($outputWithData);
    //
    // Create Transaction Essence
    $essence = new Essence($networkId);
    //
    $toHash = "";
    // add inputs
    foreach($inputWithData as $item) {
      $essence->inputs[] = $item->input;
      $toHash            .= Hash::blake2b_sum256($item->consumingOutputBytes);
    }
    // add hashed inputsCommitment
    $essence->inputsCommitment = Converter::HexString0x(Converter::string2Hex(Hash::blake2b_sum256($toHash)));
    // add outputs
    foreach($outputWithData as $item) {
      $essence->outputs[] = $item->output;
    }
    // add TaggedData Payload
    if($taggedData) {
      $essence->payload = $taggedData;
    }
    //
    // Create Transaction Payload
    $transactionPayload = new Transaction($essence);
    // unlockBlocks
    $_list = [];
    foreach($essence->inputs as $ignored) {
      $_publicKey = Converter::HexString0x(($addressSeed->keyPair())->public);
      if(isset($_list[$_publicKey])) {
        $transactionPayload->unlocks[] = new Reference($_list[$_publicKey]);
      }
      else {
        $transactionPayload->unlocks[] = new Signature(new Ed25519Signature($_publicKey, Converter::HexString0x(Ed25519::sign(($addressSeed->keyPair())->secret, $essence->serializeToHash()))));
        $_list[$_publicKey]            = count($transactionPayload->unlocks) - 1;
      }
    }

    return $transactionPayload;
  }

  /**
   * @param Transaction $payload
   * @param bool        $asHex
   *
   * @return string
   * @throws ConverterException
   * @throws SodiumException
   */
  static public function createTransactionId(Transaction $payload, bool $asHex = true): string {
    $hash = Hash::blake2b_sum256(implode('', $payload->serialize()));

    return $asHex ? Converter::HexString0x(Converter::string2Hex($hash)) : $hash;
  }

  /**
   * @param Connector $client
   * @param Keys      $genesisWalletKeys
   * @param array     $query
   *
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   * @throws SodiumException
   */
  static public function createInputsFromOutputBasic(Connector $client, Keys $genesisWalletKeys, array $query = []): array {
    // create addressBech32
    $address       = new Ed25519Address($genesisWalletKeys->public);
    $addressBech32 = $address->toAddressBetch32(self::getClientProtocol_bech32($client));
    // get Outputs
    $response = $client->Plugin->Indexer->outputsBasicAddress($addressBech32, $query);
    if(!isset($response->items)) {
      throw new HelperException('no output items found!');
    }

    // create inputWithData
    return self::buildInputWithData($client, $response->items, $genesisWalletKeys);
  }

  /**
   * @param Connector $client
   * @param string    $nftId
   * @param Keys      $nftWalletKeys
   * @param array     $query
   *
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  static public function createInputsFromOutputNftId(Connector $client, string $nftId, Keys $nftWalletKeys, array $query = []): array {
    // get Outputs
    $response = $client->Plugin->Indexer->outputsNftId($nftId, $query);
    if(!isset($response->items)) {
      throw new HelperException('no output items found!');
    }

    // create inputWithData
    return self::buildInputWithData($client, $response->items, $nftWalletKeys);
  }

  /**
   * @param Connector $client
   * @param string    $aliasId
   * @param Keys      $nftWalletKeys
   * @param array     $query
   *
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  static public function createInputsFromOutputAliasId(Connector $client, string $aliasId, Keys $nftWalletKeys, array $query = []): array {
    // get Outputs
    $response = $client->Plugin->Indexer->outputsAliasId($aliasId, $query);
    if(!isset($response->items)) {
      throw new HelperException('no output items found!');
    }

    // create inputWithData
    return self::buildInputWithData($client, $response->items, $nftWalletKeys);
  }

  /**
   * @param Transaction $transactionPayload
   * @param Keys        $keys
   * @param int|null    $need
   * @param bool        $parsefull
   *
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   * @throws SodiumException
   */
  static public function createInputWidthDataFromTransaction(Transaction $transactionPayload, Keys $keys, ?int $need = null, bool $parsefull = false): array {
    $total         = 0;
    $inputWithData = [];
    $transactionId = self::createTransactionId($transactionPayload);
    /**
     * @var $output Output\Alias|Output\NFT|Output\Basic|Output\Foundry
     */
    foreach($transactionPayload->essence->outputs as $index => $output) {
      if($need && $output->type != $need) {
        continue;
      }
      $outputIndex     = self::outputIndex2UInt16Hex($index);
      $outputId        = $transactionId . $outputIndex;
      $outputResponse  = match ($output->type) {
        3 => new Basic($output->__toArray()),
        4 => new Alias($output->__toArray()),
        5 => new Foundry($output->__toArray()),
        6 => new NFT($output->__toArray()),
      };
      $inputWithData[] = new InputWithData(new Input(0, $transactionId, $outputIndex), $keys, $outputResponse, $outputId, $parsefull);
      // calc total amount
      $total += (int)$output->amount;
    }

    return [
      $inputWithData,
      $total,
    ];
  }

  /**
   * @param int $int
   *
   * @return string
   */
  static public function outputIndex2UInt16Hex(int $int): string {
    return Converter::string2Hex(Converter::serializeUInt16($int));
  }

  /**
   * @param Basic|Alias|Foundry|NFT $output
   * @param string                  $outputId
   * @param Keys                    $keys
   *
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  static public function buildInputWidthDataFromOutput(Basic|Alias|Foundry|NFT $output, string $outputId, Keys $keys): array {
    return [
      [new InputWithData(self::inputFromOutputId($outputId), $keys, $output, $outputId)],
      $output->amount,
    ];
  }

  /**
   * @param Connector     $client
   * @param ResponseArray $items
   * @param Keys          $keys
   *
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  static private function buildInputWithData(Connector $client, ResponseArray $items, Keys $keys): array {
    $total         = 0;
    $inputWithData = [];
    foreach($items as $outputId) {
      $output = $client->output($outputId);
      if(!$output->metadata->isSpent) {
        $inputWithData[] = new InputWithData(new Input(0, $output->metadata->transactionId, $output->metadata->outputIndex), $keys, $output->output, $outputId);
        // calc total amount
        $total += (int)$output->output->amount;
      }
    }

    return [
      $inputWithData,
      $total,
    ];
  }

  /**
   * @param \tanglePHP\SingleNodeClient\Api\v2\Address\Alias $addressAlias
   * @param string                                           $fOSerialNumber
   * @param int                                              $fOtokenShemeType
   *
   * @return string
   * @throws ConverterException
   */
  static public function constructTokenId(\tanglePHP\SingleNodeClient\Api\v2\Address\Alias $addressAlias, string $fOSerialNumber, int $fOtokenShemeType): string {
    $_ret   = $addressAlias->serialize();
    $_ret[] = Converter::serializeUInt32($fOSerialNumber);
    $_ret[] = Converter::serializeUInt8($fOtokenShemeType);

    return Converter::add0x(Converter::string2Hex(implode('', $_ret)));
  }

  /**
   * @param string $outputId
   *
   * @return Input
   */
  static public function inputFromOutputId(string $outputId): Input {
    $transactionId          = Converter::HexString0x(substr(Converter::remove0x($outputId), 0, self::INPUT_ID_LENGTH * 2));
    $transactionOutputIndex = substr($outputId, -(self::OUTPUT_INDEX_LENGTH));

    return new Input(0, $transactionId, $transactionOutputIndex);
  }

  /**
   * @param Input $input
   *
   * @return string
   */
  static public function createInputIdHex(Input $input): string {
    // parse transaction ID
    $ret = substr(Converter::remove0x($input->transactionId), 0, self::INPUT_ID_LENGTH * 2);
    // parse transactionOutputIndex to Unit16 as Hex
    $ret .= self::outputIndex2UInt16Hex($input->transactionOutputIndex);

    return $ret;
  }

  /**
   * @param Basic|Alias|Foundry|NFT $consumingOutput
   * @param string                  $outputId
   * @param bool                    $parsefull
   *
   * @return Output\Basic|Output\Alias|Output\Foundry|Output\NFT
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   * @throws SodiumException
   */
  static public function parseConsumingOutput(Basic|Alias|Foundry|NFT $consumingOutput, string $outputId, bool $parsefull = false): Output\Basic|Output\Alias|Output\Foundry|Output\NFT {
    // Create Output Object
    $newConsumingOutput = match ($consumingOutput->type) {
      3 => new Output\Basic(),
      4 => new Output\Alias(),
      5 => new Output\Foundry(),
      6 => new Output\NFT(),
      default => throw new ApiException("Unrecognized output address type $consumingOutput->type"),
    };
    //
    $newConsumingOutput->type   = $consumingOutput->type;
    $newConsumingOutput->amount = $consumingOutput->amount;
    // nativeTokens
    if(isset($consumingOutput->nativeTokens)) {
      foreach($consumingOutput->nativeTokens->__toArray() as $item) {
        $newConsumingOutput->nativeTokens[] = new NativeToken($item['id'], $item['amount']);
      }
    }
    if($parsefull) {
      if(isset($consumingOutput->nftId)) {
        $newConsumingOutput->nftId = TransactionHelper::resolveIdFromOutputId($outputId);
      }
      if(isset($consumingOutput->aliasId)) {
        $newConsumingOutput->aliasId = $consumingOutput->aliasId;
      }
    }
    // stateIndex
    if(isset($consumingOutput->stateIndex)) {
      $newConsumingOutput->stateIndex = $consumingOutput->stateIndex;
    }
    // stateMetadata
    if(isset($consumingOutput->stateMetadata)) {
      $newConsumingOutput->stateMetadata = $consumingOutput->stateMetadata;
    }
    // foundryCounter
    if(isset($consumingOutput->foundryCounter)) {
      $newConsumingOutput->foundryCounter = $consumingOutput->foundryCounter;
    }
    // serialNumber
    if(isset($consumingOutput->serialNumber)) {
      $newConsumingOutput->serialNumber = $consumingOutput->serialNumber;
    }
    // tokenScheme
    if(isset($consumingOutput->tokenScheme)) {
      $tokenSheme                      = new TokenScheme($consumingOutput->tokenScheme->mintedTokens, $consumingOutput->tokenScheme->meltedTokens, $consumingOutput->tokenScheme->maximumSupply);
      $tokenSheme->type                = $consumingOutput->tokenScheme->type;
      $newConsumingOutput->tokenScheme = $tokenSheme;
    }
    // unlockConditions
    if(isset($consumingOutput->unlockConditions)) {
      foreach($consumingOutput->unlockConditions->__toArray() as $item) {
        $newConsumingOutput->unlockConditions[] = match ($item['type']) {
          0 => new Address(self::createAddressTypeObject($item)),
          1 => new StorageDepositReturn(self::createAddressTypeObject($item), $item['amount']),
          2 => new Timelock($item['unixTime']),
          3 => new Expiration(self::createAddressTypeObject($item), $item['unixTime']),
          4 => new StateControllerAddress(self::createAddressTypeObject($item)),
          5 => new GovernorAddress(self::createAddressTypeObject($item)),
          6 => new ImmutableAliasAddress(self::createAddressTypeObject($item)),
          default => throw new ApiException("Unrecognized unlockConditions type'" . $item['type'] . "'"),
        };
      }
    }
    // features
    if(isset($consumingOutput->features)) {
      foreach($consumingOutput->features->__toArray() as $item) {
        switch($item['type']) {
          case 0:
            $newConsumingOutput->addFeaturesSender(new AddressEd25519(Converter::remove0x($item['address']['pubKeyHash'])));
            break;
          case 1:
            $newConsumingOutput->addFeaturesIssuer(new AddressEd25519(Converter::remove0x($item['address']['pubKeyHash'])));
            break;
          case 2:
            $newConsumingOutput->addFeaturesMetadata($item['data']);
            break;
          case 3:
            $newConsumingOutput->addFeaturesTag($item['tag']);
            break;
          default:
            throw new ApiException("Unrecognized immutableFeatures type $item->type");
        }
      }
    }
    // immutableFeatures
    if(isset($consumingOutput->immutableFeatures)) {
      foreach($consumingOutput->immutableFeatures->__toArray() as $item) {
        switch($item['type']) {
          case 0:
            $newConsumingOutput->addFeaturesSender(new AddressEd25519(Converter::remove0x($item['address']['pubKeyHash'])), true);
            break;
          case 1:
            $newConsumingOutput->addFeaturesIssuer(new AddressEd25519(Converter::remove0x($item['address']['pubKeyHash'])), true);
            break;
          case 2:
            $newConsumingOutput->addFeaturesMetadata($item['data'], true);
            break;
          case 3:
            $newConsumingOutput->addFeaturesTag($item['tag'], true);
            break;
          default:
            throw new ApiException("Unrecognized immutableFeatures type $item->type");
        }
      }
    }

    return $newConsumingOutput;
  }

  /**
   * @param $item
   *
   * @return AddressEd25519|\tanglePHP\SingleNodeClient\Api\v2\Address\Alias|\tanglePHP\SingleNodeClient\Api\v2\Address\NFT
   * @throws ApiException
   */
  static private function createAddressTypeObject($item): AddressEd25519|\tanglePHP\SingleNodeClient\Api\v2\Address\Alias|\tanglePHP\SingleNodeClient\Api\v2\Address\NFT {
    $key = isset($item['address']) ? 'address' : 'returnAddress';

    return match ($item[$key]['type']) {
      0 => new AddressEd25519(Converter::remove0x($item[$key]['pubKeyHash'])),
      8 => new \tanglePHP\SingleNodeClient\Api\v2\Address\Alias($item[$key]['aliasId']),
      16 => new \tanglePHP\SingleNodeClient\Api\v2\Address\NFT($item[$key]['nftId']),
      default => throw new ApiException("Unrecognized unlockConditions address type " . $item[$key]['type']),
    };
  }

  /**
   * @param Connector $client
   *
   * @return Protocol
   * @throws ApiException
   * @throws HelperException
   */
  static public function getClientProtocol(Connector $client): Protocol {
    return ($client->info())->protocol;
  }

  /**
   * @param Connector $client
   *
   * @return string
   */
  static public function getClientProtocol_bech32(Connector $client): string {
    return $client->ENDPOINT->network->info['bech32Hrp'];
  }

  /**
   * @param Connector $client
   *
   * @return string
   */
  static public function getClientProtocol_coinType(Connector $client): string {
    return $client->ENDPOINT->network->info['coinType'];
  }

  /**
   * @param Ed25519Address $address
   * @param Connector      $client
   *
   * @return string
   * @throws ConverterException
   * @throws SodiumException
   */
  static public function createBech32FromEd25519Address(Ed25519Address $address, Connector $client): string {
    return $address->toAddressBetch32(TransactionHelper::getClientProtocol_bech32($client));
  }

  /**
   * @param Ed25519Seed $ed25519Seed
   * @param Connector   $client
   * @param int         $accountIndex
   * @param int         $addressIndex
   *
   * @return Ed25519Seed
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   * @throws TypeException
   */
  static public function createAddressSeed(Ed25519Seed $ed25519Seed, Connector $client, int $accountIndex = 0, int $addressIndex = 0): Ed25519Seed {
    return $ed25519Seed->generateSeedFromPath(Simplifier::createAddressPath(self::getClientProtocol_coinType($client), $accountIndex, $addressIndex));
  }

  /**
   * @param Ed25519Seed $ed25519Seed
   * @param Connector   $client
   * @param int         $accountIndex
   * @param int         $addressIndex
   *
   * @return array
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   * @throws SodiumException
   * @throws TypeException
   */
  static public function createAddress(Ed25519Seed $ed25519Seed, Connector $client, int $accountIndex = 0, int $addressIndex = 0): array {
    $addressSeed   = $ed25519Seed->generateSeedFromPath(Simplifier::createAddressPath(self::getClientProtocol_coinType($client), $accountIndex, $addressIndex));
    $address       = new Ed25519Address(($addressSeed->keyPair())->public);
    $addressBech32 = self::createBech32FromEd25519Address($address, $client);

    return [
      $addressSeed,
      $address,
      $addressBech32,
    ];
  }

  /**
   * @param Connector $client
   *
   * @return Protocol\RentStructure
   * @throws ApiException
   * @throws HelperException
   */
  static public function getClientProtocol_rentStructure(Connector $client): Protocol\RentStructure {
    return TransactionHelper::getClientProtocol($client)->rentStructure;
  }

  /**
   * @param Connector $client
   *
   * @return int
   * @throws ApiException
   * @throws HelperException
   */
  static public function getClientProtocol_minPowScore(Connector $client): int {
    return TransactionHelper::getClientProtocol($client)->minPowScore;
  }

  /**
   * @param Output    $output
   * @param Connector $client
   *
   * @return int
   * @throws ApiException
   * @throws HelperException
   */
  static public function getStorageDeposit(Output $output, Connector $client): int {
    $rentStructure = self::getClientProtocol_rentStructure($client);
    $outputBytes   = implode('', $output->serialize());
    //
    $offset    = ($rentStructure->vByteFactorKey * self::OUTPUT_ID_LENGTH) + ($rentStructure->vByteFactorData * (self::BLOCK_ID_LENGTH + self::CONFIRMED_MILESTONE_INDEX_LENGTH + self::CONFIRMED_UINIX_TIMESTAMP_LENGTH));
    $vByteSize = ($rentStructure->vByteFactorData * strlen($outputBytes) + $offset);

    return $rentStructure->vByteCost * $vByteSize;
  }

  /**
   * @param string $outputId
   *
   * @return string
   * @throws ConverterException
   * @throws SodiumException
   */
  static public function resolveIdFromOutputId(string $outputId): string {
    $outputId = Converter::remove0x($outputId);
    $outputId = Converter::hex2String($outputId);

    return Converter::HexString0x(Converter::string2Hex(Hash::blake2b_sum256($outputId)));
  }

  /**
   * @param string    $nftId
   * @param Connector $client
   *
   * @return string
   * @throws ConverterException
   */
  static public function nftId2Bech32(string $nftId, Connector $client): string {
    return Converter::addressToBech32($nftId, self::getClientProtocol_bech32($client), 16);
  }

  /**
   * @param Connector   $client
   * @param Transaction $transactionPayload
   * @param array       $settings
   *
   * @return ReturnSubmitBlock|Error
   * @throws ApiException
   * @throws HelperException
   */
  static public function submit(Connector $client, Transaction $transactionPayload, array $settings): ReturnSubmitBlock|Error {
    // submit payload
    $ret = $client->submit($transactionPayload);
    //
    if(isset($ret->blockId)) {
      // check transaction if true
      if($settings['checkTransaction']) {
        $checked = (new checkTransaction($client))->blockId($ret->blockId)
                                                  ->run();
      }
      if($settings['addMarketData']) {
        $marketData = $client->ENDPOINT->network->marketServer->price();
      }

      return new ReturnSubmitBlock([
        'blockId'     => $ret->blockId,
        'check'       => $checked ?? null,
        'marketData'  => $marketData ?? null,
        'explorerUrl' => $client->ENDPOINT->network->getExplorerUrlBlock($ret->blockId),
      ], $client->ENDPOINT->network);
    }

    return self::createError('800', $ret);
  }

  /**
   * @param int|string|AbstractAmount $amount
   * @param Network|string            $unit
   *
   * @return AbstractAmount
   * @throws HelperException
   */
  static public function Amount(int|string|AbstractAmount $amount, Network|string $unit): AbstractAmount {
    if($unit instanceof Network) {
      $unit = $unit->info['baseToken'];
    }
    if($amount instanceof AbstractAmount) {
      if(($aUnit = $amount->getUnit()) != $unit) {
        throw new HelperException("Amount unit does not match '$aUnit' should be '$unit'");
      }

      return $amount;
    }
    //
    $className = 'tanglePHP\\Core\\Helper\\Amount\\' . $unit;
    if(!class_exists($className)) {
      throw new HelperException("Unknown Amount unit '$unit'");
    }

    return new $className($amount);
  }

  /**
   * @param string|null $hexString
   *
   * @return array
   * @throws ConverterException
   * @throws HelperException
   */
  static public function parseData(?string $hexString): array {
    if(!isset($hexString)) {
      $hexString = '';
    }
    $data = [
      'hex'   => $hexString,
      'plain' => Converter::hex2String(Converter::remove0x($hexString)),
      'array' => [],
    ];
    if(Converter::isJSON($data['plain'])) {
      $data['array'] = JSON::create($data['plain'])
                           ->__toArray();
    }

    return $data;
  }

  /**
   * @param int    $code
   * @param string $msg
   * @param array  $metadata
   *
   * @return Error
   * @throws HelperException
   */
  static public function createError(int $code, string $msg, array $metadata = []): Error {
    return new Error([
      'error'    => $code,
      'message'  => $msg,
      'metadata' => $metadata,
    ]);
  }
}