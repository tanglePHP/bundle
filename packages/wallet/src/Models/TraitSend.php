<?php namespace tanglePHP\Wallet\Models;

use tanglePHP\SingleNodeClient\Action\sendTransaction;
use tanglePHP\Core\Models\AbstractAmount;
use tanglePHP\SingleNodeClient\Api\v2\Response\Error;
use tanglePHP\SingleNodeClient\Api\v2\Response\SubmitBlock;
use tanglePHP\Core\Helper\JSON;
use tanglePHP\SingleNodeClient\Models\ReturnSubmitBlock;
use tanglePHP\Core\Exception\Converter as ExceptionConverter;
use tanglePHP\Core\Exception\Crypto as ExceptionCrypto;
use tanglePHP\Core\Exception\Helper as ExceptionHelper;
use tanglePHP\Core\Exception\Type as ExceptionType;
use tanglePHP\Core\Exception\Api as ExceptionApi;
use SodiumException;

/**
 * Trait TraitSend
 *
 * @package      tanglePHP\Wallet\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.10.06-2050
 */
trait TraitSend {
  /**
   * @param string                    $toAddress
   * @param int|string|AbstractAmount $amount
   * @param bool                      $checkTransaction
   *
   * @return SubmitBlock|Error
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function send(string $toAddress, int|string|AbstractAmount $amount, bool $checkTransaction = true): ReturnSubmitBlock|JSON|Error {
    return (new sendTransaction($this->wallet->client))->amount($amount)
                                                       ->seedInput($this->wallet->getSeed())
                                                       ->accountIndex((int)$this->path->getAccountIndex())
                                                       ->addressIndex((int)$this->path->getAddressIndex())
                                                       ->setting(['checkTransaction' => $checkTransaction])
                                                       ->toAddress($toAddress)
                                                       ->run();
  }
}