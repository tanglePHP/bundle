<?php namespace tanglePHP\ChronicleClient\Api\v2\Response;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\SingleNodeClient\Api\v2\Response\Info\Protocol;
use tanglePHP\SingleNodeClient\Api\v2\Response\Info\Status;

/**
 * Class Info
 *
 * @package      tanglePHP\ChronicleClient\Api\v2\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1213
 */
final class Info extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $name;
  /**
   * @var string
   */
  public string $version;
  /**
   * @var Status
   */
  public Status $status;
  /**
   * @var Protocol
   */
  public Protocol $protocol;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      if($_k == 'status') {
        $this->status = new Status($_v);
        continue;
      }
      if($_k == 'protocol') {
        $this->protocol = new Protocol($_v);
        continue;
      }
      if(is_array($_v)) {
        $_v = new ResponseArray($_v);
      }
      $this->{$_k} = $_v;
    }
  }
}