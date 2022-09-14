<?php namespace tanglePHP\SingleNodeClient\Api\v2\Unlock;

use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class Reference
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Unlock
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0819
 */
final class Reference extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 1;

  /**
   * @param int $reference
   */
  public function __construct(public int $reference) {

  }

  /**
   * @return array
   */
  public function serialize(): array {
    return [self::serializeUInt8($this->type), self::serializeUInt16($this->reference)];
  }
}