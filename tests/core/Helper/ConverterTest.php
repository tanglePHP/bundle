<?php namespace tanglePHP\bundle\tests\core\Helper;
require_once "./autoload.php";

use PHPUnit\Framework\TestCase;
use tanglePHP\Core\Helper\Converter;

/**
 * Class ConverterTest
 *
 * @package      tanglePHP\bundle\tests\core\Crypto
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.23-0817
 */
final class ConverterTest extends TestCase {
  /**
   * @var string
   */
  protected string $str = "follow me on Twitter @tanglePHP";
  /**
   * @var string
   */
  protected string $hex = "666f6c6c6f77206d65206f6e2054776974746572204074616e676c65504850";
  /**
   * @var string
   */
  protected string $hexReverse = "504850656c676e6174402072657474697754206e6f20656d20776f6c6c6f66";
  /**
   * @var string
   */
  protected string $bits = "01100110011011110110110001101100011011110111011100100000011011010110010100100000011011110110111000100000010101000111011101101001011101000111010001100101011100100010000001000000011101000110000101101110011001110110110001100101010100000100100001010000";
  /**
   * @var array|int[]
   */
  protected array $byteArray8bits = [
    1  => 102,
    2  => 111,
    3  => 108,
    4  => 108,
    5  => 111,
    6  => 119,
    7  => 32,
    8  => 109,
    9  => 101,
    10 => 32,
    11 => 111,
    12 => 110,
    13 => 32,
    14 => 84,
    15 => 119,
    16 => 105,
    17 => 116,
    18 => 116,
    19 => 101,
    20 => 114,
    21 => 32,
    22 => 64,
    23 => 116,
    24 => 97,
    25 => 110,
    26 => 103,
    27 => 108,
    28 => 101,
    29 => 80,
    30 => 72,
    31 => 80,
  ];
  /**
   * @var array|int[]
   */
  protected array $byteArray5bits = [
    0  => 0,
    1  => 1,
    2  => 19,
    3  => 6,
    4  => 30,
    5  => 27,
    6  => 3,
    7  => 12,
    8  => 13,
    9  => 29,
    10 => 27,
    11 => 18,
    12 => 0,
    13 => 27,
    14 => 11,
    15 => 5,
    16 => 4,
    17 => 1,
    18 => 23,
    19 => 22,
    20 => 28,
    21 => 8,
    22 => 2,
    23 => 20,
    24 => 14,
    25 => 29,
    26 => 20,
    27 => 23,
    28 => 8,
    29 => 29,
    30 => 3,
    31 => 5,
    32 => 14,
    33 => 8,
    34 => 16,
    35 => 4,
    36 => 0,
    37 => 29,
    38 => 3,
    39 => 1,
    40 => 13,
    41 => 25,
    42 => 19,
    43 => 22,
    44 => 24,
    45 => 25,
    46 => 10,
    47 => 16,
    48 => 9,
    49 => 1,
    50 => 8,
    51 => 0,
  ];
  /**
   * @var string
   */
  protected string $base64 = "Zm9sbG93IG1lIG9uIFR3aXR0ZXIgQHRhbmdsZVBIUA==";
  /**
   * @var string
   */
  protected string $base58 = "2ZbU4qxfeRHySHGwj8HdR7Jjhi3ZfwNpQazDGsd11Tm";
  /**
   * @var string
   */
  protected string $json = '{"data": "follow me on Twitter @tanglePHP"}';
  /**
   * @var string
   */
  protected string $binary = b'��$�p��ch�wl�����q){! u��J+ޑ����[BS�0:â���U�����~D�%�������P��0d�F�G�3�n~v��&�櫁D      	 #tanglePHP1   message test! follow me on Twitter @tanglePHPYM     ';
  /**
   * @var int
   */
  protected int $int = 1000;
  /**
   * @var string
   */
  protected string $decHex = '3e8';

  /**
   * @return void
   */
  public function testdecimal2hex(): void {
    $this->assertEquals($this->decHex, Converter::decimal2Hex($this->int));
  }

  /**
   * @return void
   */
  public function testhex2decimal(): void {
    $this->assertEquals($this->int, Converter::hex2decimal($this->decHex));
  }

  /**
   * @return void
   */
  public function teststring2Hex(): void {
    $this->assertEquals($this->hex, Converter::string2Hex($this->str));
  }

  /**
   * @return void
   */
  public function teststring2HexReverse(): void {
    $this->assertEquals($this->hexReverse, Converter::string2Hex($this->str, true));
  }

  /**
   * @return void
   * @throws \tanglePHP\Core\Exception\Converter
   */
  public function testhex2String(): void {
    $this->assertEquals($this->str, Converter::hex2String($this->hex));
  }

  /**
   * @return void
   */
  public function testbits2Hex(): void {
    $this->assertEquals($this->hex, Converter::bits2Hex($this->bits));
  }

