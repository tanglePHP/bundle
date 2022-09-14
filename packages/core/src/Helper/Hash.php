<?php namespace tanglePHP\Core\Helper;

use HashContext;
use SodiumException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class Hash
 *
 * @package      tanglePHP\Core\Helper
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1651
 */
final class Hash {
  /**
   * @var string
   */
  public string $ALGO = "sha512";
  /**
   * @var string|null
   */
  public ?string $KEY = null;
  /**
   * @var int
   */
  public int $HMAC = 0;
  /**
   * @var HashContext
   */
  protected HashContext $_handle;
  /**
   * @var bool
   */
  private bool $_isFinal = false;

  /**
   * hash constructor.
   *
   * @param string|null $algo
   * @param string|null $_key
   * @param int|null    $HMAC
   *
   * @throws HelperException
   */
  public function __construct(string $algo = null, string $_key = null, int $HMAC = null) {
    $algo = strtolower($algo) ?? $this->ALGO;
    if(!in_array($algo, $this->algos())) {
      throw new HelperException("unknown hashing algorithms $algo");
    }
    $this->_handle = hash_init($algo, $HMAC ?? $this->HMAC, $_key ?? $this->KEY);
  }

  /**
   * @param string $data
   *
   * @return $this
   * @throws HelperException
   */
  public function update(string $data): self {
    if($this->_isFinal) {
      throw new HelperException("hash already final");
    }
    hash_update($this->_handle, $data);

    return $this;
  }

  /**
   * @param bool $binary
   *
   * @return string
   */
  public function digest(bool $binary = false): string {
    $this->_isFinal = true;

    return hash_final($this->_handle, $binary);
  }

  /**
   * @param string|null $key
   * @param int|null    $HMAC
   *
   * @return hash
   * @throws HelperException
   */
  static public function sha512(string $key = null, int $HMAC = null): Hash {
    return new Hash("sha512", $key, $HMAC);
  }

  /**
   * @param string|null $key
   *
   * @return hash
   * @throws HelperException
   */
  static public function hmacSha512(string $key = null): Hash {
    return self::sha512($key, HASH_HMAC);
  }

  /**
   * @param string|null $key
   * @param int|null    $HMAC
   *
   * @return hash
   * @throws HelperException
   */
  static public function sha256(string $key = null, int $HMAC = null): Hash {
    return new Hash("sha256", $key, $HMAC);
  }

  /**
   * @param string $data
   *
   * @return string
   * @throws ConverterException
   * @throws SodiumException
   */
  static public function blake2b_sum256(string $data): string {
    $data = Converter::isHex($data) ? Converter::hex2String($data) : $data;
    return sodium_crypto_generichash($data);
  }

  /**
   * @return array
   */
  static public function algos(): array {
    return hash_algos();
  }

  /**
   * @param string $algo
   * @param string $_password
   * @param string $salt
   * @param int    $_iterations
   * @param int    $_keyLength
   * @param false  $_binary
   *
   * @return string
   * @throws HelperException
   */
  static public function pbkdf2(string $algo, string $_password, string $salt, int $_iterations = 2048, int $_keyLength = 128, bool $_binary = false): string {
    $algo = strtolower($algo);
    if(!in_array($algo, self::algos())) {
      throw new HelperException("unknown hashing algorithms $algo");
    }

    return hash_pbkdf2($algo, $_password, $salt, $_iterations, $_keyLength, $_binary);
  }

  /**
   * @param string $_password
   * @param string $salt
   * @param int    $_iterations
   * @param int    $_keyLength
   * @param false  $_binary
   *
   * @return string
   * @throws HelperException
   */
  static public function pbkdf2Sha512(string $_password, string $salt, int $_iterations = 2048, int $_keyLength = 128, bool $_binary = false): string {
    return self::pbkdf2("sha512", $_password, $salt, $_iterations, $_keyLength, $_binary);
  }
}