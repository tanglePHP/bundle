<?php namespace tanglePHP\MarketClient\Api\CoinGecko\v3\Response;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\AbstractApiResponse;

/**
 * Class Price
 *
 * @package      tanglePHP\MarketClient\Api\CoinGecko\v3\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.22-1216
 */
final class Price extends AbstractApiResponse {
  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}