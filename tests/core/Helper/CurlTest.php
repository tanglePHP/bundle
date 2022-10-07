<?php namespace tanglePHP\bundle\tests\core\Helper;
require_once "./autoload.php";

use PHPUnit\Framework\TestCase;
use tanglePHP\Core\Helper\Curl;

/**
 * Class CurlTest
 *
 * @package      tanglePHP\bundle\tests\core\Crypto
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.23-0817
 */
final class CurlTest extends TestCase {
  /**
   * @var Curl
   */
  protected Curl $curl;
  /**
   * @var string
   */
  protected string $url = "https://github.com";

  /**
   * @return void
   * @throws \tanglePHP\Core\Exception\Helper
   */
  protected function setUp(): void {
    $this->curl = new Curl($this->url);
    $this->curl->exec();
  }

  /**
   * @return void
   */
  public function testgetStatus() {
    $ret = $this->curl->getStatus();
    $this->assertArrayHasKey('url', $ret);
    $this->assertArrayHasKey('http_code', $ret);
  }

  /**
   * @return void
   */
  public function testgetHeader() {
    $ret = $this->curl->getHeader();
    $this->assertArrayHasKey('content-type', $ret);
    #$this->assertArrayHasKey('content-length', $ret);
    #$this->assertGreaterThan(0, $ret['content-length']);
  }

  /**
   * @return void
   */
  public function testhasError() {
    $this->assertFalse($this->curl->hasError());
  }

  /**
   * @return void
   */
  public function testgetInfo() {
    $ret = $this->curl->getInfo();
    $this->assertArrayHasKey('url', $ret);
    $this->assertArrayHasKey('http_code', $ret);
    $this->assertArrayHasKey('scheme', $ret);
    $this->assertEquals(0, stripos($this->url, $ret['scheme']));
    $this->assertArrayHasKey('header_size', $ret);
    $this->assertGreaterThan(0, $ret['header_size']);
  }

  /**
   * @return void
   */
  public function testgetContent() {
    $ret = $this->curl->getContent();
    $this->assertNotNull($ret);
    $this->assertIsString($ret);
  }
}
