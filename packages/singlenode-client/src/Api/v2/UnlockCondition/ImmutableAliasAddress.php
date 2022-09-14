<?php namespace tanglePHP\SingleNodeClient\Api\v2\UnlockCondition;

use tanglePHP\SingleNodeClient\Api\v2\Address\Alias;
use tanglePHP\Core\Exception\Converter;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class ImmutableAliasAddress
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\UnlockCondition
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0819
 */
final class ImmutableAliasAddress extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 6;

  /**
   * @param Alias $address
   */
  public function __construct(public Alias $address) {

  }

  /**
   * @return array
   * @throws Converter
   */
  public function serialize(): array {
    return array_merge([self::serializeUInt8($this->type)], $this->address->serialize());
  }
}