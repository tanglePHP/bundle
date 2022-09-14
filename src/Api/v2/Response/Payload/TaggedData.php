<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response\Payload;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\AbstractApiResponse;

/**
 * Class TaggedData
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response\Payload
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0823
 */
final class TaggedData extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type;
  /**
   * @var string
   */
  public string $tag;
  /**
   * @var string
   */
  public string $data;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}