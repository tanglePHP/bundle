<?php namespace tanglePHP\Network\Protocol;

use tanglePHP\Network\Models\AbstractProtocol;

/**
 * Class v1_chrysalis_mainnet
 *
 * @package      tanglePHP\Network\Protocol
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1147
 */
final class v1_chrysalis_mainnet extends AbstractProtocol {
  /**
   * @var string|null
   */
  public ?string $explorerURL = 'https://explorer.iota.org/mainnet';
  /**
   * @var string|null
   */
  public ?string $chronicle_URL = 'https://chrysalis-chronicle.iota.org/';
  /**
   * @var string|null
   */
  public ?string $chronicle_basePath = 'api/mainnet';
  /**
   * @var string|null
   */
  public ?string $faucet_URL = null;
  /**
   * @var string|null
   */
  public ?string $faucet_basePath = null;
  /**
   * @var int
   */
  public int $coinType = 4218;
  /**
   * @var string
   */
  public string $bech32HRP = 'iota';
}