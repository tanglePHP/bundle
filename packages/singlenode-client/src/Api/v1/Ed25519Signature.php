<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApi;

/**
 * Class Ed25519Signature
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0829
 */
final class Ed25519Signature extends AbstractApi {
  /**
   * @var int
   */
  public int $type = 0;

  /**
   * Ed25519Signature constructor.
   *
   * @param string $publicKey
   * @param string $signature
   */
  public function __construct(public string $publicKey, public string $signature) {

  }
}