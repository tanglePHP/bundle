<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response\Payload;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\SingleNodeClient\Api\v2\Response\Essence;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class Transaction
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response\Payload
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0823
 */
final class Transaction extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type;
  /**
   * @var Essence
   */
  public Essence $essence;
  /**
   * @var mixed
   */
  public mixed $unlocks;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      if($_k == 'essence') {
        $this->essence = new Essence($_v);
        continue;
      }
      if(is_array($_v)) {
        $_v = new ResponseArray($_v);
      }
      $this->{$_k} = $_v;
    }
  }
}