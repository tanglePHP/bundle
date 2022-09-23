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
  protected JSON $object;
  protected string $str = "follow me on Twitter @tanglePHP";
  protected string $json = '{"data": "follow me on Twitter @tanglePHP"}';
  protected array $array = ['data' => "follow me on Twitter @tanglePHP"];

  public function setUp(): void {
    $this->object = new JSON($this->json);
  }

  public function testcreate() {
    $this->object = JSON::create($this->json);
    $this->assertInstanceOf('\tanglePHP\Core\Helper\JSON', $this->object);
    $this->object = JSON::create($this->str);
    $this->assertInstanceOf('\tanglePHP\Core\Helper\JSON', $this->object);
    $this->object = JSON::create($this->array);
    $this->assertInstanceOf('\tanglePHP\Core\Helper\JSON', $this->object);
  }

  public function testdecode() {
    $ret = $this->object->__toArray();
    $this->assertIsArray((array)$ret);
  }

  public function testMAGIC() {
    $this->assertIsArray((array)$this->object);
    $this->assertIsString((string)$this->object);
  }
}
