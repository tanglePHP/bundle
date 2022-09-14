<?php namespace tanglePHP\Core\Helper;

use tanglePHP\Core\Crypto\Bip39;
use tanglePHP\Core\Crypto\Mnemonic;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Exception\Crypto as CryptoException;

/**
 * Class Simplifier
 *
 * @package      tanglePHP\Core\Helper
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1651
 */
final class Simplifier {

  /**
   * @return Mnemonic
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   */
  static public function createMnemonic(): Mnemonic {
    return (new Bip39())->randomMnemonic();
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
    return (new Bip39())->reverseMnemonic($words);
  }
}