<?php namespace tanglePHP\SingleNodeClient\Api\v2\Address;

use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class NFT
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Address
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0821
 */
final class NFT extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 16;

  /**
   * @param string $nftId
   */
  public function __construct(public string $nftId) {
    $this->nftId = Converter::HexString0x($nftId);
  }

  /**
   * @return array
   * @throws \tanglePHP\Core\Exception\Converter
   */
  public function serialize(): array {
    return [
      self::serializeUInt8($this->type),
      self::serializeFixedHex($this->nftId),
    ];
  }
}