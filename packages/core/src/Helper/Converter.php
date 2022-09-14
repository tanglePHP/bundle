<?php namespace tanglePHP\Core\Helper;

use tanglePHP\Core\Crypto\Bech32;
use tanglePHP\Core\Exception\Crypto as CryptoException;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class Converter
 *
 * @package      tanglePHP\Core\Helper
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1652
 */
final class Converter {
  /**
   * @param string $val
   * @param bool   $reverse
   *
   * @return string
   */
  static public function string2Hex(string $val, bool $reverse = false): string {
    $ret = bin2hex($val);

    return $reverse ? self::reverseHex($ret) : $ret;
  }

  /**
   * @param string $val
   *
   * @return string
   */
  static public function hex2decimal(string $val): string {
    return hexdec($val);
  }

  /**
   * @param string $val
   *
   * @return string
   */
  static public function decimal2Hex(string $val): string {
    return dechex($val);
  }

  /**
   * @param string $val
   *
   * @return string
   */
  static public function decimal2Hex0x(string $val): string {
    return self::add0x(self::decimal2Hex($val));
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function string2Int(string $value): string {
    return pack("C", $value);
  }

  /**
   * @param string $val
   *
   * @return string|false
   * @throws ConverterException
   */
  static public function hex2String(string $val): string|false {
    if(!self::isHex($val)) {
      throw new ConverterException("Input string must be hexadecimal string, given: '$val'");
    }

    return hex2bin($val);
  }

  /**
   * @param string $val
   *
   * @return int
   * @throws ConverterException
   */
  static public function hex2Int(string $val): int {
    if(!self::isHex($val)) {
      throw new ConverterException("Input string must be hexadecimal string");
    }

    return (int)hexdec($val);
  }

  /**
   * @param string $val
   *
   * @return string
   */
  static public function bits2Hex(string $val): string {
    $_hex = "";
    foreach(str_split($val, 4) as $_chunk) {
      $_hex .= base_convert($_chunk, 2, 16);
    }

    return $_hex;
  }

  /**
   * @param string $val
   *
   * @return string
   * @throws ConverterException
   */
  static public function hex2Bits(string $val): string {
    if(!self::isHex($val)) {
      throw new ConverterException("Input string must be hexadecimal string");
    }
    $_bits = "";
    for($i = 0; $i < strlen($val); $i++) {
      $_bits .= str_pad(base_convert($val[$i], 16, 2), 4, '0', STR_PAD_LEFT);
    }

    return $_bits;
  }

  /**
   * @param string $val
   *
   * @return array
   * @throws ConverterException
   */
  static public function hex2ByteArray(string $val): array {
    if(!self::isHex($val)) {
      throw new ConverterException("Input string must be hexadecimal string");
    }
    $_bin = hex2bin($val);

    return unpack('C*', $_bin);
  }

  /**
   * @param array $data
   *
   * @return string
   */
  static public function byteArray2Hex(array $data): string {
    $_chars = array_map("chr", $data);
    $_bin   = join($_chars);

    return bin2hex($_bin);
  }

  /**
   * @param string $val
   *
   * @return array
   */
  static function string2ByteArray(string $val): array {
    return unpack('C*', $val);
  }

  /**
   * @param array $data
   *
   * @return string
   */
  static function byteArray2String(array $data): string {
    $_chars = array_map("chr", $data);

    return join($_chars);
  }

  /**
   * @param string $val
   *
   * @return string
   */
  static public function base64_encode(string $val): string {
    return base64_encode($val);
  }

  /**
   * @param string $val
   * @param bool   $strict
   *
   * @return string|false
   */
  static public function base64_decode(string $val, bool $strict = false): string|false {
    return base64_decode($val, $strict);
  }

  /**
   * @param string $val
   * @param string $alphabet
   *
   * @return string
   * @throws ConverterException
   */
  static public function base58_encode(string $val, string $alphabet = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz"): string {
    $val          = Converter::isHex($val) ? Converter::hex2String($val) : $val;
    $alphabet_len = strlen($alphabet);
    if(strlen($val) === 0) {
      return '';
    }
    $bytes   = array_values(unpack('C*', $val));
    $decimal = $bytes[0];
    for($i = 1, $l = count($bytes); $i < $l; $i++) {
      $decimal = bcmul($decimal, 256);
      $decimal = bcadd($decimal, $bytes[$i]);
    }
    $output = '';
    while($decimal >= $alphabet_len) {
      $div     = bcdiv($decimal, $alphabet_len);
      $mod     = (int)bcmod($decimal, $alphabet_len);
      $output  .= $alphabet[$mod];
      $decimal = $div;
    }
    if($decimal > 0) {
      $output .= $alphabet[$decimal];
    }
    $output = strrev($output);
    foreach($bytes as $byte) {
      if($byte === 0) {
        $output = $alphabet[0] . $output;
        continue;
      }
      break;
    }

    return $output;
  }

  /**
   * @param string $val
   * @param string $alphabet
   *
   * @return string
   * @throws ConverterException
   */
  static public function base58_decode(string $val, string $alphabet = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz"): string {
    $alphabet_len = strlen($alphabet);
    if(strlen($val) === 0) {
      return '';
    }
    $indexes = array_flip(str_split($alphabet));
    $chars   = str_split($val);
    //
    foreach($chars as $char) {
      if(isset($indexes[$char]) === false) {
        throw new ConverterException('Invalid characters ($char: "' . $char . '", $val: "' . $val . '") ');
      }
    }
    $decimal = $indexes[$chars[0]];
    for($i = 1, $l = count($chars); $i < $l; $i++) {
      $decimal = bcmul($decimal, $alphabet_len);
      $decimal = bcadd($decimal, $indexes[$chars[$i]]);
    }
    $output = '';
    while($decimal > 0) {
      $byte    = (int)bcmod($decimal, 256);
      $output  = pack('C', $byte) . $output;
      $decimal = bcdiv($decimal, 256);
    }
    foreach($chars as $char) {
      if($indexes[$char] === 0) {
        $output = "\x00" . $output;
        continue;
      }
      break;
    }

    return $output;
  }

  /**
   * @param array $data
   * @param int   $inLen
   * @param int   $fromBits
   * @param int   $toBits
   * @param bool  $_pad
   *
   * @return array
   * @throws ConverterException
   */
  static public function bits(array $data, int $inLen, int $fromBits, int $toBits, bool $_pad = true): array {
    $_acc    = 0;
    $_bits   = 0;
    $_ret    = [];
    $_maxv   = (1 << $toBits) - 1;
    $_maxacc = (1 << ($fromBits + $toBits - 1)) - 1;
    for($_i = 0; $_i < $inLen; $_i++) {
      $_value = $data[$_i];
      if($_value < 0 || $_value >> $fromBits) {
        throw new ConverterException('Invalid value for convert bits');
      }
      $_acc  = (($_acc << $fromBits) | $_value) & $_maxacc;
      $_bits += $fromBits;
      while($_bits >= $toBits) {
        $_bits  -= $toBits;
        $_ret[] = (($_acc >> $_bits) & $_maxv);
      }
    }
    if($_pad) {
      if($_bits) {
        $_ret[] = ($_acc << $toBits - $_bits) & $_maxv;
      }
    }
    else if($_bits >= $fromBits || ((($_acc << ($toBits - $_bits))) & $_maxv)) {
      throw new ConverterException('Invalid data');
    }

    return $_ret;
  }

  /**
   * @param mixed $val
   *
   * @return bool
   */
  static public function isHex(string $val): bool {
    return ctype_xdigit(self::remove0x($val));
  }

  /**
   * @param mixed $val
   *
   * @return bool
   */
  static public function isNumeric(mixed $val): bool {
    return is_numeric($val);
  }

  /**
   * @param mixed $val
   *
   * @return bool
   */
  public static function isUtf8(mixed $val): bool {
    return is_string($val) && strlen($val) !== mb_strlen($val);
  }

  /**
   * @param mixed $val
   *
   * @return bool
   */
  static public function isBitwise(mixed $val): bool {
    return is_string($val) && preg_match('/^[01]+$/', $val);
  }

  /**
   * @param mixed $val
   *
   * @return bool
   */
  static public function isBase64(mixed $val): bool {
    return is_string($val) && preg_match('/^[a-z0-9+\/]+={0,2}$/i', $val);
  }

  /**
   * @param mixed $val
   *
   * @return bool
   */
  static public function isBase16(mixed $val): bool {
    return is_string($val) && preg_match('/^(0x)?[a-f0-9]+$/i', $val);
  }

  /**
   * @param string $string
   *
   * @return bool
   */
  static public function isJSON(string $string): bool {
    return is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE);
  }

