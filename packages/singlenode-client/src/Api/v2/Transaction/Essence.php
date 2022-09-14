<?php namespace tanglePHP\SingleNodeClient\Api\v2\Transaction;

use tanglePHP\SingleNodeClient\Api\v2\Payload\TaggedData;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class Essence
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Transaction
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0820
 */
final class Essence extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $type = 1;
  /**
   * @var string
   */
  public string $networkId;
  /**
   * @var array
   */
  public array $inputs = [];
  /**
   * @var array
   */
  public array $outputs = [];
  /**
   * @var string
   */
  public string $inputsCommitment = '';
  /**
   * @var TaggedData|null
   */
  public ?TaggedData $payload;

  /**
   * @param string $networkId
   */
  public function __construct(string $networkId) {
    $this->networkId = $networkId;
  }

  /**
   * @return array
   * @throws ConverterException
   */
  public function serialize(): array {
    /// type
    $_ret = [self::serializeUInt8($this->type)];
    /// networkId
    $_ret[] = self::serializeUInt64($this->networkId);
    // inputs
    $_ret[] = self::serializeUInt16(count($this->inputs));
    foreach($this->inputs as $object) {
      $_ret = array_merge($_ret, $object->serialize());
    }
    // inputsCommitment
    $_ret[] = self::serializeFixedHex($this->inputsCommitment);
    // outputs
    $_ret[] = self::serializeUInt16(count($this->outputs));
    foreach($this->outputs as $object) {
      $_ret = array_merge($_ret, $object->serialize());
    }
    // payload
    if(isset($this->payload)) {
      $_ret = array_merge($_ret, $this->payload->serialize());
    }
    else {
      $_ret[] = self::serializeUInt32(0);
    }

    return $_ret;
  }
}