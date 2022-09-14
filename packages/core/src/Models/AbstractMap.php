<?php namespace tanglePHP\Core\Models;

use tanglePHP\Core\Exception\Helper as ExceptionHelper;
use tanglePHP\Core\Helper\JSON;

/**
 * Class AbstractMap
 *
 * @package      tanglePHP\Core\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1649
 */
abstract class AbstractMap {
  /**
   * @return JSON
   * @throws ExceptionHelper
   */
  public function __toJSON(): JSON {
    return new JSON(json_encode($this));
  }

  /**
   * @return array
   * @throws ExceptionHelper
   */
  public function __toArray(): array {
    return ($this->__toJSON())->__toArray();
  }

  /**
   * @return string
   * @throws ExceptionHelper
   */
  public function __toString(): string {
    return (string)$this->__toJSON();
  }
}