<?php namespace tanglePHP\Wallet\Type;

use tanglePHP\SingleNodeClient\Models\ReturnAddressBalance;
use tanglePHP\Wallet\Models\TraitBalance;
use tanglePHP\Wallet\Models\TraitFaucet;
use tanglePHP\Wallet\Models\TraitSend;
use tanglePHP\Wallet\Run;
use tanglePHP\Core\Type\Ed25519Address;
use tanglePHP\Core\Crypto\Bip32Path;
use tanglePHP\Core\Exception\Converter as ExceptionConverter;
use tanglePHP\Core\Exception\Crypto as ExceptionCrypto;
use tanglePHP\Core\Exception\Helper as ExceptionHelper;
use tanglePHP\Core\Exception\Type as ExceptionType;
use tanglePHP\Core\Exception\Api as ExceptionApi;
use SodiumException;

/**
 * Class Address
 *
 * @package      tanglePHP\Wallet\Type
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.10.06-2051
 */
final class Address {
  use TraitBalance;
  use TraitFaucet;
  use TraitSend;

  /**
   * @var Bip32Path
   */
  public Bip32Path $path;
  /**
   * @var Ed25519Address
   */
  protected Ed25519Address $address;

  /**
   * @param Run  $wallet
   * @param int  $accountIndex
   * @param int  $addressIndex
   * @param bool $isInternal
   *
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function __construct(public Run $wallet, protected int $accountIndex = 0, protected int $addressIndex = 0, bool $isInternal = false) {
    $this->path = new Bip32Path("m/44'/0'/0'/0'/0'");
    $this->path->setAccountIndex($accountIndex, true);
    $this->path->setAddressIndex($addressIndex, true);
    $this->path->setCoinType($this->wallet->client->ENDPOINT->network->info['coinType']);
    $this->path->setChange($isInternal ? 1 : 0, true);
    //
    $_addressSeed  = $wallet->getSeed()
                            ->generateSeedFromPath($this->path);
    $this->address = new Ed25519Address(($_addressSeed->keyPair())->public);
  }

  /**
   * @return string
   */
  public function getPathString(): string {
    return (string)$this->path;
  }

  /**
   * @return string
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  public function getAddress(): string {
    return $this->address->toAddress();
  }

  /**
   * @return string
   * @throws ExceptionConverter
   * @throws SodiumException
   */
  public function getAddressBech32(): string {
    return $this->address->toAddressBetch32($this->wallet->bech32HRP);
  }

  /**
   * @return array
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   * @throws SodiumException
   */
  public function getFullInfo(): ReturnAddressBalance {
    $balance = $this->getBalance();

    return new ReturnAddressBalance([
      'path'               => $this->getPathString(),
      'addressEd25519'     => $this->getAddress(),
      'addressBech32'      => $this->getAddressBech32(),
      'balance'            => $balance->balance,
      'nativeTokens'       => $balance->nativeTokens,
      'marketData'         => $balance->marketData,
      'marketData_balance' => $balance->marketData_balance,
      'ledgerIndex'        => $balance->ledgerIndex,
    ], $this->wallet->client->ENDPOINT->network);
  }
}