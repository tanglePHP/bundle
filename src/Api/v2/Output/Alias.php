<?php namespace tanglePHP\SingleNodeClient\Api\v2\Output;

use tanglePHP\Core\Helper\Converter;
use tanglePHP\SingleNodeClient\Api\v2\Output;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class Alias
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Output
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0820
 */
final class Alias extends Output {
  /**
   * @var int
   */
  public int $type = 4;
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
  public string $aliasId = "0x0000000000000000000000000000000000000000000000000000000000000000";
  /**
   * @var int
   */
  public int $stateIndex = 0;
  /**
   * @var string
   */
  public string $stateMetadata;
  /**
   * @var int
   */
  public int $foundryCounter = 0;
  /**
   * @var array
   */
  public array $immutableFeatures;
  /**
   * @var array
   */
  public array $unlockConditions;
  /**
   * @var array
   */
  public array $features;

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
    $_ret[] = self::serializeCountedObjectArray($this->nativeTokens  ?? []);
    // aliasId
    $_ret[] = self::serializeFixedHex($this->aliasId);
    // stateIndex
    $_ret[] = self::serializeUInt32($this->stateIndex);
    // stateMetadata
    if(isset($this->stateMetadata)) {
      $_ret[] = self::serializeUInt16(strlen(Converter::remove0x($this->stateMetadata)) / 2);
      if(strlen($this->stateMetadata) > 0) {
        $_ret[] = self::serializeFixedHex($this->stateMetadata);
      }
    }
    else {
      $_ret[] = self::serializeUInt16(0);
    }
    // foundryCounter
    $_ret[] = self::serializeUInt32($this->foundryCounter);
    // unlockConditions
    $_ret[] = self::serializeCountedObjectArray($this->unlockConditions ?? []);
    // features
    $_ret[] = self::serializeCountedObjectArray($this->features ?? []);
    // immutableFeatures
    $_ret[] = self::serializeCountedObjectArray($this->immutableFeatures ?? []);

    return $_ret;
  }
}