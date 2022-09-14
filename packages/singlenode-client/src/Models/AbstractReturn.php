<?php namespace tanglePHP\SingleNodeClient\Models;

use tanglePHP\Core\Exception\Helper as ExceptionHelper;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Network\Connect;

/**
 * Class AbstractReturn
 *
 * @package      tanglePHP\SingleNodeClient\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0817
 */
abstract class AbstractReturn extends AbstractApiResponse {

  /**
   * @param mixed   $value
   * @param Connect $network
   *
   * @throws ExceptionHelper
   */
  public function __construct(mixed $value, Connect $network) {
    parent::__construct($value);
    $this->networkInfo = new ResponseArray($network->info);
  }

  /**
   * @return void
   * @throws ExceptionHelper
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}