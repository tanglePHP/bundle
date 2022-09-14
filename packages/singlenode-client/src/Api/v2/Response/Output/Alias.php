<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response\Output;

use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class Alias
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response\Output
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0824
 */
final class Alias extends AbstractApiResponse {
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
   * @var string
   */
  public string $aliasId;
  /**
   * @var int
   */
  public int $stateIndex;
  /**
   * @var string
   */
  public string $stateMetadata;
  /**
   * @var int
   */
  public int $foundryCounter;
  /**
   * @var ResponseArray
   */
  public ResponseArray $unlockConditions;
  /**
   * @var ResponseArray
   */
  public ResponseArray $features;
  /**
   * @var ResponseArray
   */
  public ResponseArray $immutableFeatures;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    parent::defaultParse();
  }
}