<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\ResponseArray;

/**
 * Class ResponsePayloadTransaction
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0827
 */
final class ResponsePayloadTransaction extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type = 0;
  /**
   * @var ResponseEssenceTransaction
   */
  public ResponseEssenceTransaction $essence;
  /**
   * @var array
   */
  public mixed $unlockBlocks;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      switch($_k) {
        case 'essence':
          $this->{$_k} = match ($_v['type']) {
            0 => new ResponseEssenceTransaction($_v),
          };
          break;
        case 'unlockBlocks':
          $this->unlockBlocks = new ResponseArray($_v);
          break;
        default:
          $this->{$_k} = $_v;
          break;
      }
    }
  }
}