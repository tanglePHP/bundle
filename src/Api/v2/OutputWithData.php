<?php namespace tanglePHP\SingleNodeClient\Api\v2;

use tanglePHP\Core\Models\AbstractApi;
use tanglePHP\Core\Models\TraitSerializer;
use tanglePHP\Core\Helper\Converter;

/**
 * Class OutputWithData
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0818
 */
final class OutputWithData extends AbstractApi {
  use TraitSerializer;

  /**
   * @var string
   */
  public string $serializedBytes;
  /**
   * @var string
   */
  public string $serializedHex;

  /**
   * @param Output $output
   */
  public function __construct(public Output $output) {
    $this->serializedBytes = implode("", $this->output->serialize());
    $this->serializedHex   = Converter::string2Hex($this->serializedBytes);
  }
}