  /**
   * @param string $string
   *
   * @return bool
   */
  static public function isBinary(string $string): bool {
    return preg_match('~[^\x20-\x7E\t\r\n]~', $string) > 0;
  }

  /**
   * @param string $string
   *
   * @return string
   */
  static public function HexString0x(string $string): string {
    if(!self::isHex($string)) {
      $string = self::string2Hex($string);
    }

    return self::add0x($string);
  }

  /**
   * @param string $string
   *
   * @return string
   */
  static public function add0x(string $string): string {
    if(!str_starts_with($string, '0x')) {
      return '0x' . $string;
    }

    return $string;
  }

  /**
   * @param string $string
   *
   * @return string
   */
  static public function remove0x(string $string): string {
    if(str_starts_with($string, "0x")) {
      return substr($string, 2);
    }

    return $string;
  }

  /**
   * @param string $addressEd25519
   * @param string $hrp
   * @param int    $addressType
   *
   * @return string
   * @throws ConverterException
   */
  static public function ed25519ToBech32(string $addressEd25519, string $hrp, int $addressType = 0): string {
    $data = self::hex2byteArray($addressEd25519);
    array_unshift($data, $addressType);

    return Bech32::encode($hrp, self::bits($data, count($data), 8, 5));
  }

  /**
   * @param string $address
   * @param string $hrp
   * @param int    $addressType
   *
   * @return string
   * @throws ConverterException
   */
  static public function addressToBech32(string $address, string $hrp, int $addressType = 0): string {
    if(str_starts_with($address, '0x')) {
      $address = self::ed25519ToBech32(Converter::remove0x($address), $hrp, $addressType);
    }
    elseif(!str_starts_with($address, $hrp)) {
      // check if address is ed25519 without 0x
      if(self::isHex($address)) {
        $address = self::ed25519ToBech32($address, $hrp, $addressType);
      }
      else {
        throw new ConverterException("Unknown or not valid address '$address'");
      }
    }

    return $address;
  }

