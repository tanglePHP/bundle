<?php namespace tanglePHP\Network\Protocol;

use tanglePHP\Network\Models\AbstractProtocol;

/**
 * Class v2_shimmer_testnet
 *
 * @package      tanglePHP\Network\Protocol
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.09.03-1147
 */
final class v2_shimmer_testnet extends AbstractProtocol {
  /**
   * @var string|null
   */
  public ?string $explorerURL = 'https://explorer.shimmer.network/testnet';
  /**
   * @var string|null
   */
  public ?string $chronicle_URL = 'https://chronicle.testnet.shimmer.network';
  /**
   * @var string|null
   */
  public ?string $chronicle_basePath = 'api/';
  /**
   * @var string|null
   */
  public ?string $faucet_URL = 'https://faucet.testnet.shimmer.network';
  /**
   * @var string|null
   */
  public ?string $faucet_basePath = 'api/';
  /**
   * @var int
   */
  public int $coinType = 4219;
  /**
   * @var string
   */
  public string $bech32HRP = 'rms';
}