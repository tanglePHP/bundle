<?php namespace tanglePHP\SingleNodeClient\Models;

use tanglePHP\Core\Models\ResponseArray;

/**
 * Class ReturnAddressBalance
 *
 * @package      tanglePHP\SingleNodeClient\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0817
 */
final class ReturnAddressBalance extends AbstractReturn {
  /**
   * @var string
   */
  public string $balance = "0";
  /**
   * @var string
   */
  public string $addressBech32;
  /**
   * @var ResponseArray
   */
  public ResponseArray $nativeTokens;
  /**
   * @var int
   */
  public int $ledgerIndex;
  /**
   * @var int
   */
  public ResponseArray $filter;
  /**
   * @var ResponseArray
   */
  public ResponseArray $networkInfo;
}