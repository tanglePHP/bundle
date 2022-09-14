<?php namespace tanglePHP\SingleNodeClient\Api\v2\Output;

use tanglePHP\SingleNodeClient\Api\v2\Output;

/**
 * Class Basic
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Output
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0820
 */
final class Basic extends Output {
  /**
   * @var int
   */
  public int $type = 3;
  /**
   * @var string
   */
  public string $amount = "0";
  /**
   * @var array
   */
  public array $nativeTokens;
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
   */
  public function serialize(): array {
    $_ret = [];
    // type
    $_ret[] = self::serializeUInt8($this->type);
    // amount
    $_ret[] = self::serializeBigInt64($this->amount);
    // nativeTokens
    $_ret[] = self::serializeCountedObjectArray($this->nativeTokens ?? []);
    // unlockConditions
    $_ret[] = self::serializeCountedObjectArray($this->unlockConditions ?? []);
    // features
    $_ret[] = self::serializeCountedObjectArray($this->features ?? []);

    return $_ret;
  }
}