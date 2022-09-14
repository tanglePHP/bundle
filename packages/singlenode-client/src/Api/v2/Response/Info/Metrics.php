<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response\Info;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class Metrics
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response\Info
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0824
 */
final class Metrics extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $blocksPerSecond;
  /**
   * @var string
   */
  public string $referencedBlocksPerSecond;
  /**
   * @var string
   */
  public string $referencedRate;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}