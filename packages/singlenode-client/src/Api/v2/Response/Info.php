<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\SingleNodeClient\Api\v2\Response\Info\BaseToken;
use tanglePHP\SingleNodeClient\Api\v2\Response\Info\Metrics;
use tanglePHP\SingleNodeClient\Api\v2\Response\Info\Protocol;
use tanglePHP\SingleNodeClient\Api\v2\Response\Info\Status;
use tanglePHP\Core\Models\AbstractApiResponse;

/**
 * Class Info
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0823
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
   * @var Metrics
   */
  public Metrics $metrics;
  /**
   * @var ResponseArray
   */
  public ResponseArray $supportedProtocolVersions;
  /**
   * @var Protocol
   */
  public Protocol $protocol;
  /**
   * @var ResponseArray
   */
  public ResponseArray $pendingProtocolParameters;
  /**
   * @var BaseToken
   */
  public BaseToken $baseToken;
  /**
   * @var ResponseArray
   */
  public ResponseArray $features;

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

      if($_k == 'metrics') {
        $this->metrics = new Metrics($_v);
        continue;
      }

      if($_k == 'protocol') {
        $this->protocol = new Protocol($_v);
        continue;
      }
      if($_k == 'baseToken') {
        $this->baseToken = new BaseToken($_v);
        continue;
      }



      if(is_array($_v)) {
        $_v = new ResponseArray($_v);
      }
      $this->{$_k} = $_v;
    }
  }
}