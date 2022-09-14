<?php namespace tanglePHP\SingleNodeClient\Api\v2\UnlockCondition;

use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class Timelock
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\UnlockCondition
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0819
 */
final class Timelock extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 2;

  /**
   * @param int $unixTime
   */
  public function __construct(public int $unixTime = 0) {

  }

  /**
   * @return array
   */
  public function serialize(): array {
    $ret   = [];
    $ret[] = self::serializeUInt8($this->type);
    $ret[] = self::serializeUInt32($this->unixTime);

    return $ret;
  }
}