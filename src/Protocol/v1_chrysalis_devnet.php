<?php namespace tanglePHP\Network\Protocol;

use tanglePHP\Network\Models\AbstractProtocol;

/**
 * Class v1_chrysalis_devnet
 *
 * @package      tanglePHP\Network\Protocol
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1147
 */
final class v1_chrysalis_devnet extends AbstractProtocol {
  /**
   * @var string|null
   */
  public ?string $explorerURL = 'https://explorer.iota.org/devnet';
  /**
   * @var string|null
   */
  public ?string $chronicle_URL = null;
  /**
   * @var string|null
   */
  public ?string $chronicle_basePath = null;
  /**
   * @var string|null
   */
  public ?string $faucet_URL = 'https://faucet.chrysalis-devnet.iota.cafe';
  /**
   * @var string|null
   */
  public ?string $faucet_basePath = 'api/plugins/faucet/';
  /**
   * @var int
   */
  public int $coinType = 4218;
  /**
   * @var string
   */
  public string $bech32HRP = 'atoi';
}