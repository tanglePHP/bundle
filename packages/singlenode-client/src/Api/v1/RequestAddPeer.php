<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Models\AbstractApiRequest;

/**
 * Class RequestAddPeer
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0829
 */
final class RequestAddPeer extends AbstractApiRequest {
  /**
   * RequestPeer constructor.
   *
   * @param string      $multiAddress
   * @param string|null $alias
   */
  public function __construct(public string $multiAddress, public ?string $alias = null) {
  }
}