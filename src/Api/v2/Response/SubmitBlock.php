<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\AbstractApiResponse;

/**
 * Class SubmitBlock
 *
 * @package      tanglePHP\singlenode-client\Api\v2\Response
 * @author       StefanBraun @tanglePHP
 * @copyright    Copyright (c) 2022, StefanBraun
 */
final class SubmitBlock extends AbstractApiResponse {
  public string $blockId;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}