<?php namespace tanglePHP\ChronicleClient\Api\v2\Response;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\AbstractApiResponse;

/**
 * Class Balance
 *
 * @package      tanglePHP\ChronicleClient\Api\v2\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1213
 */
final class Balance extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $totalBalance;
  /**
   * @var int
   */
  public int $sigLockedBalance;
  /**
   * @var int
   */
  public int $ledgerIndex;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}