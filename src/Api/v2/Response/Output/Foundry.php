<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response\Output;

use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\SingleNodeClient\Api\v2\TokenScheme;

/**
 * Class Foundry
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response\Output
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0824
 */
final class Foundry extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type;
  /**
   * @var string
   */
  public string $amount;
  /**
   * @var ResponseArray
   */
  public ResponseArray $nativeTokens;
  /**
   * @var string
   */
  public string $serialNumber;
  /**
   * @var TokenScheme
   */
  public TokenScheme $tokenScheme;
  /**
   * @var ResponseArray
   */
  public ResponseArray $unlockConditions;
  /**
   * @var ResponseArray
   */
  public ResponseArray $features;
  /**
   * @var ResponseArray
   */
  public ResponseArray $immutableFeatures;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      if($_k == 'tokenScheme') {
        $tokenSheme        = new TokenScheme($_v['mintedTokens'], $_v['meltedTokens'], $_v['maximumSupply']);
        $tokenSheme->type  = $_v['type'];
        $this->tokenScheme = $tokenSheme;
        continue;
      }
      if(is_array($_v)) {
        $_v = new ResponseArray($_v);
      }
      $this->{$_k} = $_v;
    }
  }
}