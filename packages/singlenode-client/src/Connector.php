<?php namespace tanglePHP\SingleNodeClient;

use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\AbstractConnector;
use tanglePHP\Network\Models\AbstractEndpoint;
use tanglePHP\SingleNodeClient\Api\Routes;
use tanglePHP\SingleNodeClient\Api\v1\PayloadIndexation;
use tanglePHP\SingleNodeClient\Api\v1\RequestSubmitMessage;
use tanglePHP\SingleNodeClient\Api\v1\ResponseInfo;
use tanglePHP\SingleNodeClient\Api\v1\ResponseMessage;
use tanglePHP\SingleNodeClient\Api\v1\ResponseMessageMetadata;
use tanglePHP\SingleNodeClient\Api\v1\ResponseMilestone;
use tanglePHP\SingleNodeClient\Api\v1\ResponseMilestoneUtxoChanges;
use tanglePHP\SingleNodeClient\Api\v1\ResponseOutput;
use tanglePHP\SingleNodeClient\Api\v1\ResponsePeers;
use tanglePHP\SingleNodeClient\Api\v1\ResponseReceipts;
use tanglePHP\SingleNodeClient\Api\v1\ResponseSubmitMessage;
use tanglePHP\SingleNodeClient\Api\v1\ResponseTips;
use tanglePHP\SingleNodeClient\Api\v1\ResponseTreasury;
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
use tanglePHP\SingleNodeClient\Api\v2\Response\SubmitBlock;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output;
use tanglePHP\SingleNodeClient\Api\v2\Payload\TaggedData;
use tanglePHP\SingleNodeClient\Api\v2\Payload\Transaction;

/**
 * Class Connector
 *
 * @package      tanglePHP\SingleNodeClient
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0817
 */
final class Connector extends AbstractConnector {
  use Addon\Simplifier;

  /**
   * @var ConnectorV1
   */
  public ConnectorV1 $v1;
  /**
   * @var ConnectorV2
   */
  public ConnectorV2 $v2;

  /**
   * @param AbstractEndpoint $ENDPOINT
   */
  public function __construct(public AbstractEndpoint $ENDPOINT) {
    $this->getProtocolVersion() == '1' ? $this->v1 = new ConnectorV1($this->ENDPOINT) : $this->v2 = new ConnectorV2($this->ENDPOINT);
    //
    $this->LOAD_PLUGINS = $this->ENDPOINT->network->info['protocolVersion'] == '2';
    //
    parent::__construct($ENDPOINT);
  }

  /**
   * @param mixed $v2
   * @param mixed $v1
   *
   * @return mixed
   */
  private function callbackClass(mixed $v2, mixed $v1): mixed {
    return $this->getProtocolVersion() == '2' ? $v2 : $v1;
  }

  /**
   * @return Routes
   * @throws ApiException
   * @throws HelperException
   */
  public function routes(): Routes {
    return $this->getProtocolVersion() == '2' ? $this->v2->routes() : $this->v1->routes();
  }

  /**
   * @return Info|ResponseInfo
   * @throws ApiException
   * @throws HelperException
   */
  public function info(): Info|ResponseInfo {
    return $this->getProtocolVersion() == '2' ? $this->v2->info() : $this->v1->info();
  }

  /**
   * @return bool
   * @throws ApiException
   * @throws HelperException
   */
  public function health(): bool {
    return $this->getProtocolVersion() == '2' ? $this->v2->health() : $this->v1->health();
  }

  /**
   * @return Tips|ResponseTips
   * @throws ApiException
   * @throws HelperException
   */
  public function tips(): Tips|ResponseTips {
    return $this->getProtocolVersion() == '2' ? $this->v2->tips() : $this->v1->tips();
  }

