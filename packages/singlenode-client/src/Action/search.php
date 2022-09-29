<?php namespace tanglePHP\SingleNodeClient\Action;

use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Helper\JSON;
use tanglePHP\SingleNodeClient\Api\v1\ResponsePayloadIndexation;
use tanglePHP\SingleNodeClient\Api\v1\ResponsePayloadTransaction;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Basic;
use tanglePHP\SingleNodeClient\Helper\TransactionHelper;
use tanglePHP\SingleNodeClient\Models\AbstractAction;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class search
 *
 * @package      tanglePHP\singlenode-client\Action
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.24-1115
 */
final class search extends AbstractAction {
  /**
   * @var string
   */
  protected string $tag;
  /**
   * @var bool
   */
  protected bool $parseItemList = true;

  /**
   * @param string $string
   * @param bool   $_convertToHex
   *
   * @return $this
   */
  public function tag(string $string, bool $_convertToHex = true): self {
    $this->tag = Converter::HexString0x(($_convertToHex ? Converter::string2Hex($string) : $string));

    return $this;
  }

  /**
   * @param bool $val
   *
   * @return $this
   */
  public function parseItemList(bool $val = true): self {
    $this->parseItemList = $val;

    return $this;
  }

  /**
   * @param array $items
   *
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  private function _parseItemList(array $items): array {
    foreach($items as $item) {
      $add = [
        'item'        => $item,
        'explorerUrl' => $this->client->ENDPOINT->network->getExplorerUrlMessage($item),
      ];
      // get item info if parseItemList === true
      if($this->parseItemList) {
        // protocol V1
        if($this->client->getProtocolVersion() == '1') {
          $itemData = $this->client->v1->message($item);
          if($itemData->payload instanceof ResponsePayloadTransaction) {
            $add['data'] = TransactionHelper::parseData($itemData->payload->essence->payload->data);
          }
          else if($itemData->payload instanceof ResponsePayloadIndexation) {
            $add['data'] = TransactionHelper::parseData($itemData->payload->data);
          }
        }
        // protocol V2
        else {
          $itemData = $this->client->v2->output($item);
          if($itemData->output instanceof Basic) {
            foreach($itemData->output->features as $key => $feature) {
              if($feature->type == 2) {
                $add['blockId']       = $itemData->metadata->blockId;
                $add['transactionId'] = $itemData->metadata->transactionId;
                $add['amount']        = $itemData->output->amount;
                $add['data']          = TransactionHelper::parseData($itemData->output->features->{$key}->data);
              }
            }
          }
        }
      }
      $itemsList[] = $add;
    }

    return $itemsList ?? [];
  }

  /**
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  private function run_V1(): array {
    $this->result = $this->client->v1->messagesFind(Converter::remove0x($this->tag), false);
    $items        = $this->result->messageIds ?? [];

    return [
      'count' => count($items),
      'items' => $this->_parseItemList($items),
    ];
  }

  /**
   * @return array
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  private function run_V2(): array {
    $query = [];
    if(isset($this->tag)) {
      $query['tag'] = $this->tag;
    }
    $this->result = $this->client->Plugin->Indexer->outputsBasic($query);
    $items        = $this->result->items->__toArray() ?? [];

    return [
      'count' => count($items),
      'items' => $this->_parseItemList($items),
    ];
  }

  /**
   * @return JSON
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  public function run(): JSON {
    $returnValue = $this->client->getProtocolVersion() == '1' ? $this->run_V1() : $this->run_V2();
    // add last and first
    $returnValue['last']  = end($returnValue['items']);
    $returnValue['first'] = reset($returnValue['items']);
    //
    $this->result = JSON::create($returnValue);

    return $this->result;
  }
}