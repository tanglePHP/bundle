<?php namespace tanglePHP\Network\Models;

use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Helper\ApiCaller;
use tanglePHP\Network\Connect;
use tanglePHP\SingleNodeClient\Connector as SingleNodeConnector;
use tanglePHP\FaucetClient\Connector as FaucetClientConnector;
use tanglePHP\MarketClient\Connector as MarketClientConnector;
use tanglePHP\ChronicleClient\Connector as ChronicleClientConnector;

/**
 * Class AbstractEndpoint
 *
 * @package      tanglePHP\Network\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1147
 */
abstract class AbstractEndpoint {
  /**
   * @var ApiCaller
   */
  public ApiCaller $API_CALLER;
  /**
   * @var int
   */
  public int $TIMEOUT = 30;
  /**
   * @var SingleNodeConnector|FaucetClientConnector|MarketClientConnector|ChronicleClientConnector
   */
  public SingleNodeConnector|FaucetClientConnector|MarketClientConnector|ChronicleClientConnector $connector;

  /**
   * @param Connect $network
   * @param string  $url
   * @param string  $basePath
   *
   * @throws ApiException
   */
  public function __construct(public Connect $network, public string $url, public string $basePath) {
    $this->url      .= (str_ends_with($this->url, '/') ? '' : '/');
    $this->basePath .= (str_ends_with($this->basePath, '/') ? '' : '/');
    $this->API_CALLER = (new ApiCaller($this->url))->basePath($this->basePath);
  }

  /**
   * @return void
   */
  public function init(): void {
  }

  /**
   * @param $name
   *
   * @return void
   * @throws HelperException
   */
  protected function needFeature($name): void {
    if(!in_array($name, $this->network->info['features'])) {
      throw new HelperException("Node doesn't support '$name', please connect to a node with '$name' feature.");
    }
  }

  /**
   * @param string $name
   * @param string $version
   *
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  protected function needPlugin(string $name, string $version): void {
    // v1 does not support plugins
    if($this->network->info['protocolVersion'] == '1') {
      return;
    }
    if(!isset($this->routes)) {
      $this->routes = ($this->connector->routes())->routes;
    }
    $full = $name . "/" . $version;
    if(!in_array($full, (array)$this->routes)) {
      throw new HelperException("Node doesn't support plugin '$full', please install/enable '$full' plugin.");
    }
  }
}