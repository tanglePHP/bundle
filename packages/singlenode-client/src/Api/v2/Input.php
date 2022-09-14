<?php namespace tanglePHP\SingleNodeClient\Api\v2;

use tanglePHP\Core\Exception\Converter;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class Input
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0818
 */
final class Input extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @param int    $type
   * @param string $transactionId
   * @param int    $transactionOutputIndex
   */
  public function __construct(public int $type, public string $transactionId, public int $transactionOutputIndex) {
  }

  /**
   * @return array
   * @throws Converter
   */
  public function serialize(): array {
    return [
      self::serializeUInt8($this->type),
      self::serializeFixedHex(($this->transactionId)),
      self::serializeUInt16($this->transactionOutputIndex),
    ];

  }
}