<?php namespace tanglePHP\SingleNodeClient\Api\v2;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\AbstractApiResponse;

/**
 * Class Response
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0818
 */
final class Response extends AbstractApiResponse {
  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}