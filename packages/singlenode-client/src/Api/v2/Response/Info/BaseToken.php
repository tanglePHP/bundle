<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response\Info;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class BaseToken
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response\Info
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0824
 */
final class BaseToken extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $name;
  /**
   * @var string
   */
  public string $tickerSymbol;
  /**
   * @var string
   */
  public string $unit;
  /**
   * @var string
   */
  public string $subunit;
  /**
   * @var int
   */
  public int $decimals;
  /**
   * @var bool
   */
  public bool $useMetricPrefix;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}