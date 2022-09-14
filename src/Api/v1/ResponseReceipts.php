<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ResponseReceipts
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0827
 */
final class ResponseReceipts extends AbstractApiResponse {
  /**
   * @var ResponseArray
   */
  public ResponseArray $receipts;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->_input = JSON::create($this->_input['data']);
    $this->defaultParse();
  }
}