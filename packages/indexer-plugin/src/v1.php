<?php namespace tanglePHP\IndexerPlugin;

use Exception;
use tanglePHP\Core\Models\AbstractPlugin;
use tanglePHP\SingleNodeClient\Api\v2\Response\Error;
use tanglePHP\IndexerPlugin\Api\v1\Response\Alias;
use tanglePHP\IndexerPlugin\Api\v1\Response\Basic;
use tanglePHP\IndexerPlugin\Api\v1\Response\Foundry;
use tanglePHP\IndexerPlugin\Api\v1\Response\NFT;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Helper\Converter;

/**
 * Class v1
 *
 * @package      tanglePHP\IndexerPlugin
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.06-1244
 */
final class v1 extends AbstractPlugin {
  /**
   * @var array
   */
  private array $querys = [
    'outputsBasic'     => [
      'address',
      'hasStorageDepositReturn',
      'storageDepositReturnAddress',
      'hasExpiration',
      'expirationReturnAddress',
      'expiresBefore',
      'expiresAfter',
      'hasTimelock',
      'timelockedBefore',
      'timelockedAfter',
      'hasNativeTokens',
      'minNativeTokenCount',
      'maxNativeTokenCount',
      'sender',
      'tag',
      'createdBefore',
      'createdAfter',
      'pageSize',
      'cursor',
    ],
    'outputsAlias'     => [
      'stateController',
      'governor',
      'hasNativeTokens',
      'minNativeTokenCount',
      'maxNativeTokenCount',
      'issuer',
      'sender',
      'createdBefore',
      'createdAfter',
      'pageSize',
      'cursor',
    ],
    'outputsAliasId'   => [],
    'outputsNft'       => [
      'hasStorageDepositReturn',
      'storageDepositReturnAddress',
      'hasExpiration',
      'expirationReturnAddress',
      'expiresBefore',
      'expiresAfter',
      'hasTimelock',
      'timelockedBefore',
      'timelockedAfter',
      'hasNativeTokens',
      'minNativeTokenCount',
      'maxNativeTokenCount',
      'issuer',
      'sender',
      'sender',
      'createdBefore',
      'createdAfter',
      'pageSize',
      'cursor',
    ],
    'outputsNftId'     => [
      'aliasAddress',
      'hasNativeTokens',
      'minNativeTokenCount',
      'maxNativeTokenCount',
      'createdBefore',
      'createdAfter',
      'pageSize',
      'cursor',
    ],
    'outputsFoundry'   => [
      'aliasAddress',
      'hasNativeTokens',
      'minNativeTokenCount',
      'maxNativeTokenCount',
      'createdBefore',
      'createdAfter',
      'pageSize',
      'cursor',
    ],
    'outputsFoundryId' => [],
  ];

  /**
   * @param array $query
   *
   * @return Basic|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function outputsBasic(array $query = []): Basic|Error {
    foreach($query as $key => $value) {
      if(!in_array($key, $this->querys['outputsBasic'])) {
        throw new Exception("unknown outputsBasic query key '$key'");
      }
    }

    return $this->Connector->API_CALLER->route($this->route . 'outputs/basic')
                                       ->query($query)
                                       ->callback(Basic::class)
                                       ->fetchJSON($this->Connector->ENDPOINT->TIMEOUT);
  }

  /**
   * @param string $address
   * @param array  $query
   *
   * @return Basic|Error
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  public function outputsBasicAddress(string $address, array $query = []): Basic|Error {
    return $this->outputsBasic(array_merge($query, ['address' => Converter::addressToBech32($address, $this->Connector->ENDPOINT->network->info['bech32Hrp'])]));
  }

  /**
   * @param array $query
   *
   * @return Alias|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function outputsAlias(array $query = []): Alias|Error {
    foreach($query as $key => $value) {
      if(!in_array($key, $this->querys['outputsAlias'])) {
        throw new Exception("unknown outputsAlias query key '$key'");
      }
    }

    return $this->Connector->API_CALLER->route($this->route . 'outputs/alias')
                                       ->query($query)
                                       ->callback(Alias::class)
                                       ->fetchJSON($this->Connector->ENDPOINT->TIMEOUT);
  }

  /**
   * @param string $aliasId
   * @param array  $query
   *
   * @return Foundry|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function outputsAliasId(string $aliasId, array $query = []): Alias|Error {
    foreach($query as $key => $value) {
      if(!in_array($key, $this->querys['outputsAliasId'])) {
        throw new Exception("unknown outputsAliasId query key '$key'");
      }
    }
    $aliasId = Converter::HexString0x($aliasId);

    return $this->Connector->API_CALLER->route($this->route . 'outputs/alias/' . $aliasId)
                                       ->query($query)
                                       ->callback(Alias::class)
                                       ->fetchJSON($this->Connector->ENDPOINT->TIMEOUT);
  }

  /**
   * @param array $query
   *
   * @return Basic|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function outputsFoundry(array $query = []): Basic|Error {
    foreach($query as $key => $value) {
      if(!in_array($key, $this->querys['outputsFoundry'])) {
        throw new Exception("unknown outputsFoundry query key '$key'");
      }
    }

    return $this->Connector->API_CALLER->route($this->route . 'outputs/foundry')
                                       ->query($query)
                                       ->callback(Basic::class)
                                       ->fetchJSON($this->Connector->ENDPOINT->TIMEOUT);
  }

  /**
   * @param string $foundryId
   * @param array  $query
   *
   * @return Foundry|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function outputsFoundryId(string $foundryId, array $query = []): Foundry|Error {
    foreach($query as $key => $value) {
      if(!in_array($key, $this->querys['outputsFoundryId'])) {
        throw new Exception("unknown outputsFoundryId query key '$key'");
      }
    }

    return $this->Connector->API_CALLER->route($this->route . 'outputs/foundry/' . $foundryId)
                                       ->query($query)
                                       ->callback(Foundry::class)
                                       ->fetchJSON($this->Connector->ENDPOINT->TIMEOUT);
  }

  /**
   * @param string $address
   * @param array  $query
   *
   * @return NFT|Error
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  public function outputsNft(string $address, array $query = []): NFT|Error {
    foreach($query as $key => $value) {
      if(!in_array($key, $this->querys['outputsNft'])) {
        throw new Exception("unknown outputsNft query key '$key'");
      }
    }
    $query = array_merge($query, ['address' => Converter::addressToBech32($address, $this->Connector->ENDPOINT->network->info['bech32Hrp'])]);

    //
    return $this->Connector->API_CALLER->route($this->route . 'outputs/nft')
                                       ->query($query)
                                       ->callback(NFT::class)
                                       ->fetchJSON($this->Connector->ENDPOINT->TIMEOUT);
  }

  /**
   * @param string $nftId
   * @param array  $query
   *
   * @return NFT|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function outputsNftId(string $nftId, array $query = []): NFT|Error {
    foreach($query as $key => $value) {
      if(!in_array($key, $this->querys['outputsNftId'])) {
        throw new Exception("unknown outputsNftId query key '$key'");
      }
    }
    $nftId = Converter::HexString0x($nftId);

    return $this->Connector->API_CALLER->route($this->route . 'outputs/nft/' . $nftId)
                                       ->query($query)
                                       ->callback(NFT::class)
                                       ->fetchJSON($this->Connector->ENDPOINT->TIMEOUT);
  }
}