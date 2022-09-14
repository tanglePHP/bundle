<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response\Info;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\SingleNodeClient\Api\v2\Response\Info\Protocol\RentStructure;
use tanglePHP\Core\Models\ResponseArray;

/**
 * Class Protocol
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response\Info
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0824
 */
final class Protocol extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $version;
  /**
   * @var string
   */
  public string $networkName;
  /**
   * @var string
   */
  public string $bech32Hrp;
  /**
   * @var int
   */
  public int $minPowScore;
  /**
   * @var int
   */
  public int $belowMaxDepth;
  /**
   * @var RentStructure
   */
  public RentStructure $rentStructure;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      if($_k == 'rentStructure') {
        $this->rentStructure = new RentStructure($_v);
        continue;
      }
      if(is_array($_v)) {
        $_v = new ResponseArray($_v);
      }
      $this->{$_k} = $_v;
    }
  }
}