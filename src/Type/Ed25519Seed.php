<?php namespace tanglePHP\Core\Type;

use Exception;
use tanglePHP\Core\Crypto\Bip32Path;
use tanglePHP\Core\Crypto\Bip39;
use tanglePHP\Core\Crypto\Ed25519;
use tanglePHP\Core\Crypto\Mnemonic;
use tanglePHP\Core\Crypto\Slip0010;
use tanglePHP\Core\Exception\Helper as ExceptionHelper;
use tanglePHP\Core\Exception\Converter as ExceptionConverter;
use tanglePHP\Core\Exception\Crypto as ExceptionCrypto;
use tanglePHP\Core\Exception\Type as ExceptionType;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Helper\Keys;
use SodiumException;

/**
 * Class Ed25519Seed
 *
 * @package      tanglePHP\Core\Type
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1647
 */
final class Ed25519Seed {
  /**
   * @var string
   */
  public string $secretKey;

  /**
   * Ed25519Seed constructor.
   *
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   *
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   */
  public function __construct(Ed25519Seed|Mnemonic|string|array $seedInput) {
    // base58 decoded Input
    if(is_string($seedInput) && strlen($seedInput) == 44) {
      $seedInput_new = Converter::base58_decode($seedInput);
      // convert if seedInput_new isnt a hex
      if(strlen($seedInput_new) == 32 && !Converter::isHex($seedInput_new)) {
        $seedInput_new = Converter::string2Hex($seedInput_new);
      }
      // check seedInput_new
      if(strlen($seedInput_new) == 64 && Converter::isHex($seedInput_new)) {
        $seedInput = $seedInput_new;
      }
    }
    // default seedInput as Hex
    if(is_string($seedInput) && (strlen($seedInput) == 64 || strlen($seedInput) == 128) && Converter::isHex($seedInput)) {
      $this->secretKey = $seedInput;
    }
    elseif($seedInput instanceof Mnemonic || (is_string($seedInput) && str_word_count($seedInput) == 24) || (is_array($seedInput) && count($seedInput) == 24)) {
      if($seedInput instanceof Mnemonic) {
        $seedInput = $seedInput->words;
      }
      $this->secretKey = ((new Bip39())->reverseMnemonic($seedInput))->__toSeed();
    }
    elseif($seedInput instanceof Ed25519Seed) {
      $this->secretKey = $seedInput->secretKey;
    }
    else {
      throw new ExceptionType("Unknwon seedInput");
    }
  }

  /**
   * @param Bip32Path $path
   *
   * @return Ed25519Seed
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   */
  public function generateSeedFromPath(Bip32Path $path): Ed25519Seed {
    $_keys = Slip0010::derivePath($this->secretKey, $path);

    return new Ed25519Seed($_keys['privateKey']);
  }

  /**
   * @return Keys
   * @throws ExceptionConverter
   * @throws SodiumException
   * @throws Exception
   */
  public function keyPair(): Keys {
    $signKeyPair = Ed25519::keyPairFromSeed(substr($this->secretKey, 0, 64));

    return new Keys([
      'publicKey'  => $signKeyPair['publicKey'],
      'privateKey' => $signKeyPair['privateKey'],
    ]);
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return $this->secretKey;
  }
}