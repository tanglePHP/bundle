<?php namespace tanglePHP\SingleNodeClient\Api\v1;

use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ResponseOutput
 *
 * @package      tanglePHP\SingleNodeClient\Api\v1
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0828
 */
final class ResponseOutput extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $messageId;
  /**
   * @var string
   */
  public string $transactionId;
  /**
   * @var int
   */
  public int $outputIndex;
  /**
   * @var bool
   */
  public bool $isSpent;
  /**
   * @var ResponseArray
   */
  public ResponseArray $output;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->_input = JSON::create($this->_input['data']);
    $this->defaultParse();
  }
}