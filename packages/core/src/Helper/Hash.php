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
   * @var HashContext a Hashing Context resource for use with <b>hash_update</b>,
   * <b>hash_update_stream</b>, <b>hash_update_file</b>,
   * and <b>hash_final</b>.
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
   * (PHP 5 &gt;= 5.1.2, PECL hash &gt;= 1.1)<br/>
   * Pump data into an active hashing context
   *
   * @link https://php.net/manual/en/function.hash-update.php
   *
   * @param string $data <p>
   *                     Message to be included in the hash digest.
   *                     </p>
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
   * (PHP 5 &gt;= 5.1.2, PECL hash &gt;= 1.1)<br/>
   * Finalize an incremental hash and return resulting digest
   *
   * @link https://php.net/manual/en/function.hash-final.php
   *
   * @param bool $binary [optional] <p>
   *                     When set to <b>TRUE</b>, outputs raw binary data.
   *                     <b>FALSE</b> outputs lowercase hexits.
   *                     </p>
   *
   * @return string a string containing the calculated message digest as lowercase hexits
   * unless <i>raw_output</i> is set to true in which case the raw
   * binary representation of the message digest is returned.
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
   * (PHP 5 &gt;= 5.1.2, PECL hash &gt;= 1.1)<br/>
   * Return a list of registered hashing algorithms
   *
   * @link https://php.net/manual/en/function.hash-algos.php
   * @return array a numerically indexed array containing the list of supported
   * hashing algorithms.
   */
  static public function algos(): array {
    return hash_algos();
  }

  /**
   * Generate a PBKDF2 key derivation of a supplied password
   *
   * @link  https://php.net/manual/en/function.hash-pbkdf2.php
   *
   * @param string $algo       <p>
   *                           Name of selected hashing algorithm (i.e. "md5", "sha256", "haval160,4", etc..) See <b>hash_algos</b> for a list of supported algorithms.<br/>
   *                           Since 7.2.0 usage of non-cryptographic hash functions (adler32, crc32, crc32b, fnv132, fnv1a32, fnv164, fnv1a64, joaat) was disabled.
   *                           </p>
   * @param string $password   <p>
   *                           The password to use for the derivation.
   *                           </p>
   * @param string $salt       <p>
   *                           The salt to use for the derivation. This value should be generated randomly.
   *                           </p>
   * @param int    $iterations <p>
   *                           The number of internal iterations to perform for the derivation.
   *                           </p>
   * @param int    $length     [optional] <p>
   *                           The length of the output string. If raw_output is TRUE this corresponds to the byte-length of the derived key,
   *                           if raw_output is FALSE this corresponds to twice the byte-length of the derived key (as every byte of the key is returned as two hexits). <br/>
   *                           If 0 is passed, the entire output of the supplied algorithm is used.
   *                           </p>
   * @param bool   $binary     [optional] <p>
   *                           When set to TRUE, outputs raw binary data. FALSE outputs lowercase hexits.
   *                           </p>
   *
   * @return string a string containing the derived key as lowercase hexits unless
   * <i>raw_output</i> is set to <b>TRUE</b> in which case the raw
   * binary representation of the derived key is returned.
   * @since 5.5
   * @throws HelperException
   */
  static public function pbkdf2(string $algo, string $password, string $salt, int $iterations = 2048, int $length = 128, bool $binary = false): string {
    $algo = strtolower($algo);
    if(!in_array($algo, self::algos())) {
      throw new HelperException("unknown hashing algorithms $algo");
    }

    return hash_pbkdf2($algo, $password, $salt, $iterations, $length, $binary);
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