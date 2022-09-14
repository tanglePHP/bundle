<?php namespace tanglePHP\FaucetClient\Api\v1\Response;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class Enqueue
 *
 * @package      tanglePHP\FaucetClient\Api\v1\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.05-1150
 */
final class Enqueue extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $address;
  /**
   * @var int
   */
  public int $waitingRequests;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}