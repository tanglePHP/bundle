<?php namespace tanglePHP\Core\Models;

use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ResponseArray
 *
 * @package      tanglePHP\Core\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1648
 */
final class ResponseArray extends AbstractApiResponse {
  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}