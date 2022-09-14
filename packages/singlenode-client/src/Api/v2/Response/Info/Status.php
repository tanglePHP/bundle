<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response\Info;

use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class Status
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response\Info
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0824
 */
final class Status extends AbstractApiResponse {
  /**
   * @var bool
   */
  public bool $isHealthy;
  /**
   * @var ResponseArray
   */
  public ResponseArray $latestMilestone;
  /**
   * @var ResponseArray
   */
  public ResponseArray $confirmedMilestone;
  /**
   * @var int
   */
  public int $pruningIndex;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}