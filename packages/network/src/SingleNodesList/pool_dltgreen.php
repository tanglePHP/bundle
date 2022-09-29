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
 * @version      2022.09.29-1901
 */
final class pool_dltgreen extends AbstractSingleNodesList {
  /**
   * @param Connect $network
   * @param string  $protocol
   *
   * @throws ApiException
   * @throws HelperException
   */
  public function __construct(protected Connect $network, public string $protocol) {
    $this->getNodesFromApi();
    parent::__construct($this->network);
  }

  /**
   * @return void
   * @throws ApiException
   * @throws HelperException
   */
  private function getNodesFromApi(): void {
    $API_CALLER = (new ApiCaller('https://dlt.green/'));
    $query      = [
      'dns'   => $this->protocol,
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
      $info = $nodes["dlt.green"] ?? null;
      #$info['PoolRank']
      #$info['PoolMana']
      //
      foreach($nodes as $nodeType => $node) {

        if(!$node['isHealthy']) {
          continue;
        }
        //
        if((($nodeType != "ShimmerBee" || $nodeType != "ShimmerHornet") && $this->protocol != "shimmer") && (($nodeType != "IotaBee" || $nodeType != "IotaHornet") && $this->protocol != "iota")) {
          continue;
        }
        //
        $features = $node['Features'] ?? [];
        if(in_array('PoW', $features) || in_array('pow', $features)) {
          $this->urls[] = 'https://' . $node['Domain'] . ':' . $node['Port'] . '/';
        }
      }
    }
  }
}