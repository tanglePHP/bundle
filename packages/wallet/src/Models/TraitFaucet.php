<?php namespace tanglePHP\Wallet\Models;

use tanglePHP\FaucetClient\Api\v1\Response\Enqueue;
use tanglePHP\Core\Models\AbstractAmount;
use tanglePHP\SingleNodeClient\Models\ReturnSubmitBlock;
use tanglePHP\SingleNodeClient\Api\v2\Response\Error;
use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Exception\Converter as ExceptionConverter;
use tanglePHP\Core\Exception\Crypto as ExceptionCrypto;
use tanglePHP\Core\Exception\Helper as ExceptionHelper;
use tanglePHP\Core\Exception\Type as ExceptionType;
use tanglePHP\Core\Exception\Api as ExceptionApi;
use SodiumException;
use Exception;

/**
 * Trait TraitFaucet
 *
 * @package      tanglePHP\Wallet\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.10.06-2050
 */
trait TraitFaucet {
  /**
   * @return Enqueue
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   * @throws SodiumException
   */
  public function getFundsFromFaucet(): Enqueue|JSON|Error {
    if(!$this->wallet->client->ENDPOINT->network->hasFaucetServer()) {
      throw new Exception('Faucet is not supported on this network');
    }

    return $this->wallet->client->ENDPOINT->network->faucetServer->getFunds($this->address->toAddressBetch32($this->wallet->bech32HRP));
  }

  /**
   * @param int|string|AbstractAmount $amountToSend
   *
   * @return ReturnSubmitBlock|Error
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function sendFundsToFaucet(int|string|AbstractAmount $amountToSend): ReturnSubmitBlock|JSON|Error {
    if(!$this->wallet->client->ENDPOINT->network->hasFaucetServer()) {
      throw new Exception('Faucet is not supported on this network');
    }

    return $this->wallet->client->ENDPOINT->network->faucetServer->sendFundsBack($amountToSend, $this->wallet->getSeed(), $this->accountIndex, $this->addressIndex);
  }
}