<?php namespace tanglePHP\bundle\tests\marketClient;
require_once "./autoload.php";

use PHPUnit\Framework\TestCase;
use tanglePHP\Network\Connect;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class FullTest
 *
 * @package      tanglePHP\bundle\tests\marketClient
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.23-0834
 */
final class FullTest extends TestCase {
  /**
   * @var Connect
   */
  private Connect $network;

  /**
   * @return void
   */
  public function setUp(): void {
    $this->network = new Connect('mainnet');
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  public function testPing(): void {
    $ret = $this->network->marketServer->ping();
    $this->assertEquals('(V3) To the Moon!', $ret->gecko_says);
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  public function testPrice(): void {
    $ret = $this->network->marketServer->price();
    $this->assertArrayHasKey('iota', $ret->__toArray());
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  public function testCoin(): void {
    $ret = $this->network->marketServer->coin();
    $this->assertArrayHasKey('id', $ret->__toArray());
    $this->assertEquals('iota', $ret->id);
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  public function testCoinHistory(): void {
    $ret = $this->network->marketServer->coinHistory('30-12-2021');
    $this->assertArrayHasKey('id', $ret->__toArray());
    $this->assertEquals('iota', $ret->id);
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  public function testCoinMarketChart(): void {
    $ret = $this->network->marketServer->coinMarketChart(1, 'usd');
    $this->assertArrayHasKey('prices', $ret->__toArray());
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  public function testCoinMarketChartRange(): void {
    $ret = $this->network->marketServer->coinMarketChartRange(time() - 3600, time(), 'usd');
    $this->assertArrayHasKey('prices', $ret->__toArray());
  }
}
