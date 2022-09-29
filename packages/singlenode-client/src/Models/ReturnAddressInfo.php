<?php namespace tanglePHP\SingleNodeClient\Models;

use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ReturnAddressInfo
 *
 * @package      tanglePHP\SingleNodeClient\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.23-1016
 */
final class ReturnAddressInfo extends AbstractReturn {
  /**
   * @var string
   */
  public string $addressFrom;
  /**
   * @var string
   */
  public string $addressTo;
  /**
   * @var string
   */
  public string $amount;
  /**
   * @var int
   */
  public int $milestoneIndexBooked;
  /**
   * @var int
   */
  public int $milestoneTimestampBooked;
  /**
   * @var string
   */
  public string $datetime;
  /**
   * @var string
   */
  public string $blockId;
  /**
   * @var string
   */
  public string $transactionId;
  /**
   * @var false|string
   */
  public false|string $explorerUrl = false;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}