<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class Output
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0829
 */
final class Output extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * Output constructor.
   *
   * @param int     $type
   * @param Address $address
   * @param int     $amount
   */
  public function __construct(public int $type, public Address $address, public int $amount) {
  }

  /**
   * @return array
   * @throws ConverterException
   */
  public function serialize(): array {
    $_ret   = [self::serializeInt($this->type)];
    $_ret   = array_merge($_ret, $this->address->serialize());
    $_ret[] = self::serializeBigInt($this->amount);

    return $_ret;
  }
}