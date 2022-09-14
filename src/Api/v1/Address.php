<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class Address
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0829
 */
final class Address extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * Address constructor.
   *
   * @param int    $type
   * @param string $address
   */
  public function __construct(public int $type, public string $address) {
  }

  /**
   * @return array
   * @throws ConverterException
   */
  public function serialize(): array {
    return [
      self::serializeInt($this->type),
      self::serializeFixedHex($this->address),
    ];
  }
}