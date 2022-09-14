<?php namespace tanglePHP\SingleNodeClient\Api\v2\Unlock;

use tanglePHP\SingleNodeClient\Api\v2\Ed25519Signature;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class Signature
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Unlock
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0819
 */
final class Signature extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 0;

  /**
   * @param Ed25519Signature $signature
   */
  public function __construct(public Ed25519Signature $signature) {

  }

  /**
   * @return array
   * @throws ConverterException
   */
  public function serialize(): array {
    $_ret = [self::serializeUInt8($this->type)];

    return array_merge($_ret, $this->signature->serialize());
  }
}