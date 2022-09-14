<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class Metadata
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0823
 */
final class Metadata extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $blockId;
  /**
   * @var string
   */
  public string $transactionId;
  /**
   * @var int
   */
  public int $outputIndex;
  /**
   * @var bool
   */
  public bool $isSpent;
  /**
   * @var int
   */
  public int $milestoneIndexSpent;
  /**
   * @var int
   */
  public int $milestoneTimestampSpent;
  /**
   * @var string
   */
  public string $transactionIdSpent;
  /**
   * @var int
   */
  public int $milestoneIndexBooked;
  /**
   * @var int
   */
  public int $milestoneTimestampBooked;
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