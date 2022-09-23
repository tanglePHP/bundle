<?php namespace tanglePHP\bundle\tests\network;
require_once "./autoload.php";

use PHPUnit\Framework\TestCase;
use tanglePHP\Network\Connect;
use tanglePHP\SingleNodeClient\Connector;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ConnectTest
 *
 * @package      tanglePHP\bundle\tests\network
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.23-0835
 */
final class ConnectTest extends TestCase {
  /**
   * @var string
   */
  private string $v2Node = 'shimmer:testnet';
  /**
   * @var string
   */
  private string $v1Node = 'chrysalis:mainnet';

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  public function testConnectV2(): void {
    $network = new Connect($this->v2Node);
    $this->assertInstanceOf(Connector::class, $network->singleNode);
    $this->assertEquals("2", $network->info['protocolVersion']);
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  public function testConnectV1(): void {
    $network = new Connect($this->v1Node);
    $this->assertInstanceOf(Connector::class, $network->singleNode);
    $this->assertEquals("1", $network->info['protocolVersion']);
  }
}
