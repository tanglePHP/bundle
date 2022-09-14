<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApi;

/**
 * Class PayloadTransaction
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0829
 */
final class PayloadTransaction extends AbstractApi {
  /**
   * @var int
   */
  public int $type = 0;

  /**
   * PayloadTransaction constructor.
   *
   * @param EssenceTransaction $essence
   * @param array              $unlockBlocks
   */
  public function __construct(public EssenceTransaction $essence, public array $unlockBlocks = []) {
  }

  /**
   * @param $block
   */
  public function unlockBlocks($block) {
    $this->unlockBlocks[] = $block;
  }

}