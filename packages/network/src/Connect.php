<?php namespace tanglePHP\Network;

use Exception;
use tanglePHP\Network\Models\EndpointList;
use tanglePHP\Network\Endpoint\ChronicleNode;
use tanglePHP\Network\Endpoint\FaucetServer;
use tanglePHP\Network\Endpoint\MarketServer;
use tanglePHP\Network\Endpoint\SingleNode;
use tanglePHP\Core\Exception\Api as ApiException;
use tanglePHP\Core\Exception\Helper as HelperException;
use tanglePHP\Network\SingleNodesList\chrysalis_devnet;
use tanglePHP\Network\SingleNodesList\chrysalis_mainnet;
use tanglePHP\Network\SingleNodesList\pool_dltgreen;
use tanglePHP\Network\SingleNodesList\shimmer_testnet;
use tanglePHP\Network\SingleNodesList\user;
use tanglePHP\SingleNodeClient\Connector as SingleNodeConnector;
use tanglePHP\FaucetClient\Connector as FaucetClientConnector;
use tanglePHP\MarketClient\Connector as MarketClientConnector;
use tanglePHP\ChronicleClient\Connector as ChronicleClientConnector;

/**
 * Class Connect
 *
 * @package      tanglePHP\Network
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.24-1049
 */
final class Connect {
  /**
   * @var EndpointList
   */
  public EndpointList $ENDPOINT;
  /**
   * @var SingleNodeConnector
   */
  public SingleNodeConnector $singleNode;
  /**
   * @var ChronicleClientConnector
   */
  public ChronicleClientConnector $chronicleNode;
  /**
   * @var FaucetClientConnector
   */
  public FaucetClientConnector $faucetServer;
  /**
   * @var MarketClientConnector
   */
  public MarketClientConnector $marketServer;
  /**
   * @var string|null
   */
  public ?string $EXPLORER;
  /**
   * @var array
   */
  public array $info = [
    'network'           => null,
    'networkName'       => null,
    'networkId'         => null,
    'protocolVersion'   => null,
    'singleNodeName'    => null,
    'singleNodeVersion' => null,
    'singleNodeHealthy' => null,
    'features'          => [],
    'baseToken'         => '',
    'coinType'          => 0,
    'bech32Hrp'         => null,
  ];

  /**
   * @param string|null $url
   *
   * @throws ApiException
   * @throws HelperException
   */
  public function __construct(string $url = null) {
    switch($url) {
      case 'devnet':
      case 'iota:devnet':
      case 'chrysalis:devnet':
        $url = (new chrysalis_devnet($this))->getURL();
        break;
      case 'mainnet':
      case 'iota:mainnet':
      case 'chrysalis:mainnet':
        $url = (new chrysalis_mainnet($this))->getURL();
        break;
      case 'dltgreen:mainnet':
        $url = (new pool_dltgreen($this, 'mainnet'))->getURL();
        break;
      case 'dlt.green':
      case 'dltgreen':
      case 'dltgreen:testnet':
        $url = (new pool_dltgreen($this, 'testnet'))->getURL();
        break;
      case null:
      case '':
      case 'testnet':
      case 'shimmer:testnet':
        $url = (new shimmer_testnet($this))->getURL();
        break;
    }
    if(is_string($url)) {
      $url = (new user($this, $url))->getURL();
    }
    // create ENDPOINT
    $this->ENDPOINT = new EndpointList();
    // set singeNode vars
    $this->ENDPOINT->singleNode            = new SingleNode($this, $url[0], $url[1]);
    $this->ENDPOINT->singleNode->connector = $this->singleNode = new SingleNodeConnector($this->ENDPOINT->singleNode);
    $this->ENDPOINT->singleNode->init();
    //
    $this->ENDPOINT->market            = new MarketServer($this);
    $this->ENDPOINT->market->connector = $this->marketServer = new MarketClientConnector($this->ENDPOINT->market);
    #$this->ENDPOINT->market->init();
    //
    $protocolClassName = '\\tanglePHP\\Network\\Protocol\\v' . $this->info['protocolVersion'] . '_' . $this->info['network'] . '_' . $this->info['networkName'];
    if(!class_exists($protocolClassName)) {
      throw new Exception("tanglePHP does not support this unknown protocol. : 'v" . $this->info['protocolVersion'] . '_' . $this->info['network'] . '_' . $this->info['networkName'] . "'");
    }
    $protocolClass = new $protocolClassName();
    if(isset($protocolClass->chronicle_URL)) {
      $this->ENDPOINT->chronicleNode            = new ChronicleNode($this, $protocolClass->chronicle_URL, $protocolClass->chronicle_basePath);
      $this->ENDPOINT->chronicleNode->connector = $this->chronicleNode = new ChronicleClientConnector($this->ENDPOINT->chronicleNode);
      #$this->ENDPOINT->chronicleNode->init();
    }
    //
    if(isset($protocolClass->faucet_URL)) {
      $this->ENDPOINT->faucet            = new FaucetServer($this, $protocolClass->faucet_URL, $protocolClass->faucet_basePath);
      $this->ENDPOINT->faucet->connector = $this->faucetServer = new FaucetClientConnector($this->ENDPOINT->faucet);
      #$this->ENDPOINT->faucet->init();
    }
    $this->EXPLORER = $protocolClass->explorerURL . (str_ends_with($protocolClass->explorerURL, '/') ? '' : '/');
  }

  /**
   * @return bool
   */
  public function hasChronicleNode(): bool {
    return isset($this->chronicleNode);
  }

  /**
   * @return bool
   */
  public function hasFaucetServer(): bool {
    return isset($this->faucetServer);
  }

  /**
   * @return string[]
   */
  public function getENDPOINTUrls(): array {
    $ret = ['explorer' => $this->EXPLORER ?? ''];
    foreach((array)$this->ENDPOINT as $name => $endpoint) {
      if(isset($endpoint)) {
        $ret[$name] = $endpoint->url . $endpoint->basePath;
      }
    }

    return $ret;
  }

  /**
   * @return string
   */
  public function getExplorerUrl(): string {
    return $this->EXPLORER;
  }

  /**
   * @param string $blockId
   *
   * @return string
   */
  public function getExplorerUrlBlock(string $blockId): string {
    return $this->getExplorerUrl() . 'block/' . $blockId;
  }

  /**
   * @param string $nftAddress
   *
   * @return string
   */
  public function getExplorerUrlNFT(string $nftAddress): string {
    return $this->getExplorerUrl() . 'nft/' . $nftAddress;
  }

  /**
   * @param string $blockId
   *
   * @return string
   */
  public function getExplorerUrlMessage(string $blockId): string {
    return $this->getExplorerUrl() . 'message/' . $blockId;
  }
}