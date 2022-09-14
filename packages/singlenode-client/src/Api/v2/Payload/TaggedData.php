<?php namespace tanglePHP\SingleNodeClient\Api\v2\Payload;

use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;
use function strlen;

/**
 * Class TaggedData
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Payload
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0820
 */
final class TaggedData extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 5;
  /**
   * @var string
   */
  public string $tag = '';
  /**
   * @var string
   */
  public string $data = '';

  /**
   * PayloadIndexation constructor.
   *
   * @param string $index
   * @param string $data
   * @param bool   $_convertToHex
   */
  public function __construct(string $index = '', string $data = '', bool $_convertToHex = true) {
    $this->tag($index, $_convertToHex);
    $this->data($data, $_convertToHex);
  }

  /**
   * The indexation key to allow external tools to find/look up this block. It has a size between 1 and 64 bytes and must be encoded as a hex-string with 0x prefix.
   *
   * @param string $string
   * @param bool   $_convertToHex
   *
   * @return $this
   */
  public function tag(string $string, bool $_convertToHex = true): self {
    $this->tag = Converter::HexString0x(($_convertToHex ? Converter::string2Hex($string) : $string));

    return $this;
  }

  /**
   * The optional data to attach. This may have a length of 0. Hex-encoded with 0x prefix.
   *
   * @param string $string
   * @param bool   $_convertToHex
   *
   * @return $this
   */
  public function data(string $string, bool $_convertToHex = true): self {
    $this->data = Converter::HexString0x(($_convertToHex ? Converter::string2Hex($string) : $string));

    return $this;
  }

  /**
   * @return array
   * @throws \tanglePHP\Core\Exception\Converter
   */
  public function serialize(): array {
    $_buffer = [];
    // type
    $_buffer[] = self::serializeUInt32($this->type);
    // index
    $_buffer[] = self::serializeUInt8(strlen(Converter::remove0x($this->tag)) / 2);
    $_buffer[] = self::serializeFixedHex($this->tag);
    // data
    $_buffer[] = self::serializeUInt32(strlen(Converter::remove0x($this->data)) / 2);
    $_buffer[] = self::serializeFixedHex($this->data);


    // payload len
    return array_merge([self::serializeUInt32(strlen(implode('', $_buffer)))], $_buffer);
  }
}