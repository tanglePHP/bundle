<?php namespace tanglePHP\Network\Models;

use tanglePHP\Core\Models\AbstractMap;
use tanglePHP\Network\Endpoint\ChronicleNode;
use tanglePHP\Network\Endpoint\FaucetServer;
use tanglePHP\Network\Endpoint\MarketServer;
use tanglePHP\Network\Endpoint\SingleNode;

/**
 * Class EndpointList
 *
 * @package      tanglePHP\Network\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1147
 */
final class EndpointList extends AbstractMap {
  /**
   * @var SingleNode
   */
  public SingleNode $singleNode;
  /**
   * @var FaucetServer
   */
  public FaucetServer $faucet;
  /**
   * @var MarketServer
   */
  public MarketServer $market;
  /**
   * @var ChronicleNode
   */
  public ChronicleNode $chronicleNode;
}