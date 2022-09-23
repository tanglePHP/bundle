<?php namespace tanglePHP\bundle\tests\core\Helper;
require_once "./autoload.php";

use PHPUnit\Framework\TestCase;
use tanglePHP\Core\Exception\Helper;
use tanglePHP\Core\Helper\Amount\SMR;
use tanglePHP\Core\Helper\Amount\IOTA;

/**
 * Class AmountTest
 *
 * @package      tanglePHP\bundle\tests\core\Crypto
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.23-0817
 */
final class AmountTest extends TestCase {
  /**
   * @return void
   * @throws Helper
   */
  public function testAmountSMR(): void {
    $ret                   = [];
    $ret[1]                = new SMR("1glow");
    $ret[10]               = new SMR(10);
    $ret[100]              = new SMR("0.0001smr");
    $ret[1000]             = new SMR("1000");
    $ret[1000000]          = new SMR("1smr");
    $ret[1000000000]       = new SMR("1000smr");
    $ret[1000000000000000] = new SMR("1000000000smr");
    //
    foreach($ret as $k => $amount) {
      $this->assertEquals($amount->getAmount(), $k);
    }
  }

  /**
   * @return void
   */
  public function testAmountIOTA(): void {
    $ret                   = [];
    $ret[1]                = new IOTA("1");
    $ret[10]               = new IOTA("0.01ki");
    $ret[100]              = new IOTA("0.1ki");
    $ret[1000]             = new IOTA("1ki");
    $ret[10000]            = new IOTA("10ki");
    $ret[100000]           = new IOTA("100kI");
    $ret[1000000]          = new IOTA("1mi");
    $ret[10000000]         = new IOTA("10Mi");
    $ret[100000000]        = new IOTA("100MI");
    $ret[1000000000]       = new IOTA("1gi");
    $ret[10000000000]      = new IOTA("0.01ti");
    $ret[100000000000]     = new IOTA("0.1ti");
    $ret[1000000000000]    = new IOTA("1ti");
    $ret[10000000000000]   = new IOTA("10ti");
    $ret[100000000000000]  = new IOTA("0.1pi");
    $ret[1000000000000000] = new IOTA("1pi");
    $ret[2779530283277761] = new IOTA("2779530283277761i");
    $ret[2779000000]       = new IOTA("2779mi");
    foreach($ret as $k => $amount) {
      $this->assertEquals($amount->getAmount(), $k);
    }
  }
}
