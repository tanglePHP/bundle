<?php namespace tanglePHP\Network\SingleNodesList;

use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Core\Helper\ApiCaller;
use tanglePHP\Network\Connect;
use tanglePHP\Network\Models\AbstractSingleNodesList;

/**
 * Class pool_dltgreen
 *
 * @package      tanglePHP\Network\SingleNodesList
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1148
 */
final class pool_dltgreen extends AbstractSingleNodesList {
  /**
   * @param Connect $network
   * @param string  $net
   *
   * @throws ApiException
   * @throws HelperException
   */
  public function __construct(protected Connect $network, public string $net) {
    $this->getNodesFromApi();
    parent::__construct($this->network);
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  private function getNodesFromApi() {
    $API_CALLER = (new ApiCaller('https://dlt.green/'));
    $query      = [
      'dns'   => 'poolmana',
      'id'    => 'iota.php',
      'token' => '9ugxfia7sl5qz3l1a8def4d2gp7imoln',
    ];
    //
    $nodeList = $API_CALLER->query($query)
                           ->route('api')
                           ->fetchJSON(30);
    //
    foreach($nodeList->__toArray() as $name => $nodes) {
      $info = $nodes["dlt.green"] ?? null;
      #$info['PoolRank']
      #$info['PoolMana']

      //
      foreach($nodes as $nodeType => $node) {
        if((($nodeType == "Bee" || $nodeType == "Hornet") && $this->net == "mainnet" || ($nodeType == "ShimmerBee" || $nodeType == "ShimmerHornet") && $this->net == "testnet") && $node['isHealthy'] == "1") {
          $features = $node['Features'] ?? [];

          if(in_array('PoW', $features) || in_array('pow', $features)) {
            $this->urls[] = 'https://' . $node['Domain'] . ':' . $node['Port'] . '/';
          }
        }
      }
    }
  }
}