<?php namespace tanglePHP\SingleNodeClient\Api\v2;

use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class NativeToken
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0818
 */
final class NativeToken extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @param string $id
   * @param string $amount
   */
  public function __construct(public string $id, public string $amount) {
  }

  /**
   * @return array
   * @throws ConverterException
   */
  public function serialize(): array {
    $_ret = [];
    // type
    $_ret[] = self::serializeFixedHex($this->id);
    // amount
    $_ret[] = self::serializeBigInt256(Converter::hex2decimal(Converter::remove0x($this->amount)));

    return $_ret;
  }
}