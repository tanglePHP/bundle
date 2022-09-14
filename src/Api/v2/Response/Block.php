<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\SingleNodeClient\Api\v2\Response\Payload\TaggedData;
use tanglePHP\SingleNodeClient\Api\v2\Response\Payload\Transaction;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class Block
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0822
 */
final class Block extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $protocolVersion;
  /**
   * @var array
   */
  public array $parents;
  /**
   * @var mixed
   */
  public Transaction|TaggedData|ResponseArray $payload;
  /**
   * @var string
   */
  public string $nonce;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      if($_k == 'payload') {
        $this->payload = match ($_v['type']) {
          5 => new TaggedData($_v),
          6 => new Transaction($_v),
          default => new ResponseArray($_v),
        };
        continue;
      }
      $this->{$_k} = $_v;
    }
  }
}