  /**
   * @return void
   * @throws \tanglePHP\Core\Exception\Converter
   */
  public function testhex2Bits(): void {
    $this->assertEquals($this->bits, Converter::hex2Bits($this->hex));
  }

  /**
   * @return void
   * @throws \tanglePHP\Core\Exception\Converter
   */
  public function testhex2ByteArray(): void {
    $this->assertEquals($this->byteArray8bits, Converter::hex2ByteArray($this->hex));
  }

  /**
   * @return void
   */
  public function testbyteArray2Hex(): void {
    $this->assertEquals($this->hex, Converter::byteArray2Hex($this->byteArray8bits));
  }

  /**
   * @return void
   */
  public function teststring2ByteArray(): void {
    $this->assertEquals($this->byteArray8bits, Converter::string2ByteArray($this->str));
  }

  /**
   * @return void
   */
  public function testbyteArray2String(): void {
    $this->assertEquals($this->str, Converter::byteArray2String($this->byteArray8bits));
  }

  /**
   * @return void
   */
  public function testbase64_encode(): void {
    $this->assertEquals($this->base64, Converter::base64_encode($this->str));
  }

  /**
   * @return void
   */
  public function testbase64_decode(): void {
    $this->assertEquals($this->str, Converter::base64_decode($this->base64));
  }

  /**
   * @return void
   * @throws \tanglePHP\Core\Exception\Converter
   */
  public function testbase58_encode(): void {
    $this->assertEquals($this->base58, Converter::base58_encode($this->str));
  }

  /**
   * @return void
   * @throws \tanglePHP\Core\Exception\Converter
   */
  public function testbase58_decode(): void {
    $this->assertEquals($this->str, Converter::base58_decode($this->base58));
  }

  /**
   * @return void
   * @throws \tanglePHP\Core\Exception\Converter
   */
  public function testbits(): void {
    $byteArray8bits_copy = $this->byteArray8bits;
    //
    array_unshift($this->byteArray8bits, 0);
    $this->assertEquals($this->byteArray5bits, Converter::bits($this->byteArray8bits, count($this->byteArray8bits), 8, 5, true));
    $this->assertEquals($this->byteArray8bits, Converter::bits($this->byteArray5bits, count($this->byteArray5bits), 5, 8, false));
    unset($this->byteArray8bits[0]);
    $this->assertEquals($this->byteArray8bits, $byteArray8bits_copy);
  }

  /**
   * @return void
   */
  public function testisHex(): void {
    $this->assertTrue(Converter::isHex($this->hex));
    $this->assertFalse(Converter::isHex($this->str));
    $this->assertTrue(Converter::isHex($this->bits));
  }

  /**
   * @return void
   */
  public function testisNumeric(): void {
    $this->assertFalse(Converter::isNumeric($this->hex));
    $this->assertFalse(Converter::isNumeric($this->str));
    $this->assertTrue(Converter::isNumeric($this->bits));
    $this->assertFalse(Converter::isNumeric($this->byteArray8bits));
    $this->assertFalse(Converter::isNumeric($this->base64));
  }

  /**
   * @return void
   */
  public function testisUtf8(): void {
    $this->assertFalse(Converter::isUtf8($this->hex));
    $this->assertFalse(Converter::isUtf8($this->str));
    $this->assertFalse(Converter::isUtf8($this->bits));
    $this->assertFalse(Converter::isUtf8($this->byteArray8bits));
    $this->assertFalse(Converter::isUtf8($this->base64));
  }

  /**
   * @return void
   */
  public function testisBitwise(): void {
    $this->assertFalse(Converter::isBitwise($this->hex));
    $this->assertFalse(Converter::isBitwise($this->str));
    $this->assertTrue(Converter::isBitwise($this->bits));
    $this->assertFalse(Converter::isBitwise($this->byteArray8bits));
    $this->assertFalse(Converter::isBitwise($this->base64));
  }

  /**
   * @return void
   */
  public function testisBase64(): void {
    $this->assertTrue(Converter::isBase64($this->hex));
    $this->assertFalse(Converter::isBase64($this->str));
    $this->assertTrue(Converter::isBase64($this->bits));
    $this->assertFalse(Converter::isBase64($this->byteArray8bits));
    $this->assertTrue(Converter::isBase64($this->base64));
  }

  /**
   * @return void
   */
  public function testisBase16(): void {
    $this->assertTrue(Converter::isBase16($this->hex));
    $this->assertFalse(Converter::isBase16($this->str));
    $this->assertTrue(Converter::isBase16($this->bits));
    $this->assertFalse(Converter::isBase16($this->byteArray8bits));
    $this->assertFalse(Converter::isBase16($this->base64));
  }

  /**
   * @return void
   */
  public function testisJSON(): void {
    $this->assertTrue(Converter::isJSON($this->json));
  }

  /**
   * @return void
   */
  public function testisBinary(): void {
    $this->assertTrue(Converter::isBinary($this->binary));
  }
}