  /**
   * Get all the stored receipts or those for a given migrated at index.
   *
   * @param int|null $migratedAt
   *
   * @return Receipts|ResponseReceipts|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function receipts(?int $migratedAt = null): Receipts|ResponseReceipts|Error {
    return $this->getProtocolVersion() == '2' ? $this->v2->receipts() : $this->v1->receipts();
  }

  /**
   * Returns all peers of the node
   * Needs JWT
   *
   * @return Peers|ResponsePeers|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function peers(): Peers|ResponsePeers|Error {
    return $this->getProtocolVersion() == '2' ? $this->v2->peers() : $this->v1->peers();
  }

  /**
   * Returns information about a milestone
   *
   * @param string $milestoneID
   *
   * @return MilestonePayload|ResponseMilestone|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function milestone(string $milestoneID): MilestonePayload|ResponseMilestone|Error {
    return $this->getProtocolVersion() == '2' ? $this->v2->milestone($milestoneID) : $this->v1->milestone($milestoneID);
  }

  /**
   * Returns information about a milestone
   *
   * @param int|string $milestoneIndex
   *
   * @return MilestonePayload|ResponseMilestone|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function milestoneByIndex(int|string $milestoneIndex): MilestonePayload|ResponseMilestone|Error {
    return $this->getProtocolVersion() == '2' ? $this->v2->milestoneByIndex($milestoneIndex) : $this->v1->milestoneByIndex($milestoneIndex);
  }

  /**
   * Returns all UTXO changes of the given milestone
   *
   * @param string $milestoneId
   *
   * @return UTXOChanges|ResponseMilestoneUtxoChanges|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function milestoneUtxoChanges(string $milestoneId): UTXOChanges|ResponseMilestoneUtxoChanges|Error {
    return $this->getProtocolVersion() == '2' ? $this->v2->milestoneUtxoChanges($milestoneId) : $this->v1->milestoneUtxoChanges($milestoneId);
  }

  /**
   * Returns all UTXO changes of the given milestone
   *
   * @param int|string $milestoneIndex
   *
   * @return UTXOChanges|ResponseMilestoneUtxoChanges|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function milestoneUtxoChangesByIndex(int|string $milestoneIndex): UTXOChanges|ResponseMilestoneUtxoChanges|Error {
    return $this->getProtocolVersion() == '2' ? $this->v2->milestoneUtxoChangesByIndex($milestoneIndex) : $this->v1->milestoneUtxoChangesByIndex($milestoneIndex);
  }

  /**
   * Find an output by its identifier.
   *
   * @param string $outputId Identifier of the output encoded in hex. An output is identified by the concatenation of transaction_id+output_index
   *
   * @return Output|ResponseOutput|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function output(string $outputId): Output|JSON|ResponseOutput|Error {
    return $this->getProtocolVersion() == '2' ? $this->v2->output($outputId) : $this->v1->output($outputId);
  }

  /**
   * Returns information about the treasury
   *
   * @return Treasury|ResponseTreasury|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function treasury(): Treasury|ResponseTreasury|Error {
    return $this->getProtocolVersion() == '2' ? $this->v2->treasury() : $this->v1->treasury();
  }

  /**
   * @param string $transactionId
   *
   * @return Block|ResponseMessage|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function transaction(string $transactionId): Block|ResponseMessage|Error {
    return $this->getProtocolVersion() == '2' ? $this->v2->transaction($transactionId) : $this->v1->message($transactionId);
  }

  /**
   * Find a block by its identifier.
   *
   * @param string $blockID
   *
   * @return Block|ResponseMessage|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function block(string $blockID): Block|ResponseMessage|Error {
    return $this->getProtocolVersion() == '2' ? $this->v2->block($blockID) : $this->v1->message($blockID);
  }

  /**
   * Returns the metadata of a given block
   *
   * @param string $blockID
   *
   * @return BlockMetadata|ResponseMessageMetadata|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function blockMetadata(string $blockID): BlockMetadata|ResponseMessageMetadata|Error {
    return $this->getProtocolVersion() == '2' ? $this->v2->blockMetadata($blockID) : $this->v1->messageMetadata($blockID);
  }

  /**
   * @param TaggedData|Transaction|RequestSubmitMessage|PayloadIndexation $payload
   *
   * @return SubmitBlock|ResponseSubmitMessage
   * @throws ApiException
   * @throws HelperException
   */
  public function submit(TaggedData|Transaction|RequestSubmitMessage|PayloadIndexation $payload): SubmitBlock|ResponseSubmitMessage {
    return $this->getProtocolVersion() == '2' ? $this->v2->submit($payload) : $this->v1->messageSubmit($payload);
  }

  /**
   * @param Api\v2\Request\SubmitBlock|RequestSubmitMessage|PayloadIndexation $block
   *
   * @return SubmitBlock|ResponseSubmitMessage
   * @throws ApiException
   * @throws HelperException
   */
  public function submitBlock(\tanglePHP\SingleNodeClient\Api\v2\Request\SubmitBlock|RequestSubmitMessage|PayloadIndexation $block): SubmitBlock|ResponseSubmitMessage {
    return $this->getProtocolVersion() == '2' ? $this->v2->submitBlock($block) : $this->v1->messageSubmit($block);
  }
}