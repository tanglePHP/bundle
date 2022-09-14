<?php namespace tanglePHP\Network\Models;

use tanglePHP\Core\Models\AbstractMap;

/**
 * Class AbstractProtocol
 *
 * @package      tanglePHP\Network\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1147
 */
abstract class AbstractProtocol extends AbstractMap {
  /**
   * @var string
   */
  public string $nodeURL;
  /**
   * @var string
   */
  public string $basePath = 'api/core/v2/';
  /**
   * @var string|null
   */
  public ?string $explorerURL = null;
  /**
   * @var string|null
   */
  public ?string $chronicle_URL = null;
  /**
   * @var string|null
   */
  public ?string $chronicle_basePath = 'api/';
  /**
   * @var string|null
   */
  public ?string $faucet_URL = null;
  /**
   * @var string|null
   */
  public ?string $faucet_basePath = 'api/';
  /**
   * @var string|null
   */
  public ?string $market_URL = 'https://api.coingecko.com/';
  /**
   * @var string|null
   */
  public ?string $market_basePath = 'api/v3/';
  /**
   * @var int
   */
  public int $coinType = 4218;
  /**
   * @var string
   */
  public string $bech32HRP = 'atoi';
  /**
   * @var int
   */
  public int $timeout = 30;
  /**
   * @var int
   */
  public int $transactionCheckLimit = 30;
}