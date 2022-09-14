<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response\Output;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class Basic
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response\Output
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0824
 */
final class Basic extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type;
  /**
   * @var string
   */
  public string $amount;
  /**
   * @var ResponseArray
   */
  public ResponseArray $nativeTokens;
  /**
   * @var ResponseArray
   */
  public ResponseArray $unlockConditions;
  /**
   * @var ResponseArray
   */
  public ResponseArray $features;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    parent::defaultParse();
  }
}