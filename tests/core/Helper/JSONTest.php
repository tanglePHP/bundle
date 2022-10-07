<?php namespace tanglePHP\bundle\tests\core\Helper;
require_once "./autoload.php";

use PHPUnit\Framework\TestCase;
use tanglePHP\Core\Helper\JSON;

/**
 * Class JSONTest
 *
 * @package      tanglePHP\bundle\tests\core\Crypto
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.23-0817
 */
final class JSONTest extends TestCase {
  /**
   * @var JSON
   */
  protected JSON $object;
  /**
   * @var string
   */
  protected string $str = "follow me on Twitter @tanglePHP";
  /**
   * @var string
   */
  protected string $json = '{"data": "follow me on Twitter @tanglePHP"}';
  /**
   * @var array|string[]
   */
  protected array $array = ['data' => "follow me on Twitter @tanglePHP"];

  /**
   * @return void
   * @throws \tanglePHP\Core\Exception\Helper
   */
  public function setUp(): void {
    $this->object = new JSON($this->json);
  }

  /**
   * @return void
   * @throws \tanglePHP\Core\Exception\Helper
   */
  public function testcreate() {
    $this->object = JSON::create($this->json);
    $this->assertInstanceOf('\tanglePHP\Core\Helper\JSON', $this->object);
    $this->object = JSON::create($this->str);
    $this->assertInstanceOf('\tanglePHP\Core\Helper\JSON', $this->object);
    $this->object = JSON::create($this->array);
    $this->assertInstanceOf('\tanglePHP\Core\Helper\JSON', $this->object);
  }

  /**
   * @return void
   */
  public function testdecode() {
    $ret = $this->object->__toArray();
    $this->assertIsArray((array)$ret);
  }

  /**
   * @return void
   */
  public function testMAGIC() {
    $this->assertIsArray((array)$this->object);
    $this->assertIsString((string)$this->object);
  }
}
