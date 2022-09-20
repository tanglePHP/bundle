<?php namespace tanglePHP\SingleNodeClient;

use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\AbstractConnector;
use tanglePHP\SingleNodeClient\Api\Routes;
use tanglePHP\SingleNodeClient\Api\v2\Response\Error;
use tanglePHP\SingleNodeClient\Api\v2\Response\Info;
use tanglePHP\SingleNodeClient\Api\v2\Response\Tips;
use tanglePHP\SingleNodeClient\Api\v2\Response\Receipts;
use tanglePHP\SingleNodeClient\Api\v2\Response\Treasury;
use tanglePHP\SingleNodeClient\Api\v2\Response\Peers;
use tanglePHP\SingleNodeClient\Api\v2\Response\MilestonePayload;
use tanglePHP\SingleNodeClient\Api\v2\Response\UTXOChanges;
use tanglePHP\SingleNodeClient\Api\v2\Response\Block;
use tanglePHP\SingleNodeClient\Api\v2\Response\BlockMetadata;
use tanglePHP\SingleNodeClient\Api\v2\Response\SubmitBlock as ResponseSubmitBlock;
use tanglePHP\SingleNodeClient\Api\v2\Request\SubmitBlock as RequestSubmitBlock;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output;
use tanglePHP\SingleNodeClient\Api\v2\Payload\TaggedData;
use tanglePHP\SingleNodeClient\Api\v2\Payload\Transaction;

/**
 * Class ConnectorV2
 *
 * @package      tanglePHP\SingleNodeClient
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0817
 */
final class ConnectorV2 extends AbstractConnector {
  use Addon\Simplifier;

  /**
   * @var bool
   */
  protected bool $LOAD_PLUGINS = true;

  /**
   * Returns the available API route groups of the node
   *
   * @return Routes
   * @throws ApiException
   * @throws HelperException
   */
  public function routes(): Routes {
    return $this->API_CALLER->route('/api/routes')
                            ->callback(Routes::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns general information about the node.
   *
   * @return Info
   * @throws ApiException
   * @throws HelperException
   */
  public function info(): Info {
    return $this->API_CALLER->route('info')
                            ->callback(Info::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns the health of the node
   *
   * @return bool
   * @throws ApiException
   * @throws HelperException
   */
  public function health(): bool {
    return ($this->info())->status->isHealthy;
  }

  /**
   * Returns tips that are ideal for attaching a block
   * The tips can be considered as non-lazy and are therefore ideal for attaching a block.
   *
   * @return Tips
   * @throws ApiException
   * @throws HelperException
   */
  public function tips(): Tips {
    return $this->API_CALLER->route('tips')
                            ->callback(Tips::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns all stored receipts or all stored receipts for a given migration index.
   *
   * @param int|null $migratedAt
   *
   * @return Receipts|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function receipts(?int $migratedAt = null): Receipts|Error {
    return $this->API_CALLER->route('receipts' . ($migratedAt ? '/' . $migratedAt : ''))
                            ->callback(Receipts::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns all peers of the node
   * Needs JWT
   *
   * @return Peers|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function peers(): Peers|Error {
    return $this->API_CALLER->route('peers')
                            ->callback(Peers::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns information about a milestone
   *
   * @param string $milestoneID
   *
   * @return MilestonePayload|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function milestone(string $milestoneID): MilestonePayload|Error {
    return $this->API_CALLER->route('milestones/' . $milestoneID)
                            ->callback(MilestonePayload::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns information about a milestone
   *
   * @param int|string $milestoneIndex
   *
   * @return MilestonePayload|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function milestoneByIndex(int|string $milestoneIndex): MilestonePayload|Error {
    return $this->API_CALLER->route('milestones/by-index/' . $milestoneIndex)
                            ->callback(MilestonePayload::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns all UTXO changes of the given milestone
   *
   * @param string $milestoneId
   *
   * @return UTXOChanges|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function milestoneUtxoChanges(string $milestoneId): UTXOChanges|Error {
    return $this->API_CALLER->route('milestones/' . $milestoneId . '/utxo-changes')
                            ->callback(UTXOChanges::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns all UTXO changes of the given milestone
   *
   * @param int|string $milestoneIndex
   *
   * @return UTXOChanges|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function milestoneUtxoChangesByIndex(int|string $milestoneIndex): UTXOChanges|Error {
    return $this->API_CALLER->route('milestones/by-index/' . $milestoneIndex . '/utxo-changes')
                            ->callback(UTXOChanges::class)
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
  public function output(string $outputId): Output|Error|JSON {
    return $this->API_CALLER->route('outputs/' . $outputId)
                            ->callback(Output::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns information about the treasury
   *
   * @return Treasury|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function treasury(): Treasury|Error {
    return $this->API_CALLER->route('treasury')
                            ->callback(Treasury::class)
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

    return $this->API_CALLER->route('blocks/' . $blockID)
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

    return $this->API_CALLER->route('blocks/' . $blockID . '/metadata')
                            ->callback(BlockMetadata::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * @param string $transactionId
   *
   * @return Block|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function transaction(string $transactionId): Block|Error {
    $blockID = Converter::HexString0x($transactionId);

    return $this->API_CALLER->route('transactions/' . $transactionId . '/included-block')
                            ->callback(Block::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Submit a payload.
   *
   * @param TaggedData|Transaction $payload
   *
   * @return ResponseSubmitBlock
   * @throws ApiException
   * @throws HelperException
   */
  public function submit(TaggedData|Transaction $payload): ResponseSubmitBlock|JSON {
    $submitBlock = new RequestSubmitBlock($payload);

    return $this->submitBlock($submitBlock);
  }

  /**
   * Submit a block.
   *
   * @param Api\v2\Request\SubmitBlock $block
   *
   * @return ResponseSubmitBlock
   * @throws ApiException
   * @throws HelperException
   */
  public function submitBlock(RequestSubmitBlock $block): ResponseSubmitBlock|JSON {
    return $this->API_CALLER->route('blocks')
                            ->method('POST')
                            ->requestData($block->__toJSON())
                            ->callback(ResponseSubmitBlock::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }
}