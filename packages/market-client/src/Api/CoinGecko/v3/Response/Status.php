<?php namespace tanglePHP\MarketClient\Api\CoinGecko\v3\Response;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Helper\JSON;

/**
 * Class Status
 *
 * @package      tanglePHP\MarketClient\Api\CoinGecko\v3\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.21-1530
 */
final class Status extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $error_code;
  /**
   * @var string
   */
  public string $error_message;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->_input = JSON::create($this->_input['status']);
    $this->defaultParse();
  }
}