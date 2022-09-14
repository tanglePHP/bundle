<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApi;

/**
 * Class UnlockBlocksReference
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0826
 */
final class UnlockBlocksReference extends AbstractApi {
  /**
   * @var int
   */
  public int $type = 1;

  /**
   * UnlockBlocksReference constructor.
   *
   * @param int $reference
   */
  public function __construct(public int $reference) {

  }
}