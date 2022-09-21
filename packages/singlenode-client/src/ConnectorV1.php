<?php namespace tanglePHP\SingleNodeClient;

use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\AbstractConnector;
use tanglePHP\SingleNodeClient\Api\Routes;
use tanglePHP\SingleNodeClient\Api\v1\PayloadIndexation;
use tanglePHP\SingleNodeClient\Api\v1\RequestSubmitMessage;
use tanglePHP\SingleNodeClient\Api\v1\ResponseBalanceAddress;
use tanglePHP\SingleNodeClient\Api\v1\ResponseInfo;
use tanglePHP\SingleNodeClient\Api\v1\ResponseMessage;
use tanglePHP\SingleNodeClient\Api\v1\ResponseMessageChildren;
use tanglePHP\SingleNodeClient\Api\v1\ResponseMessageMetadata;
use tanglePHP\SingleNodeClient\Api\v1\ResponseMessagesFind;
use tanglePHP\SingleNodeClient\Api\v1\ResponseMilestone;
use tanglePHP\SingleNodeClient\Api\v1\ResponseMilestoneUtxoChanges;
use tanglePHP\SingleNodeClient\Api\v1\ResponseOutput;
use tanglePHP\SingleNodeClient\Api\v1\ResponseOutputAddress;
use tanglePHP\SingleNodeClient\Api\v1\ResponsePeers;
use tanglePHP\SingleNodeClient\Api\v1\ResponseReceipts;
use tanglePHP\SingleNodeClient\Api\v1\ResponseSubmitMessage;
use tanglePHP\SingleNodeClient\Api\v1\ResponseTips;
use tanglePHP\SingleNodeClient\Api\v1\ResponseTreasury;
use tanglePHP\SingleNodeClient\Api\v2\Response\Error;

/**
 * Class ConnectorV1
 *
 * @package      tanglePHP\SingleNodeClient
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0817
 */
final class ConnectorV1 extends AbstractConnector {
  /**
   * Returns the available API route groups of the node
   *
   * @return Routes
   * @throws HelperException
   * @deprecated not really supportet in v1
   */
  public function routes(): Routes|JSON {
    return new Routes(['routes' => []]);
  }

  /**
   * Returns general information about the node.
   *
   * @return ResponseInfo
   * @throws ApiException
   * @throws HelperException
   */
  public function info(): ResponseInfo|JSON {
    return $this->API_CALLER->route('info')
                            ->callback(ResponseInfo::class)
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
    return ($this->info())->isHealthy;
  }

