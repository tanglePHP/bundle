<?php namespace tanglePHP\SingleNodeClient\Api\v2\Output;

use tanglePHP\SingleNodeClient\Api\v2\Output;
use tanglePHP\SingleNodeClient\Api\v2\TokenScheme;

/**
 * Class Foundry
 *
 * @package      tanglePHP\singlenode-client\Api\v2\Output
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.29-1646
 */
final class Foundry extends Output {
  /**
   * @var int
   */
  public int $type = 5;
  /**
   * @var string
   */
  public string $amount = "0";
  /**
   * @var array
   */
  public array $nativeTokens;
  /**
   * @var int
   */
  public int $serialNumber = 0;
  /**
   * @var TokenScheme
   */
  public TokenScheme $tokenScheme;
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
   */
  public function serialize(): array {
    $_ret = [];
    // type
    $_ret[] = self::serializeUInt8($this->type);
    // amount
    $_ret[] = self::serializeBigInt64($this->amount);
    // nativeTokens
    $_ret[] = self::serializeCountedObjectArray($this->nativeTokens ?? []);
    // serialNumber
    $_ret[] = self::serializeUInt32($this->serialNumber);
    // tokenScheme
    $_ret = array_merge($_ret, $this->tokenScheme->serialize());
    // unlockConditions
    $_ret[] = self::serializeCountedObjectArray($this->unlockConditions ?? []);
    // features
    $_ret[] = self::serializeCountedObjectArray($this->features ?? []);
    // immutableFeatures
    $_ret[] = self::serializeCountedObjectArray($this->immutableFeatures ?? []);

    return $_ret;
  }
}