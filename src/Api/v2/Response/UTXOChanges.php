<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response;

use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\AbstractApiResponse;

/**
 * Class UTXOChanges
 *
 * @package      tanglePHP\singlenode-client\Api\v2\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.22-1129
 */
final class UTXOChanges extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $index;
  /**
   * @var ResponseArray
   */
  public ResponseArray $createdOutputs;
  /**
   * @var ResponseArray
   */
  public ResponseArray $consumedOutputs;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}