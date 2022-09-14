<?php namespace tanglePHP\SingleNodeClient\Api\v2;

use tanglePHP\SingleNodeClient\Api\v2\Address\Ed25519;
use tanglePHP\SingleNodeClient\Api\v2\Address\Alias;
use tanglePHP\SingleNodeClient\Api\v2\Address\NFT;
use tanglePHP\SingleNodeClient\Api\v2\Feature\Issuer;
use tanglePHP\SingleNodeClient\Api\v2\Feature\Metadata;
use tanglePHP\SingleNodeClient\Api\v2\Feature\Sender;
use tanglePHP\SingleNodeClient\Api\v2\Feature\Tag;
use tanglePHP\SingleNodeClient\Api\v2\UnlockCondition\Address;
use tanglePHP\SingleNodeClient\Api\v2\UnlockCondition\Expiration;
use tanglePHP\SingleNodeClient\Api\v2\UnlockCondition\GovernorAddress;
use tanglePHP\SingleNodeClient\Api\v2\UnlockCondition\ImmutableAliasAddress;
use tanglePHP\SingleNodeClient\Api\v2\UnlockCondition\StateControllerAddress;
use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\InterfaceSerializer;
use tanglePHP\Core\Models\TraitSerializer;

/**
 * Class Output
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0818
 */
abstract class Output extends AbstractApi implements InterfaceSerializer {
  use TraitSerializer;

  /**
   * @param string $amount
   */
  public function __construct(string $amount = "0") {
    $this->amount = $amount;
  }

  /**
   * @param Ed25519|Alias|NFT $address
   *
   * @return $this
   */
  public function addUnlockConditionsAddress(Ed25519|Alias|NFT $address): self {
    $this->unlockConditions[] = new Address($address);

    return $this;
  }

  /**
   * @param Ed25519|Alias|NFT $returnAddress
   * @param int               $unixTime
   *
   * @return $this
   */
  public function addUnlockConditionsExpiration(Ed25519|Alias|NFT $returnAddress, int $unixTime = 0): self {
    $this->unlockConditions[] = new Expiration($returnAddress, $unixTime);

    return $this;
  }

  /**
   * @param Ed25519|Alias|NFT $address
   *
   * @return $this
   */
  public function addUnlockConditionsGovernorAddress(Ed25519|Alias|NFT $address): self {
    $this->unlockConditions[] = new GovernorAddress($address);

    return $this;
  }

  /**
   * @param Alias $address
   *
   * @return $this
   */
  public function addUnlockConditionsImmutableAliasAddress(Alias $address): self {
    $this->unlockConditions[] = new ImmutableAliasAddress($address);

    return $this;
  }

  /**
   * @param Ed25519|Alias|NFT $address
   *
   * @return $this
   */
  public function addUnlockConditionsStateControllerAddress(Ed25519|Alias|NFT $address): self {
    $this->unlockConditions[] = new StateControllerAddress($address);

    return $this;
  }

  /**
   * @param Ed25519|Alias|NFT $returnAddress
   *
   * @return $this
   */
  public function addUnlockConditionsStorageDepositReturn(Ed25519|Alias|NFT $returnAddress): self {
    $this->unlockConditions[] = new StateControllerAddress($returnAddress);

    return $this;
  }

  /**
   * @param Ed25519|Alias|NFT $returnAddress
   * @param int               $unixTime
   *
   * @return $this
   */
  public function addUnlockConditionsTimelock(Ed25519|Alias|NFT $returnAddress, int $unixTime = 0): self {
    $this->unlockConditions[] = new Expiration($returnAddress, $unixTime);

    return $this;
  }

  /**
   * @param Ed25519 $address
   * @param bool    $immutable
   *
   * @return $this
   */
  public function addFeaturesIssuer(Ed25519 $address, bool $immutable = false): self {
    $immutable ? $this->immutableFeatures[] = new Issuer($address) : $this->features[] = new Issuer($address);

    return $this;
  }

  /**
   * @param Ed25519 $address
   * @param bool    $immutable
   *
   * @return $this
   */
  public function addFeaturesSender(Ed25519 $address, bool $immutable = false): self {
    $immutable ? $this->immutableFeatures[] = new Sender($address) : $this->features[] = new Sender($address);

    return $this;
  }

  /**
   * @param string $hexString
   * @param bool   $immutable
   *
   * @return $this
   */
  public function addFeaturesMetadata(string $hexString, bool $immutable = false): self {
    $immutable ? $this->immutableFeatures[] = new Metadata($hexString) : $this->features[] = new Metadata($hexString);

    return $this;
  }

  /**
   * @param string $hexString
   * @param bool   $immutable
   *
   * @return $this
   */
  public function addFeaturesTag(string $hexString, bool $immutable = false): self {
    $immutable ? $this->immutableFeatures[] = new Tag($hexString) : $this->features[] = new Tag($hexString);

    return $this;
  }

  /**
   * @return array
   */
  public function serialize(): array {
    $_ret = [];
    // type
    $_ret[] = self::serializeUInt8($this->type);
    // amount
    $_ret[] = self::serializeUInt64($this->amount);
    // nativeTokens
    $_ret[] = self::serializeCountedObjectArray($this->nativeTokens  ?? []);
    // unlockConditions
    $_ret[] = self::serializeCountedObjectArray($this->unlockConditions  ?? []);
    // features
    $_ret[] = self::serializeCountedObjectArray($this->features ?? []);

    return $_ret;
  }
}