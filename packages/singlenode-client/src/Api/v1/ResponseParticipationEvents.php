<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ResponseParticipationEvents
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.10.06-0808
 */
final class ResponseParticipationEvents extends AbstractApiResponse {
  /**
   * @var ResponseArray
   */
  public ResponseArray $eventIds;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->_input = JSON::create($this->_input['data']);
    $this->defaultParse();
  }
}