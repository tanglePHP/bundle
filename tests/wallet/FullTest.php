<?php namespace tanglePHP\bundle\tests\wallet;
require_once "./autoload.php";

use PHPUnit\Framework\TestCase;
use tanglePHP\Core\Crypto\Mnemonic;
use tanglePHP\Network\Connect;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Wallet\Run;

/**
 * Class FullTest
 *
 * @package      tanglePHP\bundle\tests\wallet
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.10.07-1352
 */
final class FullTest extends TestCase {
  /**
   * @var string
   */
  private string $v2Node = 'shimmer:testnet';
  /**
   * @var string
   */
  private string $v1Node = 'chrysalis:mainnet';
  /**
   * @var Mnemonic
   */
  protected Mnemonic $mnemonic;
  /**
   * @var string
   */
  protected string $words = "giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally";
  /**
   * @var string
   */
  protected string $seed = "a7263c9c84ae6aa9c88ae84bfd224aab87f187b57404d462ab6764c52303bb9ae51f54acc5473b1c366dc8559c04d49d6533edf19110918f9e2474443acd33f3";
  /**
   * @var string
   */
  protected string $address0_IOTA = "iota1qpszqzadsym6wpppd6z037dvlejmjuke7s24hm95s9fg9vpua7vlu7eg4t5";
  /**
   * @var string
   */
  protected string $address0_SMR = "rms1qr2xsmt3v3eyp2ja80wd2sq8xx0fslefmxguf7tshzezzr5qsctzc2f5dg6";

  /**
   *
   */
  protected function setUp(): void {
    $this->mnemonic        = new Mnemonic();
    $this->mnemonic->words = explode(" ", $this->words);
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  public function testWalletV1(): void {
    $network  = new Connect($this->v1Node);
    $wallet   = new Run($this->mnemonic, $network);
    $address0 = $wallet->address(0, 0);
    //
    $this->assertEquals($address0->getAddressBech32(), $this->address0_IOTA);
    $this->assertEquals($wallet->getSeed(), $this->seed);
    $this->assertEquals($wallet->getCoinType(), 4218);
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   * @throws \SodiumException
   * @throws \tanglePHP\Core\Exception\Converter
   * @throws \tanglePHP\Core\Exception\Crypto
   * @throws \tanglePHP\Core\Exception\Type
   */
  public function testWalletV2(): void {
    $network  = new Connect($this->v2Node);
    $wallet   = new Run($this->mnemonic, $network);
    $address0 = $wallet->address(0, 0);
    //
    $this->assertEquals($address0->getAddressBech32(), $this->address0_SMR);
    $this->assertEquals($wallet->getSeed(), $this->seed);
    $this->assertEquals($wallet->getCoinType(), 4219);
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   * @throws \SodiumException
   * @throws \tanglePHP\Core\Exception\Converter
   * @throws \tanglePHP\Core\Exception\Crypto
   * @throws \tanglePHP\Core\Exception\Type
   */
  public function testWalletSearchAddress(): void {
    $network = new Connect($this->v2Node);
    $wallet  = new Run($this->mnemonic, $network);
    //
    $search = $wallet->searchAddresses(1, 1, true);
    foreach($search as $addressInfo) {
      $this->assertInstanceOf('\tanglePHP\SingleNodeClient\Models\ReturnAddressBalance', $addressInfo);
      $this->assertEquals($addressInfo->addressBech32, $this->address0_SMR);
    }
  }
}
