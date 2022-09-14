<?php namespace tanglePHP\SingleNodeClient\Api\v2;

use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class Ed25519Signature
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0818
 */
final class Ed25519Signature extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 0;

  /**
   * Ed25519Signature constructor.
   *
   * @param string $publicKey
   * @param string $signature
   */
  public function __construct(public string $publicKey, public string $signature) {

  }

  /**
   * @return array
   * @throws ConverterException
   */
  public function serialize(): array {
    // type
    $_ret = [self::serializeUInt8($this->type)];
    // publicKey
    $_ret[] = self::serializeFixedHex($this->publicKey);
    // signature
    $_ret[] = self::serializeFixedHex($this->signature);

    return $_ret;
  }
}