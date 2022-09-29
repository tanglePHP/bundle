<?php namespace tanglePHP\Network\Models;

use tanglePHP\Core\Models\AbstractMap;
use tanglePHP\Core\Helper\ApiCaller;
use tanglePHP\Core\Helper\Converter;
use tanglePHP\Core\Helper\Hash;
use tanglePHP\Core\Helper\JSON;
use tanglePHP\Network\Connect;
use Exception;
use SodiumException;
use tanglePHP\Core\Exception\Converter as ConverterException;
use tanglePHP\Core\Exception\Api as ApiException;

/**
 * Class AbstractSingleNodesList
 *
 * @package      tanglePHP\Network\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1147
 */
abstract class AbstractSingleNodesList extends AbstractMap {
  /**
   * @var array
   */
  protected array $urls = [];
  /**
   * @var array
   */
  protected array $checkPath = [
    '',
    'api/core/v2/',
    'core/v2/',
    'api/v1/',
    'v1/',
  ];
  /**
   * @var array
   */
  protected array $healthyUrl;

  /**
   * @param Connect $network
   *
   * @throws Exception
   */
  public function __construct(protected Connect $network) {
    $url = $this->getRandomURL();
    if(!filter_var($url, FILTER_VALIDATE_URL)) {
      throw new Exception('Unknown Node URL: ' . $url);
    }
    $url .= (str_ends_with($url, '/') ? '' : '/');
    //
    if(!($url = $this->checkPath($url))) {
      throw new Exception('Can not connect to NodeURL or Api not found: ' . $url);
    }
    //
    $parsed_url = parse_url($url);
    $scheme     = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
    $host       = $parsed_url['host'] ?? '';
    $port       = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
    $user       = $parsed_url['user'] ?? '';
    $pass       = isset($parsed_url['pass']) ? ':' . $parsed_url['pass'] : '';
    $pass       = ($user || $pass) ? "$pass@" : '';
    $path       = $parsed_url['path'] ?? '';
    $path       = str_starts_with($path, '/') ? substr($path, 1) : $path;
    #$query      = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
    #$fragment   = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
    $this->healthyUrl = [
      "$scheme$user$pass$host$port",
      $path,
    ];
  }

  /**
   * @return string
   * @throws Exception
   */
  private function getRandomURL(): string {
    return $this->urls[random_int(0, count($this->urls) - 1)];
  }

  /**
   * @return array
   * @throws Exception
   */
  public function getURL(): array {
    if(!isset($this->healthyUrl)) {
      throw new Exception('No healthy Url nodeURL found :-(');
    }

    return $this->healthyUrl;
  }

  /**
   * @param string $networkName
   *
   * @return int
   * @throws ConverterException
   * @throws SodiumException
   */
  private function parseNetworkId(string $networkName): int {
    return Converter::hex2BigInt(Converter::string2Hex(substr(Hash::blake2b_sum256($networkName), 0, 8), true));
  }

  /**
   * @param $url
   *
   * @return string|false
   * @throws ApiException
   * @throws ConverterException
   * @throws SodiumException
   */
  private function checkPath($url): string|false {
    foreach($this->checkPath as $path) {
      $urlFull = $url . $path;
      if($this->checkNode($urlFull)) {
        return $urlFull;
      }
    }

    return false;
  }

  /**
   * @param $url
   *
   * @return bool
   * @throws ApiException
   * @throws ConverterException
   * @throws SodiumException
   */
  private function checkNode($url): bool {
    $ApiCaller = (new ApiCaller($url));
    try {
      $info = $ApiCaller->route('info')
                        ->fetchJSON();
    }
    catch(Exception) {
      return false;
    }
    if($info instanceof JSON) {
      // is protocol v1 (Chrysalis)
      if(isset($info['data']) && isset($info['data']['networkId'])) {
        $this->network->info['protocolVersion']   = '1';
        $this->network->info['network']           = strstr($info['data']['networkId'], '-', true);
        $this->network->info['networkName']       = substr(strstr($info['data']['networkId'], '-'), 1);
        $this->network->info['networkId']         = $this->parseNetworkId($this->network->info['networkName']);
        $this->network->info['singleNodeName']    = $info['data']['name'];
        $this->network->info['singleNodeVersion'] = $info['data']['version'];
        $this->network->info['singleNodeHealthy'] = $info['data']['isHealthy'];
        $this->network->info['features']          = $info['data']['features'] ?? [];
        $this->network->info['baseToken']         = 'IOTA';
        $this->network->info['coinType']          = $this->network->info['baseToken'] == "SMR" ? 4219 : 4218;
        $this->network->info['bech32Hrp']         = $info['data']['bech32HRP'];

        return true;
      }
      // is protocol v2 (Stardust)
      if(isset($info['protocol']) && isset($info['protocol']['version'])) {
        $this->network->info['protocolVersion']   = $info['protocol']['version'];
        $this->network->info['network']           = strtolower($info['baseToken']['name']);
        $this->network->info['networkName']       = $info['protocol']['networkName'];
        $this->network->info['networkId']         = $this->parseNetworkId($this->network->info['networkName']);
        $this->network->info['singleNodeName']    = $info['name'];
        $this->network->info['singleNodeVersion'] = $info['version'];
        $this->network->info['singleNodeHealthy'] = $info['status']['isHealthy'];
        $this->network->info['features']          = $info['features'] ?? [];
        $this->network->info['baseToken']         = $info['baseToken']['unit'];
        $this->network->info['coinType']          = $this->network->info['baseToken'] == "SMR" ? 4219 : 4218;
        $this->network->info['bech32Hrp']         = $info['protocol']['bech32Hrp'];

        return true;
      }
    }

    return false;
  }
}