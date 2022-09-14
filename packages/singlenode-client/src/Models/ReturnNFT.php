<?php namespace tanglePHP\SingleNodeClient\Models;

use tanglePHP\Core\Models\ResponseArray;

/**
 * Class ReturnNFT
 *
 * @package      tanglePHP\SingleNodeClient\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0817
 */
final class ReturnNFT extends AbstractReturn {
  /**
   * @var string
   */
  public string $blockId;
  public string $transactionId;
  public string $nftId;
  public string $nftId_bech32;
  public string $explorerUrl;
  public ResponseArray $data;
}