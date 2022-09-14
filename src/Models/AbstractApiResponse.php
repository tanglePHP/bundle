<?php namespace tanglePHP\Core\Models;

use tanglePHP\Core\Exception\Helper as ExceptionHelper;
use tanglePHP\Core\Helper\JSON;

/**
 * Class AbstractApiResponse
 *
 * @package      tanglePHP\Core\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1649
 */
abstract class AbstractApiResponse extends AbstractApi {
  protected JSON $_input;

  /**
   * @param mixed $value
   *
   * @throws ExceptionHelper
   */
  public function __construct(mixed $value) {
    $this->_input = JSON::create($value);
    $this->parse();
  }

  /**
   * @return void
   */
  abstract protected function parse(): void;

  /**
   * @return void
   * @throws ExceptionHelper
   */
  protected function defaultParse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      if(is_array($_v)) {
        $_v = new ResponseArray($_v);
      }
      $this->{$_k} = $_v;
    }
  }
}