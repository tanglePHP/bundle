<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response;

use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Alias;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Basic;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Foundry;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\NFT;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class Output
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0823
 */
final class Output extends AbstractApiResponse {
  /**
   * @var Metadata
   */
  public Metadata $metadata;
  /**
   * @var ResponseArray|Basic|Alias|Foundry|NFT
   */
  public ResponseArray|Basic|Alias|Foundry|NFT $output;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      if($_k == 'metadata') {
        $this->metadata = new Metadata($_v);
        continue;
      }
      if($_k == 'output') {
        switch($_v['type']) {
          case 3;
            $this->output = new Basic($_v);
            break;
          case 4;
            $this->output = new Alias($_v);
            break;
          case 5;
            $this->output = new Foundry($_v);
            break;
          case 6;
            $this->output = new NFT($_v);
            break;
        }
        continue;
      }
      if(is_array($_v)) {
        $_v = new ResponseArray($_v);
      }
      $this->{$_k} = $_v;
    }
  }
}