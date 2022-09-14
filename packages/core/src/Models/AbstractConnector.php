<?php namespace tanglePHP\Core\Models;

use tanglePHP\Core\Helper\ApiCaller;
use tanglePHP\Network\Models\AbstractEndpoint;

/**
 * Class AbstractConnector
 *
 * @package      tanglePHP\Core\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1649
 */
abstract class AbstractConnector {
  /**
   * @var ApiCaller
   */
  public ApiCaller $API_CALLER;
  /**
   * @var PluginList
   */
  public PluginList $Plugin;
  /**
   * @var bool
   */
  protected bool $LOAD_PLUGINS = false;

  /**
   * @param AbstractEndpoint $ENDPOINT
   */
  public function __construct(public AbstractEndpoint $ENDPOINT) {
    $this->API_CALLER = $this->ENDPOINT->API_CALLER;
    //
    $this->Plugin = new PluginList();
    if($this->LOAD_PLUGINS) {
      $this->loadPlugins();
    }
    $this->onConstruct();
  }

  /**
   * @return void
   */
  public function onConstruct(): void {

  }

  /**
   * @return void
   */
  protected function loadPlugins(): void {
    if(!method_exists($this, 'routes')) {
      return;
    }
    //
    foreach(($this->routes())->routes as $plugin) {
      $split     = explode("/", $plugin);
      $className = 'tanglePHP\\' . ucfirst($split[0]) . 'Plugin\\' . $split[1];
      if(class_exists($className)) {
        $this->Plugin->load(new $className($this, $plugin), ucfirst($split[0]));
      }
    }
  }

  /**
   * @return string
   */
  public function getProtocolVersion(): string {
    return $this->ENDPOINT->network->info['protocolVersion'];
  }
}