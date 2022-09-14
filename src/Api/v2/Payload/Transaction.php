<?php namespace tanglePHP\SingleNodeClient\Api\v2\Payload;

use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;
use tanglePHP\SingleNodeClient\Api\v2\Transaction\Essence;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class Transaction
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Payload
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0821
 */
final class Transaction extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 6;

  /**
   * @param Essence $essence
   * @param array   $unlocks
   */
  public function __construct(public Essence $essence, public array $unlocks = []) {
  }

  /**
   * @return array
   * @throws ConverterException
   */
  public function serialize(): array {
    // type
    $_ret = [self::serializeUInt32($this->type)];
    // essence
    $_ret = array_merge($_ret, $this->essence->serialize());
    // unlocks
    $_ret[] = self::serializeUInt16(count($this->unlocks));
    foreach($this->unlocks as $object) {
      $_ret = array_merge($_ret, $object->serialize());
    }

    return $_ret;
  }
}