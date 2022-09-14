<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ResponseInfo
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0828
 */
final class ResponseInfo extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $name;
  /**
   * @var string
   */
  public string $version;
  /**
   * @var bool
   */
  public bool $isHealthy;
  /**
   * @var string
   */
  public string $networkId;
  /**
   * @var string
   */
  public string $bech32HRP;
  /**
   * @var float
   */
  public float $minPoWScore;
  /**
   * @var float
   */
  public float $messagesPerSecond;
  /**
   * @var float
   */
  public float $referencedMessagesPerSecond;
  /**
   * @var float
   */
  public float $referencedRate;
  /**
   * @var int
   */
  public int $latestMilestoneTimestamp;
  /**
   * @var int
   */
  public int $latestMilestoneIndex;
  /**
   * @var int
   */
  public int $confirmedMilestoneIndex;
  /**
   * @var int
   */
  public int $pruningIndex;
  /**
   * @var ResponseArray
   */
  public ResponseArray $features;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->_input = JSON::create($this->_input['data']);
    $this->defaultParse();
  }
}