<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response;

use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class MilestonePayload
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0823
 */
final class MilestonePayload extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type;
  /**
   * @var int
   */
  public int $index;
  /**
   * @var int
   */
  public int $timestamp;
  /**
   * @var int
   */
  public int $protocolVersion;
  /**
   * @var string
   */
  public string $previousMilestoneId;
  /**
   * @var ResponseArray
   */
  public ResponseArray $parents;
  /**
   * @var string
   */
  public string $inclusionMerkleRoot;
  /**
   * @var string
   */
  public string $appliedMerkleRoot;
  /**
   * @var ResponseArray
   */
  public ResponseArray $options;
  /**
   * @var string
   */
  public string $metadata;
  /**
   * @var ResponseArray
   */
  public ResponseArray $signatures;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}