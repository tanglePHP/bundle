<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ResponsePayloadTreasuryTransaction
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0827
 */
final class ResponsePayloadTreasuryTransaction extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type = 4;
  /**
   * @var array
   */
  public array $input;
  /**
   * @var array
   */
  public array $output;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}