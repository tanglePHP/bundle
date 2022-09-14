<?php namespace tanglePHP\SingleNodeClient\Api\v2\Output;

use tanglePHP\SingleNodeClient\Api\v2\Output;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class NFT
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Output
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0821
 */
final class NFT extends Output {
  /**
   * @var int
   */
  public int $type = 6;
  /**
   * @var string
   */
  public string $amount = "0";
  /**
   * @var array
   */
  public array $nativeTokens;
  /**
   * @var string
   */
  public string $nftId = "0x0000000000000000000000000000000000000000000000000000000000000000";
  /**
   * @var array
   */
  public array $unlockConditions;
  /**
   * @var array
   */
  public array $features;
  /**
   * @var array
   */
  public array $immutableFeatures;

  /**
   * @return array
   * @throws ConverterException
   */
  public function serialize(): array {
    $_ret = [];
    // type
    $_ret[] = self::serializeUInt8($this->type);
    // amount
    $_ret[] = self::serializeBigInt64($this->amount);
    // nativeTokens
    $_ret[] = self::serializeCountedObjectArray($this->nativeTokens ?? []);
    // nftId
    $_ret[] = self::serializeFixedHex($this->nftId);
    // unlockConditions
    $_ret[] = self::serializeCountedObjectArray($this->unlockConditions ?? []);
    // features
    $_ret[] = self::serializeCountedObjectArray($this->features ?? []);
    // immutableFeatures
    $_ret[] = self::serializeCountedObjectArray($this->immutableFeatures ?? []);

    return $_ret;
  }
}