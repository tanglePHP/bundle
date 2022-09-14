<?php namespace tanglePHP\SingleNodeClient\Api;

use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Models\AbstractApiResponse;

/**
 * Class Routes
 *
 * @package      tanglePHP\SingleNodeClient\Api
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0818
 */
final class Routes extends AbstractApiResponse {
  /**
   * @var ResponseArray
   */
  public ResponseArray $routes;

  /**
   *
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}