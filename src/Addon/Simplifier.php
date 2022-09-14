<?php namespace tanglePHP\SingleNodeClient\Addon;

use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Crypto\Mnemonic;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Exception\Crypto as CryptoException;

/**
 * Trait Simplifier
 *
 * @package      tanglePHP\SingleNodeClient\Addon
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0830
 */
trait Simplifier {
  /**
   * @return Mnemonic
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   */
  static public function createMnemonic(): Mnemonic {
    return \tanglePHP\Core\Helper\Simplifier::createMnemonic();
  }

  /**
   * @param string|array $words
   *
   * @return Mnemonic
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   */
  static public function reverseMnemonic(string|array $words): Mnemonic {
    return \tanglePHP\Core\Helper\Simplifier::reverseMnemonic($words);
  }

  /**
   * @return ResponseArray
   * @throws ApiException
   * @throws HelperException
   */
  public function getLatestMilestone(): ResponseArray {
    if($this->getProtocolVersion() == '2') {
      return ($this->ENDPOINT->network->singleNode->info())->status->latestMilestone;
    }
    $var = ($this->ENDPOINT->network->singleNode->info())->latestMilestoneIndex;

    return new ResponseArray([
      'milestoneId' => $var,
      'index'       => $var,
    ]);
  }
}