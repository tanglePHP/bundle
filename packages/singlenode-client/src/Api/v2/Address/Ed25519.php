<?php namespace tanglePHP\SingleNodeClient\Api\v2\Address;

use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class Ed25519
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Address
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0821
 */
final class Ed25519 extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 0;

  /**
   * @param string $pubKeyHash
   */
  public function __construct(public string $pubKeyHash) {
    $this->pubKeyHash = Converter::HexString0x($pubKeyHash);
  }

  /**
   * @return array
   * @throws \tanglePHP\Core\Exception\Converter
   */
  public function serialize(): array {
    return [
      self::serializeUInt8($this->type),
      self::serializeFixedHex($this->pubKeyHash),
    ];
  }
}