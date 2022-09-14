<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ResponseEssenceTransaction
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0828
 */
final class ResponseEssenceTransaction extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type = 0;
  /**
   * @var array
   */
  public array $inputs = [];
  /**
   * @var array
   */
  public array $outputs = [];
  /**
   * @var ResponsePayloadIndexation|null
   */
  public ?ResponsePayloadIndexation $payload;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      $this->{$_k} = match ($_k) {
        'payload' => match ($_v['type']) {
          2 => new ResponsePayloadIndexation($_v),
          default => $_v,
        },
        default => $_v,
      };
    }
  }
}