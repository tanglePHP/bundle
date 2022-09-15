<?php namespace tanglePHP\Network\Endpoint;

use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Network\Models\AbstractEndpoint;

/**
 * Class SingleNode
 *
 * @package      tanglePHP\Network\Endpoint
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1147
 */
final class SingleNode extends AbstractEndpoint {
  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  public function init(): void {
    parent::init();
    if($this->network->info['protocolVersion'] == "1") {
      $this->needFeature('PoW');
    }
    else {
      $this->needFeature('pow');
    }
    $this->needPlugin('core', 'v2');
    $this->needPlugin('indexer', 'v1');
  }
}