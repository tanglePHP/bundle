<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response\Info\Protocol;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class RentStructure
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response\Info\Protocol
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0825
 */
final class RentStructure extends AbstractApiResponse {
  /**
   * Defines the rent of a single virtual byte denoted in IOTA tokens.
   *
   * @var int
   */
  public int $vByteCost;
  /**
   * Defines the factor to be used for data only fields.
   *
   * @var int
   */
  public int $vByteFactorData;
  /**
   * Defines the factor to be used for key/lookup generating fields.
   *
   * @var int
   */
  public int $vByteFactorKey;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}