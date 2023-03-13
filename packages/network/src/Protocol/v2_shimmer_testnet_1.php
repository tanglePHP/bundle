<?php namespace tanglePHP\Network\Protocol;

use tanglePHP\Network\Models\AbstractProtocol;

/**
 * Class v2_shimmer_testnet_1
 *
 * @package      tanglePHP\Network\Protocol
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2023, StefanBraun
 * @version      2023.03.13-0749
 */
final class v2_shimmer_testnet_1 extends AbstractProtocol {
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