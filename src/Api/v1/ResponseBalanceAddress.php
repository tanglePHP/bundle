<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ResponseBalanceAddress
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0828
 */
final class ResponseBalanceAddress extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $addressType;
  /**
   * @var string
   */
  public string $address;
  /**
   * @var int
   */
  public int $balance;
  /**
   * @var bool
   */
  public bool $dustAllowed;
  /**
   * @var int
   */
  public int $ledgerIndex;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->_input = JSON::create($this->_input['data']);
    $this->defaultParse();
  }
}