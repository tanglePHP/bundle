<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response\Input;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class Treasury
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response\Input
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0824
 */
final class Treasury extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type;
  /**
   * @var string
   */
  public string $milestoneId;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    parent::defaultParse();
  }
}