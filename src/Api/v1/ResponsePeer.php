<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ResponsePeer
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0826
 */
final class ResponsePeer extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $id;
  /**
   * @var array
   */
  public array $multiAddresses;
  /**
   * @var string
   */
  public string $alias;
  /**
   * @var string
   */
  public string $relation;
  /**
   * @var bool
   */
  public bool $connected;
  /**
   * @var array
   */
  public array $gossip;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}