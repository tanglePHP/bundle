<?php namespace tanglePHP\SingleNodeClient\Api\v2;

use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class tokenScheme
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0818
 */
final class tokenScheme extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 0;

  /**
   * @param string $mintedTokens
   * @param string $meltedTokens
   * @param string $maximumSupply
   */
  public function __construct(public string $mintedTokens, public string $meltedTokens, public string $maximumSupply) {
  }

  /**
   * @return array
   */
  public function serialize(): array {
    $_ret = [];
    // type
    $_ret[] = self::serializeUInt8($this->type);
    // mintedTokens
    $_ret[] = self::serializeBigInt256(Converter::hex2decimal(Converter::remove0x($this->mintedTokens)));
    // meltedTokens
    $_ret[] = self::serializeBigInt256(Converter::hex2decimal(Converter::remove0x($this->meltedTokens)));
    // maximumSupply
    $_ret[] = self::serializeBigInt256(Converter::hex2decimal(Converter::remove0x($this->maximumSupply)));

    return $_ret;
  }
}