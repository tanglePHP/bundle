<?php namespace tanglePHP\Network\Endpoint;

use tanglePHP\Network\Connect;
use tanglePHP\Network\Models\AbstractEndpoint;
use tanglePHP\Core\Exception\Api as ApiException;

/**
 * Class MarketServer
 *
 * @package      tanglePHP\Network\Endpoint
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1146
 */
final class MarketServer extends AbstractEndpoint {
  /**
   * @param Connect $network
   * @param string  $url
   * @param string  $basePath
   *
   * @throws ApiException
   */
  public function __construct(public Connect $network, public string $url = 'https://api.coingecko.com/', public string $basePath = 'api/v3/') {
    parent::__construct($this->network, $this->url, $this->basePath);
  }
}