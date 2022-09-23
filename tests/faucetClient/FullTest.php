<?php namespace tanglePHP\bundle\tests\faucetClient;
require_once "./autoload.php";

use PHPUnit\Framework\TestCase;
use tanglePHP\Network\Connect;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class FullTest
 *
 * @package      tanglePHP\bundle\tests\faucetClient
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.23-0825
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
    $this->network = new Connect('shimmer:testnet');
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  public function testInfo(): void {
    $ret = $this->network->faucetServer->info();
    $this->assertArrayHasKey('address', $ret->__toArray());
    $this->assertArrayHasKey('balance', $ret->__toArray());
    $this->assertArrayHasKey('tokenName', $ret->__toArray());
    $this->assertArrayHasKey('bech32Hrp', $ret->__toArray());
    $this->assertEquals('Shimmer', $ret->tokenName);
    $this->assertEquals('rms', $ret->bech32Hrp);
  }

  /**
   * @return void
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  public function testGetFunds(): void {
    $ret = $this->network->faucetServer->getFunds('dc4eac92bb9962e691be743f8792530a4392094462f61d6ef329ed6a6be29992');
    $retArray = $ret->__toArray();
    if(!isset($retArray['error'])) {
      $this->assertArrayHasKey('address', $retArray);
      $this->assertArrayHasKey('waitingRequests', $retArray);
      $this->assertEquals('rms1qrwyatyjhwvk9e53he6rlpuj2v9y8ysfg330v8tw7v5766ntu2vey0dkvsx', $ret->address);
    } else {
      $this->assertEquals('400', $retArray['error']['code']);
    }
  }

}
