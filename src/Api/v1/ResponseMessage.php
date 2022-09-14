<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ResponseMessage
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0828
 */
final class ResponseMessage extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $networkId;
  /**
   * @var array
   */
  public array $parentMessageIds;
  /**
   * @var ResponsePayloadIndexation|ResponsePayloadTransaction|ResponsePayloadMilestone|ResponsePayloadTreasuryTransaction
   */
  public ResponsePayloadIndexation|ResponsePayloadTransaction|ResponsePayloadMilestone|ResponsePayloadTreasuryTransaction $payload;
  /**
   * @var string
   */
  public string $nonce;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->_input = JSON::create($this->_input['data']);
    foreach($this->_input->__toArray() as $_k => $_v) {
      $this->{$_k} = match ($_k) {
        'payload' => match ($_v['type']) {
          0 => new ResponsePayloadTransaction($_v),
          1 => new ResponsePayloadMilestone($_v),
          2 => new ResponsePayloadIndexation($_v),
          4 => new ResponsePayloadTreasuryTransaction($_v),
        },
        default => $_v,
      };
    }
  }
}