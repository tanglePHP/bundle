<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApiRequest;

/**
 * Class RequestSubmitMessage
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0829
 */
final class RequestSubmitMessage extends AbstractApiRequest {
  /**
   * @var string
   */
  public string $networkId;
  /**
   * @var array
   */
  public array $parentMessageIds;
  /**
   * @var string
   */
  public string $nonce = "0";

  /**
   * RequestSubmitMessage constructor.
   *
   * @param mixed $payload
   */
  public function __construct(public PayloadIndexation|PayloadTransaction $payload) {
  }
}