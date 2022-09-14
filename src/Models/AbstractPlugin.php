<?php namespace tanglePHP\Core\Models;
/**
 * Class AbstractPlugin
 *
 * @package      tanglePHP\Core\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1649
 */
abstract class AbstractPlugin {
  /**
   * @param AbstractConnector $Connector
   * @param string            $route
   */
  public function __construct(public AbstractConnector $Connector, protected string $route) {
    $this->route = '/api/' .$this->route . '/';
  }
}