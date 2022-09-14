<?php namespace tanglePHP\FaucetClient;

use tanglePHP\Core\Models\AbstractAmount;
use tanglePHP\Core\Models\AbstractConnector;
use tanglePHP\FaucetClient\Api\v1\Response\Enqueue;
use tanglePHP\FaucetClient\Api\v1\Response\Info;
use tanglePHP\SingleNodeClient\Action\sendTransaction;
use tanglePHP\SingleNodeClient\Api\v2\Response\Error;
use tanglePHP\SingleNodeClient\Api\v2\Response\SubmitBlock;
use tanglePHP\Core\Crypto\Mnemonic;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Exception\Crypto as CryptoException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Type as TypeException;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Type\Ed25519Seed;
use SodiumException;

/**
 * Class Connector
 *
 * @package      tanglePHP\FaucetClient
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.05-1150
 */
final class Connector extends AbstractConnector {
  /**
   * @return Info|Error
   * @throws ApiException
   * @throws HelperException
   */
  public function info(): Info|Error {
    return $this->API_CALLER->route('info')
                            ->settings('jsonException', false)
                            ->callback(Info::class)
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * @param string $address
   *
   * @return Enqueue
   * @throws ApiException
   * @throws ConverterException
   * @throws HelperException
   */
  public function getFunds(string $address): Enqueue {
    return $this->API_CALLER->route('enqueue')
                            ->requestData('{"address":"' . Converter::addressToBech32($address, $this->ENDPOINT->network->info['bech32Hrp']) . '"}')
                            ->settings('jsonException', false)
                            ->callback(Enqueue::class)
                            ->method('POST')
                            ->fetchJSON($this->ENDPOINT->TIMEOUT);
  }

  /**
   * @param int|string|AbstractAmount         $amount
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   * @param int                               $accountIndex
   * @param int                               $addressIndex
   *
   * @return SubmitBlock|Error
   * @throws ApiException
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   * @throws SodiumException
   * @throws TypeException
   */
  public function sendFundsBack(int|string|AbstractAmount $amount, Ed25519Seed|Mnemonic|string|array $seedInput, int $accountIndex = 0, int $addressIndex = 0): SubmitBlock|Error {
    return (new sendTransaction($this->ENDPOINT->network->singleNode))->seedInput($seedInput)
                                                                      ->accountIndex($accountIndex)
                                                                      ->addressIndex($addressIndex)
                                                                      ->amount($amount)
                                                                      ->toAddress(($this->info())->address)
                                                                      ->run();
  }
}