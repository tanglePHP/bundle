<?php namespace tanglePHP\ChronicleClient\Api\v2\Response;

use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Models\ResponseArray;

/**
 * Class LedgerUpdate
 *
 * @package      tanglePHP\ChronicleClient\Api\v2\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1213
 */
final class LedgerUpdate extends AbstractApiResponse {
  /**
   * @var string
   */
  public string $address;
  /**
   * @var ResponseArray
   */
  public ResponseArray $items;
  /**
   * @var string
   */
  public string $cursor;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    $this->defaultParse();
  }
}