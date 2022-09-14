<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class PayloadIndexation
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0829
 */
final class PayloadIndexation extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 2;
  /**
   * @var string
   */
  public string $index = '';
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
    $this->index($index, $_convertToHex);
    $this->data($data, $_convertToHex);
  }

  /**
   * @param string $index
   * @param bool   $_convertToHex
   *
   * @return $this
   */
  public function index(string $index, bool $_convertToHex = true): self {
    $this->index = $_convertToHex ? Converter::string2Hex($index) : $index;

    return $this;
  }

  /**
   * @param string $index
   * @param bool   $_convertToHex
   *
   * @return $this
   */
  public function data(string $index, bool $_convertToHex = true): self {
    $this->data = $_convertToHex ? Converter::string2Hex($index) : $index;

    return $this;
  }

  /**
   * @return array
   * @throws \tanglePHP\Core\Exception\Converter
   */
  public function serialize(): array {
    $_buffer = [];
    // type
    $_buffer[] = pack("L", $this->type);
    // index
    $_buffer[] = self::serializeUInt16(strlen($this->index) / 2);
    $_buffer[] = self::serializeFixedHex($this->index);
    // data
    $_buffer[] = pack("L", (strlen($this->data) / 2));
    $_buffer[] = self::serializeFixedHex($this->data);
    // payload len
    return array_merge([pack("L", strlen(implode('', $_buffer)))], $_buffer);
  }
}