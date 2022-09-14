<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ResponseMessageMetadata
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0828
 */
final class ResponseMessageMetadata extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $messageId;
  /**
   * @var ResponseArray
   */
  public ResponseArray $parentMessageIds;
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
   * @throws HelperException
   */
  protected function parse(): void {
    $this->_input = JSON::create($this->_input['data']);
    $this->defaultParse();
  }
}