<?php namespace tanglePHP\Core\Type;

use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Helper\Hash;
use tanglePHP\Core\Exception\Converter as ConverterException;
use SodiumException;

/**
 * Class Ed25519Address
 *
 * @package      tanglePHP\Core\Type
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1648
 */
final class Ed25519Address {
  /**
   * ed25519 constructor.
   *
   * @param string $publicKey
   */
  public function __construct(public string $publicKey) {

  }

  /**
   * @return string
   * @throws ConverterException
   * @throws SodiumException
   */
  public function toAddress(): string {
    $_hash = Hash::blake2b_sum256(Converter::hex2String($this->publicKey));

    return Converter::string2Hex($_hash);
  }

  /**
   * @param string $hrp
   *
   * @return string
   * @throws ConverterException
   * @throws SodiumException
   */
  public function toAddressBetch32(string $hrp): string {
    return Converter::ed25519ToBech32($this->toAddress(), $hrp);
  }

  /**
   * @return string
   * @throws ConverterException
   * @throws SodiumException
   */
  public function toAddressBase58(): string {
    return Converter::base58_encode($this->toAddress());
  }

  /**
   * @return string
   * @throws ConverterException
   * @throws SodiumException
   */
  public function __toString(): string {
    return $this->toAddress();
  }
}