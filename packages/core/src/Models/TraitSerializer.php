<?php namespace tanglePHP\Core\Models;

use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Helper\Hash;
use SodiumException;
use tanglePHP\Core\Exception\Converter as ExceptionConverter;

/**
 * Trait TraitSerializer
 *
 * @package      tanglePHP\Core\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1648
 */
trait TraitSerializer {
  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeInt(string $value): string {
    return Converter::string2Int($value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeUInt8(string $value): string {
    return Converter::serializeUInt8($value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeUInt16(string $value): string {
    return Converter::serializeUInt16($value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeUInt32(string $value): string {
    return Converter::serializeUInt32($value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeUInt64(string $value): string {
    return Converter::serializeUInt64($value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeUInt256(string $value): string {
    return Converter::serializeUInt256($value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeBigInt(string $value): string {
    return Converter::serializeBigInt($value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeBigInt256(string $value): string {
    return Converter::serializeBigInt256($value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeBigInt64(string $value): string {
    return Converter::serializeBigInt64($value);
  }

  /**
   * @param string $value
   *
   * @return string
   * @throws ExceptionConverter
   */
  static public function serializeFixedHex(string $value): string {
    $value = Converter::remove0x($value);

    return Converter::hex2String($value);
  }

  /**
   * @param array|null $array
   *
   * @return string
   */
  static public function serializeCountedObjectArray(?array $array): string {
    $_ret = [];
    if(isset($array)) {
      $_ret[] = self::serializeUInt8(count($array));
      foreach($array as $object) {
        $_ret = array_merge($_ret, $object->serialize());
      }
    }
    else {
      $_ret[] = self::serializeUInt8(0);
    }

    return implode('', $_ret);
  }

  /**
   * @return string
   * @throws ExceptionConverter
   */
  public function serializeToHex(): string {
    return Converter::string2Hex(implode('', $this->serialize()));
  }

  /**
   * @return string
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  public function serializeToHash(): string {
    $hex = self::serializeToHex();

    //$hex = str_pad($_ret, 256, '0');
    return Converter::string2Hex(Hash::blake2b_sum256(Converter::hex2String($hex)));
  }
}