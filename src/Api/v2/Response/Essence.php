<?php namespace tanglePHP\SingleNodeClient\Api\v2\Response;

use tanglePHP\Core\Models\ResponseArray;
use tanglePHP\SingleNodeClient\Api\v2\Response\Input\UTXO;
use tanglePHP\SingleNodeClient\Api\v2\Response\Input\Treasury;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Alias;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Basic;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\Foundry;
use tanglePHP\SingleNodeClient\Api\v2\Response\Output\NFT;
use tanglePHP\SingleNodeClient\Api\v2\Response\Payload\TaggedData;
use tanglePHP\Core\Models\AbstractApiResponse;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class Essence
 *
 * @package      tanglePHP\SingleNodeClient\Api\v2\Response
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.13-0823
 */
final class Essence extends AbstractApiResponse {
  /**
   * @var int
   */
  public int $type;
  /**
   * @var string
   */
  public string $networkId;
  /**
   * @var string
   */
  public string $inputsCommitment;
  /**
   * @var array
   */
  public array $inputs = [];
  /**
   * @var array
   */
  public array $outputs = [];
  /**
   * @var Payload\TaggedData
   */
  public TaggedData $payload;

  /**
   * @return void
   * @throws HelperException
   */
  protected function parse(): void {
    foreach($this->_input->__toArray() as $_k => $_v) {
      if($_k == 'payload') {
        $this->payload = new TaggedData($_v);
        continue;
      }
      if($_k == 'outputs') {
        foreach($_v as $_v2) {
          switch($_v2['type']) {
            case 3;
              $this->outputs[] = new Basic($_v2);
              break;
            case 4;
              $this->outputs[] = new Alias($_v2);
              break;
            case 5;
              $this->outputs[] = new Foundry($_v2);
              break;
            case 6;
              $this->outputs[] = new NFT($_v2);
              break;
          }
        }
        continue;
      }
      if($_k == 'inputs') {
        foreach($_v as $_v2) {
          switch($_v2['type']) {
            case 0;
              $this->inputs[] = new UTXO($_v);
              break;
            case 1;
              $this->inputs[] = new Treasury($_v);
              break;
          }
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