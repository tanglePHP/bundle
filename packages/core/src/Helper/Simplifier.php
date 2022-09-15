<?php namespace tanglePHP\Core\Helper;

use Exception;
use tanglePHP\Core\Crypto\Bip32Path;
use tanglePHP\Core\Crypto\Bip39;
use tanglePHP\Core\Crypto\Mnemonic;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Exception\Crypto as CryptoException;
use tanglePHP\Core\Exception\Type as TypeException;
use tanglePHP\Core\Type\Ed25519Seed;

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
   * Create a random Mnemonic
   *
   * @return Mnemonic
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   */
  static public function createMnemonic(): Mnemonic {
    return (new Bip39())->randomMnemonic();
  }

  /**
   * Create Mnemonic from 24 words
   *
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

  /**
   * Check if 24 words are valide
   *
   * @param string|array $words
   *
   * @return bool
   */
  static public function checkMnemonic(string|array $words): bool {
    try {
      self::reverseMnemonic($words);
    }
    catch(Exception) {
      return false;
    }

    return true;
  }

  /**
   * Return Seed from 24 words
   *
   * @param string|array $words
   *
   * @return string|false
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   */
  static public function mnemonicToSeed(string|array $words): string|false {
    if(!self::checkMnemonic($words)) {
      return false;
    }

    return (self::reverseMnemonic($words))->__toSeed();
  }

  /**
   * Return Ed25519Seed from Mnemonic|24 words|seed|Ed25519Seed|base58Seed
   *
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   *
   * @return Ed25519Seed
   * @throws ConverterException
   * @throws CryptoException
   * @throws HelperException
   * @throws TypeException
   */
  static public function createEd25519Seed(Ed25519Seed|Mnemonic|string|array $seedInput): Ed25519Seed {
    return new Ed25519Seed($seedInput);
  }

  /**
   * Create Bip32Path
   *
   * @param int $coinType
   * @param int $accountIndex
   * @param int $addressIndex
   *
   * @return Bip32Path
   */
  static public function createAddressPath(int $coinType, int $accountIndex = 0, int $addressIndex = 0): Bip32Path {
    $addressPath = new Bip32Path(("m/44'/0'/0'/0'/0'"));
    $addressPath->setAccountIndex($accountIndex);
    $addressPath->setAddressIndex($addressIndex);

    return $addressPath->setCoinType($coinType);
  }

  /**
   * @param string $plaintext
   * @param string $password
   * @param string $method
   *
   * @return string
   */
  static function encrypt(string $plaintext, string $password, string $method = 'AES-256-CBC'): string {
    return Converter::encrypt($plaintext, $password, $method);
  }

  /**
   * @param string $encryptedText
   * @param string $password
   * @param string $method
   *
   * @return string|false|null
   */
  static function decrypt(string $encryptedText, string $password, string $method = 'AES-256-CBC'): string|null|false {
    return Converter::decrypt($encryptedText, $password, $method);
  }
}