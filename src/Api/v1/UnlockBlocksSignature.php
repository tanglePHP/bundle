<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApi;

/**
 * Class UnlockBlocksSignature
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0826
 */
final class UnlockBlocksSignature extends AbstractApi {
  /**
   * @var int
   */
  public int $type = 0;

  /**
   * UnlockBlocks constructor.
   *
   * @param Ed25519Signature $signature
   */
  public function __construct(public Ed25519Signature $signature) {

  }
}