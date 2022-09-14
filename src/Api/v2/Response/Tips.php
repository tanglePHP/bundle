<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Models\ResponseArray;

/**
 * Class Tips
 *
 * @package      tanglePHP\singlenode-client\Api\v2\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.22-1130
 */
final class Tips extends AbstractApiResponse {
  /**
   * @var ResponseArray
   */
  public ResponseArray $tips;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}