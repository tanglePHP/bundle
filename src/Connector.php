<?php namespace tanglePHP\ChronicleClient;

use tanglePHP\ChronicleClient\Api\v2\Response\Balance;
use tanglePHP\ChronicleClient\Api\v2\Response\Info;
use tanglePHP\ChronicleClient\Api\v2\Response\LedgerUpdate;
use tanglePHP\SingleNodeClient\Api\v2\Response\Block;
use tanglePHP\SingleNodeClient\Api\v2\Response\BlockMetadata;
use tanglePHP\SingleNodeClient\Api\v2\Response\Error;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Helper\ApiCaller;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Models\AbstractConnector;

/**
 * Class Connector
 *
 * @package      tanglePHP\ChronicleClient
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1213
 */
final class Connector extends AbstractConnector {
  /**
   * @return Info
   * @throws ApiException
   * @throws HelperException
   */
  public function info(): Info {
    return $this->API_CALLER->route('core/v2/info')
                            ->callback(Info::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * @param string $address
   * @param array  $query
   *
   * @return LedgerUpdate
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  public function addressHistory(string $address, array $query = []): LedgerUpdate {
    return $this->API_CALLER->route('history/v2/ledger/updates/by-address/' . Converter::addressToBech32($address, $this->ENDPOINT->network->info['bech32Hrp']))
                            ->query($query)
                            ->callback(LedgerUpdate::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * @param string $milestoneId
   * @param array  $query
   *
   * @return LedgerUpdate
   * @throws ApiException
   * @throws HelperException
   */
  public function milestoneHistory(string $milestoneId, array $query = []): LedgerUpdate {
    return $this->API_CALLER->route('history/v2/ledger/updates/by-milestone/' . $milestoneId)
                            ->query($query)
                            ->callback(LedgerUpdate::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * @param string $address
   *
   * @return Balance|Error
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  public function addressBalance(string $address): Balance|Error {
    $address = Converter::addressToBech32($address, $this->ENDPOINT->network->info['bech32Hrp']);

    return $this->API_CALLER->route('history/v2/balance/' . $address)
                            ->callback(Balance::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Find a block by its identifier.
   *
   * @param string $blockID
   *
   * @return Block|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function block(string $blockID): Block|Error {
    $blockID = Converter::HexString0x($blockID);

    return $this->API_CALLER->route('core/v2/blocks/' . $blockID)
                            ->callback(Block::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns the metadata of a given block
   *
   * @param string $blockID
   *
   * @return BlockMetadata|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function blockMetadata(string $blockID): BlockMetadata|Error {
    $blockID = Converter::HexString0x($blockID);

    return $this->API_CALLER->route('core/v2/blocks/' . $blockID . '/metadata')
                            ->callback(BlockMetadata::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Find an output by its identifier.
   *
   * @param string $outputId Identifier of the output encoded in hex. An output is identified by the concatenation of transaction_id+output_index
   *
   * @return Output|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function output(string $outputId): Output|Error {
    return $this->API_CALLER->route('core/v2/outputs/' . $outputId)
                            ->callback(Output::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }
}