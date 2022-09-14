<?php namespace tanglePHP\SingleNodeClient\Api\v2\Feature;

use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class Tag
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Feature
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0821
 */
final class Tag extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 3;

  /**
   * @param string $tag
   */
  public function __construct(public string $tag) {

  }

  /**
   * @return array
   * @throws ConverterException
   */
  public function serialize(): array {
    $_ret   = [];
    $_ret[] = self::serializeUInt8($this->type);
    $_ret[] = self::serializeUInt8(strlen(Converter::remove0x($this->tag)) / 2);
    $_ret[] = self::serializeFixedHex($this->tag);

    return $_ret;
  }
}