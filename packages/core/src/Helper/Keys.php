<?php namespace tanglePHP\Core\Helper;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Crypto\Ed25519;
use SodiumException;

/**
 * Class Keys
 *
 * @package      tanglePHP\Core\Helper
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1651
 */
final class Keys {
  /**
   * @var string
   */
  public string $private;
  /**
   * @var string
   */
  public string $public;
  /**
   * @var string
   */
  public string $secret;
  /**
   * @var int
   */
  static public int $lenPrivate = 64;
  /**
   * @var int
   */
  static public int $lenPublic = 64;
  /**
   * @var int
   */
  static public int $lenSecret = 128;

  /**
   * @param string|array|Keys|null $keyInput
   *
   * @throws HelperException
   * @throws SodiumException
   */
  public function __construct(null|string|array|Keys $keyInput = null) {
    $this->parseInput($keyInput ?? Ed25519::keyPair());
  }

  /**
   * @param $keyInput
   *
   * @return void
   * @throws HelperException
   * @throws SodiumException
   */
  private function parseInput($keyInput): void {
    if(is_string($keyInput)) {
      $this->secret = $keyInput;
      if(($len = strlen($this->secret)) != self::$lenSecret) {
        throw new HelperException("SecretKey length not " . self::$lenSecret . ", $len given");
      }
      $this->private = substr($this->secret, 0, self::$lenPrivate);
      $this->public  = substr($this->secret, self::$lenPrivate, self::$lenPublic);
    }
    elseif(is_array($keyInput)) {
      $keys = self::fromKeyPairArray($keyInput);
      $this->parseInput($keys->secret);
    }
    elseif($keyInput instanceof Keys) {
      $this->parseInput($keyInput->secret);
    }
  }

  /**
   * @param string $privateKey
   * @param string $publicKey
   *
   * @return Keys
   * @throws HelperException
   * @throws SodiumException
   */
  static public function fromKeyPair(string $privateKey, string $publicKey): Keys {
    if(strlen($privateKey) == 128 && substr($privateKey, self::$lenPrivate, self::$lenPublic) == $publicKey) {
      $privateKey = substr($privateKey, 0, self::$lenPrivate);
    }
    if(($len = strlen($privateKey)) != self::$lenPrivate) {
      throw new HelperException("SecretKey length not " . self::$lenPrivate . ", $len given");
    }
    if(($len = strlen($publicKey)) != self::$lenPublic) {
      throw new HelperException("SecretKey length not " . self::$lenPublic . ", $len given");
    }

    return new Keys($privateKey . $publicKey);
  }

  /**
   * @param array $array
   *
   * @return Keys
   * @throws HelperException
   * @throws SodiumException
   */
  static public function fromKeyPairArray(array $array): Keys {
    $privateKey = $array['privateKey'] ?? $array[0] ?? null;
    $publicKey  = $array['publicKey'] ?? $array[1] ?? null;

    return self::fromKeyPair($privateKey, $publicKey);
  }
}