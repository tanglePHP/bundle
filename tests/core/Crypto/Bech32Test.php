<?php namespace tanglePHP\bundle\tests\core\Crypto;
require_once "./autoload.php";

use tanglePHP\Core\Exception\Crypto;
use PHPUnit\Framework\TestCase;
use tanglePHP\Core\Crypto\Bech32;
use tanglePHP\Core\Helper\Converter;

/**
 * Class Bech32Test
 *
 * @package      tanglePHP\bundle\tests\core\Crypto
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.23-0816
 */
final class Bech32Test extends TestCase {
  /**
   * @var string
   */
  protected string $hrp = "atoi";
  /**
   * @var string
   */
  protected string $addressBech32 = "atoi1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vluehe53e";
  /**
   * @var string
   */
  protected string $addressEd25519 = "60200bad8137a704216e84f8f9acfe65b972d9f4155becb4815282b03cef99fe";

  /**
   * @return void
   * @throws Crypto
   * @throws \tanglePHP\Core\Exception\Converter
   */
  public function testdecode(): void {
    $data = Bech32::decode($this->addressBech32)[1];
    $ret  = substr(Converter::byteArray2Hex(Converter::bits($data, count($data), 5, 8, false)), 2);
    $this->assertEquals($this->addressEd25519, $ret);
  }

  /**
   * @return void
   * @throws \tanglePHP\Core\Exception\Converter
   */
  public function testencode(): void {
    $data = Converter::hex2byteArray($this->addressEd25519);
    array_unshift($data, 0);
    $ret = Bech32::encode($this->hrp, Converter::bits($data, count($data), 8, 5, true));
    $this->assertEquals($this->addressBech32, $ret);
  }
}
