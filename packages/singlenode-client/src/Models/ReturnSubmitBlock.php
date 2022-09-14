<?php namespace tanglePHP\SingleNodeClient\Models;

use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\MarketClient\Api\CoinGecko\v3\Response\Price;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class ReturnSubmitBlock
 *
 * @package      tanglePHP\SingleNodeClient\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0817
 */
final class ReturnSubmitBlock extends AbstractReturn {
  /**
   * @var false|string
   */
  public false|string $blockId = false;
  /**
   * @var string|null
   */
  public ?string $check = null;
  /**
   * @var false|string
   */
  public false|string $explorerUrl = false;
  /**
   * @var ResponseArray{nftId:string,nftId_bech32:string}
   */
  public null|ReturnNFT $metadata;
  /**
   * @var Price|null
   */
  public null|Price $marketData;
  /**
   * @var ResponseArray
   */
  public ResponseArray $networkInfo;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      if($_k == 'marketData') {
        $this->marketData = new Price($_v);
        continue;
      }
      if(is_array($_v)) {
        $_v = new ResponseArray($_v);
      }
      $this->{$_k} = $_v;
    }
  }
}