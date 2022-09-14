<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use Exception;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class EssenceTransaction
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0829
 */
final class EssenceTransaction extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 0;
  /**
   * @var array
   */
  public array $inputs = [];
  /**
   * @var array
   */
  public array $outputs = [];
  /**
   * @var PayloadIndexation
   */
  public PayloadIndexation $payload;

  /**
   * @return array
   * @throws Exception
   */
  public function serialize(): array {
    /**
     * @var Input|Output $object
     */
    $_ret = [self::serializeInt($this->type)];
    // inputs
    $_ret[] = self::serializeUInt16(count($this->inputs));
    foreach($this->inputs as $object) {
      $_ret = array_merge($_ret, $object->serialize());
    }
    // outputs
    $_ret[] = self::serializeUInt16(count($this->outputs));
    foreach($this->outputs as $object) {
      $_ret = array_merge($_ret, $object->serialize());
    }
    // payload
    if(isset($this->payload)) {
      $_ret = array_merge($_ret, $this->payload->serialize());
    } else {
      $_ret[] = self::serializeUInt32(0);
    }

    return $_ret;
  }
}