  /**
   * @param $addressBech32
   *
   * @return string
   * @throws ConverterException
   * @throws CryptoException
   */
  static public function bech32ToEd25519($addressBech32): string {
    $data = Bech32::decode($addressBech32)[1];

    return substr(self::byteArray2Hex(self::bits($data, count($data), 5, 8, false)), 2);
  }

  /**
   * @param string $val
   *
   * @return string
   */
  static public function reverseHex(string $val): string {
    $a = str_split($val, 2);
    $a = array_reverse($a);

    return implode("", $a);
  }

  /**
   * @param array $input
   *
   * @return array
   */
  static public function canonicalize(array $input): array {
    ksort($input);
    foreach($input as $k => $v) {
      $ret[$k] = is_array($v) ? self::canonicalize($v) : stripslashes($v);
    }

    return $ret ?? [];
  }

  /**
   * @param string|array $input
   *
   * @return string
   */
  static public function canonicalizeJSON(string|array $input): string {

    return stripslashes(json_encode(self::canonicalize(is_string($input) ? json_decode($input, true) : $input)));
  }

  /**
   * @param $dst
   * @param $a
   * @param $b
   *
   * @return string|int
   */
  static public function XORBytes($dst, $a, $b): string|int {
    $n = min(strlen($b), strlen($a));
    if($n == 0) {
      return 0;
    }
    for($i = 0; $i < $n; $i++) {
      $dst[$i] = $a[$i] ^ $b[$i];
    }

    return $dst;
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeInt(string $value): string {
    return pack("C", $value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeUInt8(string $value): string {
    return pack("C", $value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeUInt16(string $value): string {
    return pack("S", $value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeUInt32(string $value): string {
    return pack("L", $value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeUInt64(string $value): string {
    return pack("Q", $value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeUInt256(string $value): string {
    return pack("H*", str_pad($value, 256 / 4, '0', STR_PAD_LEFT));
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeBigInt(string $value): string {
    return pack("P", $value);
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeBigInt256(string $value): string {
    $pack = self::string2Hex(pack("P", $value));

    return pack("H*", str_pad($pack, 256 / 4, '0', STR_PAD_RIGHT));
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeBigInt64(string $value): string {
    $pack = self::string2Hex(pack("P", $value));

    return pack("H*", str_pad($pack, 256 / 4 / 4, '0', STR_PAD_RIGHT));
  }

  /**
   * @param string $value
   *
   * @return string
   */
  static public function serializeFixedHex(string $value): string {
    return hex2bin($value);
  }

  /**
   * @param string $plaintext
   * @param string $password
   * @param string $method
   *
   * @return string
   */
  static function encrypt(string $plaintext, string $password, string $method = 'AES-256-CBC'): string {
    $key        = hash('sha256', $password, true);
    $iv         = openssl_random_pseudo_bytes(16);
    $ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
    $hash       = hash_hmac('sha256', $ciphertext . $iv, $key, true);

    return base64_encode($iv . $hash . $ciphertext);
  }

  /**
   * @param string $encryptedText
   * @param string $password
   * @param string $method
   *
   * @return string|false|null
   */
  static function decrypt(string $encryptedText, string $password, string $method = 'AES-256-CBC'): string|null|false {
    $encryptedText = base64_decode($encryptedText);
    $iv            = substr($encryptedText, 0, 16);
    $hash          = substr($encryptedText, 16, 32);
    $ciphertext    = substr($encryptedText, 48);
    $key           = hash('sha256', $password, true);
    if(!hash_equals(hash_hmac('sha256', $ciphertext . $iv, $key, true), $hash)) {
      return null;
    }

    return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
  }
}