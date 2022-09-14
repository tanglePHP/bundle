<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response;

use tanglePHP\Core\Models\AbstractApiResponse;

/**
 * Class BlockMetadata
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0822
 */
final class BlockMetadata extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $blockId;
  /**
   * @var array
   */
  public array $parents;
  /**
   * @var bool
   */
  public bool $isSolid;
  /**
   * @var int
   */
  public int $referencedByMilestoneIndex;
  /**
   * @var int
   */
  public int $milestoneIndex;
  /**
   * @var string
   */
  public string $ledgerInclusionState;
  /**
   * @var int
   */
  public int $conflictReason;
  /**
   * @var bool
   */
  public bool $shouldPromote;
  /**
   * @var bool
   */
  public bool $shouldReattach;

  /**
   * @return void
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      $this->{$_k} = $_v;
    }
  }
}