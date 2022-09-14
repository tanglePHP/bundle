<?php namespace tanglePHP\SingleNodeClient\Api\v2\UnlockCondition;

use tanglePHP\SingleNodeClient\Api\v2\Address\Alias;
use tanglePHP\SingleNodeClient\Api\v2\Address\Ed25519;
use tanglePHP\SingleNodeClient\Api\v2\Address\NFT;
use tanglePHP\Core\Exception\Converter;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class Expiration
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\UnlockCondition
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0819
 */
final class Expiration extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 3;

  /**
   * @param Ed25519|Alias|NFT $returnAddress
   * @param int               $unixTime
   */
  public function __construct(public Ed25519|Alias|NFT $returnAddress, public int $unixTime = 0) {

  }

  /**
   * @return array
   * @throws Converter
   */
  public function serialize(): array {
    $ret   = array_merge([self::serializeUInt8($this->type)], $this->returnAddress->serialize());
    $ret[] = self::serializeUInt32($this->unixTime);

    return $ret;
  }
}