<?php namespace tanglePHP\SingleNodeClient\Api\v2\Feature;

use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class Metadata
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Feature
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0821
 */
final class Metadata extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 2;

  /**
   * @param string $data
   */
  public function __construct(public string $data) {

  }

  /**
   * @return array
   * @throws ConverterException
   */
  public function serialize(): array {
    $_ret   = [];
    $_ret[] = self::serializeUInt8($this->type);
    $_ret[] = self::serializeUInt16(strlen(Converter::remove0x($this->data)) / 2);
    $_ret[] = self::serializeFixedHex($this->data);

    return $_ret;
  }
}