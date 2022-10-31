<?php namespace tanglePHP\SingleNodeClient\Action;

use tanglePHP\Core\Helper\JSON;
use tanglePHP\SingleNodeClient\Api\v1\PayloadIndexation;
use tanglePHP\SingleNodeClient\Api\v2\Payload\TaggedData;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\SingleNodeClient\Models\AbstractAction;
use tanglePHP\SingleNodeClient\Models\ReturnSubmitBlock;

/**
 * Class sendMessage
 *
 * @package      tanglePHP\SingleNodeClient\Action
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.05-0952
 */
final class sendMessage extends AbstractAction {
  /**
   * @var TaggedData|PayloadIndexation|null
   */
  protected TaggedData|PayloadIndexation|null $payload = null;

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
   * @return ReturnSubmitBlock
   * @throws ApiException
   * @throws HelperException
   */
  private function run_V1(): ReturnSubmitBlock {
    $ret = $this->client->v1->messageSubmit($this->payload);
    if($this->settings['checkTransaction']) {
      $checked = isset($ret->messageId) ? $this->checkTransaction($ret->messageId) : null;
    }

    return new ReturnSubmitBlock([
      'blockId'     => $ret->messageId ?? 'unknown',
      'check'       => $checked ?? null,
      'explorerUrl' => $this->client->ENDPOINT->network->getExplorerUrlMessage($ret->messageId ?? ''),
      'return'      => $ret,
    ], $this->client->ENDPOINT->network);
  }

  /**
   * @return ReturnSubmitBlock
   * @throws ApiException
   * @throws HelperException
   */
  private function run_V2(): ReturnSubmitBlock {
    $ret = $this->client->submit($this->payload);
    if($this->settings['checkTransaction']) {
      $checked = isset($ret->blockId) ? $this->checkTransaction($ret->blockId) : null;
    }

    return new ReturnSubmitBlock([
      'blockId'     => $ret->blockId ?? 'unknown',
      'check'       => $checked ?? null,
      'explorerUrl' => $this->client->ENDPOINT->network->getExplorerUrlBlock($ret->blockId ?? ''),
      'return'      => $ret,
    ], $this->client->ENDPOINT->network);
  }

  /**
   * @return ReturnSubmitBlock
   * @throws ApiException
   * @throws HelperException
   */
  public function run(): ReturnSubmitBlock {
    return $this->client->getProtocolVersion() == '1' ? $this->run_V1() : $this->run_V2();
  }
}