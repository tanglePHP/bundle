<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response\Output;

use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class NFT
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response\Output
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0824
 */
final class NFT extends AbstractApiResponse {
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
  public string $nftId;
  /**
   * @var string|null
   */
  public ?string $nftId_bech32;
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