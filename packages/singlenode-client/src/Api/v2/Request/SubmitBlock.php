<?php namespace tanglePHP\SingleNodeClient\Api\v2\Request;

use tanglePHP\SingleNodeClient\Api\v2\Payload\TaggedData;
use tanglePHP\SingleNodeClient\Api\v2\Payload\Transaction;
use tanglePHP\Core\Models\AbstractApiRequest;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;
use tanglePHP\Core\Exception\Converter as ConverterException;

/**
 * Class SubmitBlock
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Request
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0825
 */
final class SubmitBlock extends AbstractApiRequest implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @var int
   */
  public int $protocolVersion = 2;
  /**
   * @var array
   */
  public array $parents;
  /**
   * @var int
   */
  public int $nonce;

  /**
   * RequestSubmitMessage constructor.
   *
   * @param mixed $payload
   */
  public function __construct(public TaggedData|Transaction $payload) {
  }

  /**
   * @return array
   * @throws ConverterException
   */
  public function serialize(): array {
    // protocolVersion
    $_ret = [self::serializeUInt8($this->protocolVersion)];
    // parents
    $_ret[] = self::serializeUInt8(count($this->parents));
    foreach($this->parents as $object) {
      $_ret[] = self::serializeFixedHex($object);
    }
    // payload
    $_ret = array_merge($_ret, $this->payload->serialize());
    // nonce
    $_ret[] = self::serializeBigInt64($this->nonce ?? 0);

    return $_ret;
  }
}