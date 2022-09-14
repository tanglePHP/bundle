<?php namespace tanglePHP\MarketClient\Api\CoinGecko\v3\Response;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class CoinMarketChart
 *
 * @package      tanglePHP\MarketClient\Api\CoinGecko\v3\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.22-1217
 */
final class CoinMarketChart extends AbstractApiResponse {
  public ResponseArray $prices;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}