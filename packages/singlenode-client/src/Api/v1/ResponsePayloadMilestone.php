<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ResponsePayloadMilestone
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0827
 */
final class ResponsePayloadMilestone extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type = 1;
  /**
   * @var int
   */
  public int $index;
  /**
   * @var int
   */
  public int $timestamp;
  /**
   * @var array
   */
  public array $parents;
  /**
   * @var string
   */
  public string $inclusionMerkleProof;
  /**
   * @var string
   */
  public string $nextPoWScore;
  /**
   * @var string
   */
  public string $nextPoWScoreMilestoneIndex;
  /**
   * @var array
   */
  public array $publicKeys;
  /**
   * @var array
   */
  public array $signatures;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}