<?php namespace tanglePHP\Wallet\Models;

use tanglePHP\SingleNodeClient\Action\getBalance;
use tanglePHP\SingleNodeClient\Action\getSpendable;
use tanglePHP\Core\Exception\Converter as ExceptionConverter;
use tanglePHP\Core\Exception\Helper as ExceptionHelper;
use tanglePHP\Core\Exception\Api as ExceptionApi;
use SodiumException;
use tanglePHP\SingleNodeClient\Models\ReturnAddressBalance;

/**
 * Trait TraitBalance
 *
 * @package      tanglePHP\Wallet\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.10.06-2050
 */
trait TraitBalance {
  /**
   * @return ReturnAddressBalance
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   * @throws SodiumException
   */
  public function getBalance(): ReturnAddressBalance {
    return (new getBalance($this->wallet->client))->address($this->address->toAddressBetch32($this->wallet->bech32HRP))
                                                  ->run();
  }

  /**
   * @return ReturnAddressBalance
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   * @throws SodiumException
   */
  public function getBalanceSpendable(): ReturnAddressBalance {
    return (new getBalance($this->wallet->client))->address($this->address->toAddressBetch32($this->wallet->bech32HRP))
                                                  ->filter([
                                                    'hasStorageDepositReturn' => false,
                                                    'hasExpiration'           => false,
                                                    'hasTimelock'             => false,
                                                  ])
                                                  ->run();
  }

  /**
   * @return ReturnAddressBalance
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   * @throws SodiumException
   */
  public function getBalanceConditionallyLocked(): ReturnAddressBalance {
    return (new getBalance($this->wallet->client))->address($this->address->toAddressBetch32($this->wallet->bech32HRP))
                                                  ->filter(['hasExpiration' => true])
                                                  ->run();
  }

  /**
   * @return array
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   * @throws SodiumException
   */
  public function getSpendable(): array {
    return (new getSpendable($this->wallet->client))->address($this->address->toAddressBetch32($this->wallet->bech32HRP))
                                                    ->run();
  }
}