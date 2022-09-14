<?php namespace tanglePHP\SingleNodeClient\Api\v2\Feature;

use tanglePHP\SingleNodeClient\Api\v2\Address\Alias;
use tanglePHP\SingleNodeClient\Api\v2\Address\Ed25519;
use tanglePHP\SingleNodeClient\Api\v2\Address\NFT;
use tanglePHP\Core\Exception\Converter;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class Issuer
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Feature
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0821
 */
final class Issuer extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 1;

  /**
   * @param Ed25519|Alias|NFT $address
   */
  public function __construct(public Ed25519|Alias|NFT $address) {

  }

  /**
   * @return array
   * @throws Converter
   */
  public function serialize(): array {
    return array_merge([self::serializeUInt8($this->type)], $this->address->serialize());
  }
}