<?php namespace tanglePHP\Core\Crypto;

use tanglePHP\Core\Exception\Helper as ExceptionHelper;
use tanglePHP\Core\Exception\Converter as ExceptionConverter;
use tanglePHP\Core\Helper\Hash;
use tanglePHP\Core\Helper\Converter;

/**
 * Class Slip0010
 *
 * @package      tanglePHP\Core\Crypto
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1909
 */
final class Slip0010 {
  /**
   * @var int
   */
  static protected int $PRIVATE_KEY_SIZE = 32;
  /**
   * @var int
   */
  static protected int $CHAIN_CODE_SIZE = 32;
  /**
   * @var int
   */
  static protected int $indexValue = 0x80000000;

  /**
   * @param string $seed
   *
   * @return array
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   */
  static public function getMasterKeyFromSeed(string $seed): array {
    $_key = Hash::hmacSha512("ed25519 seed")
                ->update(Converter::hex2String($seed))
                ->digest();

    return [
      'privateKey' => substr($_key, 0, self::$PRIVATE_KEY_SIZE * 2),
      'chainCode'  => substr($_key, self::$PRIVATE_KEY_SIZE * 2, self::$CHAIN_CODE_SIZE * 2),
    ];
  }

  /**
   * @param string    $seed
   * @param Bip32Path $path
   *
   * @return array
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   */
  static public function derivePath(string $seed, Bip32Path $path): array {
    $_keys      = self::getMasterKeyFromSeed($seed);
    $privateKey = $_keys['privateKey'];
    $chainCode  = $_keys['chainCode'];
    //
    foreach($path->numberSegments() as $index) {
      $indexHex = str_pad(dechex($index + self::$indexValue), 8, "0", STR_PAD_LEFT);
      $_key     = Hash::hmacSha512(Converter::hex2String($chainCode))
                      ->update(Converter::hex2String("00" . $privateKey . $indexHex))
                      ->digest();
      //
      $privateKey = substr($_key, 0, self::$PRIVATE_KEY_SIZE * 2);
      $chainCode  = substr($_key, self::$PRIVATE_KEY_SIZE * 2, self::$CHAIN_CODE_SIZE * 2);
    }

    return [
      'privateKey' => $privateKey,
      'chainCode'  => $chainCode,
    ];
  }
}