  /**
   * Returns tips that are ideal for attaching a block
   *
   * @return ResponseTips
   * @throws ApiException
   * @throws HelperException
   */
  public function tips(): ResponseTips|JSON {
    return $this->API_CALLER->route('tips')
                            ->callback(ResponseTips::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Get all the stored receipts or those for a given migrated at index.
   *
   * @param int|null $migratedAt
   *
   * @return ResponseReceipts|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function receipts(?int $migratedAt = null): ResponseReceipts|Error|JSON {
    return $this->API_CALLER->route('receipts' . ($migratedAt ? '/' . $migratedAt : ''))
                            ->callback(ResponseReceipts::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns all peers of the node
   * Needs JWT
   *
   * @return ResponsePeers|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function peers(): ResponsePeers|Error|JSON {
    return $this->API_CALLER->route('peers')
                            ->callback(ResponsePeers::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns information about a milestone
   *
   * @param string $milestoneIndex
   *
   * @return ResponseMilestone|Error
   * @throws ApiException
   * @throws HelperException
   * @deprecated this is a wrapper, use milestoneByIndex()
   */
  public function milestone(string $milestoneIndex): ResponseMilestone|Error|JSON {
    return $this->milestoneByIndex($milestoneIndex);
  }

  /**
   * Returns information about a milestone
   *
   * @param int|string $milestoneIndex
   *
   * @return ResponseMilestone|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function milestoneByIndex(int|string $milestoneIndex): ResponseMilestone|Error|JSON {
    return $this->API_CALLER->route('milestones/' . $milestoneIndex)
                            ->callback(ResponseMilestone::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns all UTXO changes of the given milestone
   *
   * @param string $milestoneId
   *
   * @return ResponseMilestoneUtxoChanges|Error
   * @throws ApiException
   * @throws HelperException
   * @deprecated this is a wrapper, use milestoneUtxoChangesByIndex()
   */
  public function milestoneUtxoChanges(string $milestoneId): ResponseMilestoneUtxoChanges|Error|JSON {

    return $this->milestoneUtxoChangesByIndex($milestoneId);
  }

  /**
   * Returns all UTXO changes of the given milestone
   *
   * @param int|string $milestoneIndex
   *
   * @return ResponseMilestoneUtxoChanges|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function milestoneUtxoChangesByIndex(int|string $milestoneIndex): ResponseMilestoneUtxoChanges|Error|JSON {
    return $this->API_CALLER->route('milestones/' . $milestoneIndex . '/utxo-changes')
                            ->callback(ResponseMilestoneUtxoChanges::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Find an output by its identifier.
   *
   * @param string $outputId Identifier of the output encoded in hex. An output is identified by the concatenation of transaction_id+output_index
   *
   * @return ResponseOutput|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function output(string $outputId): ResponseOutput|Error|JSON {
    return $this->API_CALLER->route('outputs/' . $outputId)
                            ->callback(ResponseOutput::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Get the balance of a bech32-encoded address.
   *
   * @param string $addressBech32
   *
   * @return ResponseBalanceAddress|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function address(string $addressBech32): ResponseBalanceAddress|Error|JSON {
    return $this->API_CALLER->route('addresses/' . $addressBech32)
                            ->callback(ResponseBalanceAddress::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Get all outputs that use a given bech32-encoded address. If count equals maxResults, then there might be more outputs available but those were skipped for performance reasons. User should sweep the address to reduce the amount of outputs.
   *
   * @param string $addressBech32
   * @param int    $type
   * @param bool   $includeSpend
   *
   * @return ResponseBalanceAddress|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function addressesOutput(string $addressBech32, int $type = 0, bool $includeSpend = false): ResponseOutputAddress|Error|JSON {
    return $this->API_CALLER->route('addresses/' . $addressBech32 . '/outputs')
                            ->query([
                              'include-spent' => $includeSpend,
                              'type'          => $type,
                            ])
                            ->callback(ResponseOutputAddress::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Get the balance of a hex-encoded Ed25519 address.
   *
   * @param string $addressEd25519
   *
   * @return ResponseBalanceAddress|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function addressEd25519(string $addressEd25519): ResponseBalanceAddress|Error|JSON {
    return $this->API_CALLER->route('addresses/ed25519/' . $addressEd25519)
                            ->callback(ResponseBalanceAddress::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Get all outputs that use a given hex-encoded Ed25519 address. If count equals maxResults, then there might be more outputs available but those were skipped for performance reasons. User should sweep the address to reduce the amount of outputs.
   *
   * @param string $addressEd25519
   * @param int    $type
   * @param bool   $includeSpend
   *
   * @return ResponseOutputAddress|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function addressesed25519Output(string $addressEd25519, int $type = 0, bool $includeSpend = false): ResponseOutputAddress|Error|JSON {
    return $this->API_CALLER->route('addresses/ed25519/' . $addressEd25519 . '/outputs')
                            ->query([
                              'include-spent' => $includeSpend,
                              'type'          => $type,
                            ])
                            ->callback(ResponseOutputAddress::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns information about the treasury
   *
   * @return ResponseTreasury|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function treasury(): ResponseTreasury|Error|JSON {
    return $this->API_CALLER->route('treasury')
                            ->callback(ResponseTreasury::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Find a message by its identifier.
   *
   * @param string $messagesId
   *
   * @return ResponseMessage|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function message(string $messagesId): ResponseMessage|Error|JSON {
    return $this->API_CALLER->route('messages/' . $messagesId)
                            ->callback(ResponseMessage::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Search for messages matching a given indexation key.
   *
   * @param string $index
   * @param bool   $_convertToHex
   *
   * @return ResponseMessagesFind|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function messagesFind(string $index, bool $_convertToHex = true): ResponseMessagesFind|Error|JSON {
    return $this->API_CALLER->route('messages')
                            ->query(['index' => $_convertToHex ? Converter::string2Hex($index) : $index])
                            ->callback(ResponseMessagesFind::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns the metadata of a given message
   *
   * @param string $messagesId
   *
   * @return ResponseMessageMetadata|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function messageMetadata(string $messagesId): ResponseMessageMetadata|Error|JSON {
    return $this->API_CALLER->route('messages/' . $messagesId . '/metadata')
                            ->callback(ResponseMessageMetadata::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * @param string $messageId
   *
   * @return string|JSON|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function messageRaw(string $messageId): string|Error|JSON {
    return $this->API_CALLER->route('messages/' . $messageId . '/raw')
                            ->fetchBinary($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Returns the children of a message
   *
   * @param string $messageId
   *
   * @return ResponseMessageChildren|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function messageChildren(string $messageId): ResponseMessageChildren|Error|JSON {
    return $this->API_CALLER->route('messages/' . $messageId . '/children')
                            ->callback(ResponseMessageChildren::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * Submits a message to the node
   *
   * @param RequestSubmitMessage|PayloadIndexation $message
   *
   * @return ResponseSubmitMessage|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function messageSubmit(RequestSubmitMessage|PayloadIndexation $message): ResponseSubmitMessage|Error|JSON {
    if($message instanceof PayloadIndexation) {
      $message = new RequestSubmitMessage($message);
    }

    return $this->API_CALLER->route('messages')
                            ->method('POST')
                            ->requestData($message->__toJSON())
                            ->callback(ResponseSubmitMessage::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }
}