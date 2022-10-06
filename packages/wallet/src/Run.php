<?php namespace tanglePHP\Wallet;

use Exception;
use tanglePHP\Network\Connect;
use tanglePHP\SingleNodeClient\Connector;
use tanglePHP\Core\Crypto\Bip39;
use tanglePHP\Core\Crypto\Ed25519;
use tanglePHP\Core\Crypto\Mnemonic;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Helper\Hash;
use tanglePHP\SingleNodeClient\Helper\TransactionHelper;
use tanglePHP\Core\Type\Ed25519Seed;
use tanglePHP\Core\Exception\Converter as ExceptionConverter;
use tanglePHP\Core\Exception\Crypto as ExceptionCrypto;
use tanglePHP\Core\Exception\Helper as ExceptionHelper;
use tanglePHP\Core\Exception\Type as ExceptionType;
use tanglePHP\Core\Exception\Api as ExceptionApi;
use tanglePHP\Wallet\Type\Address;
use SodiumException;

/**
 * Class Run
 *
 * @package      tanglePHP\Wallet
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.10.06-2049
 */
final class Run {
  /**
   * @var Connector
   */
  public Connector $client;
  /**
   * @var Ed25519Seed
   */
  protected Ed25519Seed $_seed;
  /**
   * @var array
   */
  protected array $addresses;
  /**
   * @var string
   */
  public string $bech32HRP;

  /**
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   * @param Connect|Connector|string          $client
   *
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   */
  public function __construct(Ed25519Seed|Mnemonic|string|array $seedInput, Connect|Connector|string $client) {
    if($client instanceof Connect) {
      $this->client = $client->singleNode;
    }
    else if($client instanceof Connector) {
      $this->client = $client;
    }
    else {
      $client       = new Connect($client);
      $this->client = $client->singleNode;
    }
    //
    $this->_seed     = new Ed25519Seed($seedInput);
    $this->bech32HRP = TransactionHelper::getClientProtocol_bech32($this->client);
  }

  /**
   * @param int $count
   *
   * @return string
   * @throws ExceptionConverter
   * @throws SodiumException
   * @throws Exception
   */
  public function subSeed(int $count = 0): string {
    $subSeed          = random_bytes(Ed25519::$SEED_SIZE);
    $indexBytes       = random_bytes(8);
    $indexBytes       = pack('V*', $count, $indexBytes);
    $hashOfIndexBytes = Hash::blake2b_sum256($indexBytes);

    return Converter::string2Hex(Converter::XORBytes($subSeed, Converter::hex2String($this->_seed->secretKey), $hashOfIndexBytes));
  }

  /**
   * @return Mnemonic
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   */
  static public function createMnemonic(): Mnemonic {
    return (new Bip39())->randomMnemonic();
  }

  /**
   * @param int  $accountIndex
   * @param int  $addressIndex
   * @param bool $isInternal
   *
   * @return Address
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function address(int $accountIndex = 0, int $addressIndex = 0, bool $isInternal = false): Address {
    $add                                    = new Address($this, $accountIndex, $addressIndex, $isInternal);
    $this->addresses[$add->getPathString()] = $add;

    return $add;
  }

  /**
   * @return Ed25519Seed
   */
  public function getSeed(): Ed25519Seed {
    return $this->_seed;
  }

  /**
   * @return string
   */
  public function getCoinType(): string {
    return $this->client->ENDPOINT->network->info['coinType'];
  }

  /**
   * @param int  $maxAccountIndex
   * @param int  $maxAddressIndex
   * @param bool $zeroBalance
   *
   * @return array
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function searchAddresses(int $maxAccountIndex = 5, int $maxAddressIndex = 5, bool $zeroBalance = false): array {
    $_ret = [];
    for($_i = 0; $_i < $maxAccountIndex; $_i++) {
      for($_j = 0; $_j < $maxAddressIndex; $_j++) {
        $_r = $this->address($_i, $_j);
        if(($_r->getBalance()->balance) == 0 && !$zeroBalance) {
          continue;
        }
        $_ret[] = $_r->getFullInfo();
      }
    }

    return $_ret;
  }

  /**
   * @return array
   */
  public function getKnownAddresses(): array {
    return $this->addresses;
  }

  /**
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   * @param Connect|Connector|string          $client
   *
   * @return Run
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   */
  static public function open(Ed25519Seed|Mnemonic|string|array $seedInput, Connect|Connector|string $client): Run {
    return new Run($seedInput, $client);
  }
}