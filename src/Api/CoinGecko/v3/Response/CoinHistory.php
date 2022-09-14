<?php namespace tanglePHP\MarketClient\Api\CoinGecko\v3\Response;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class CoinHistory
 *
 * @package      tanglePHP\MarketClient\Api\CoinGecko\v3\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.22-1218
 */
final class CoinHistory extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $id;
  /**
   * @var string
   */
  public string $symbol;
  /**
   * @var string
   */
  public string $name;
  /**
   * @var ResponseArray
   */
  public ResponseArray $localization;
  /**
   * @var ResponseArray
   */
  public ResponseArray $image;
  /**
   * @var ResponseArray
   */
  public ResponseArray $market_data;
  /**
   * @var ResponseArray
   */
  public ResponseArray $community_data;
  /**
   * @var ResponseArray
   */
  public ResponseArray $developer_data;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}