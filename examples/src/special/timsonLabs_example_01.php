<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\getBalance;

  /**
   * Class timsonLabs_example_01
   *
   * @author       Stefan Braun <stefan.braun@tanglePHP.com>
   * @copyright    Copyright (c) 2022, StefanBraun
   * @version      2022.09.16-1223
   */
  class timsonLabs_example_01 {
    /**
     * @var array|null[]
     */
    protected array $networks = [
      'iota'            => null,
      'shimmer'         => null,
      'iota_devnet'     => null,
      'shimmer_testnet' => null,
    ];

    /**
     *
     */
    public function __construct() {
    }

    /**
     * @return \tanglePHP\Core\Helper\JSON|\tanglePHP\SingleNodeClient\Models\ReturnAddressBalance
     * @throws \tanglePHP\Core\Exception\Api
     * @throws \tanglePHP\Core\Exception\Converter
     * @throws \tanglePHP\Core\Exception\Helper
     */
    public function getBalance(string $address, bool $calcMarketData = true): \tanglePHP\SingleNodeClient\Models\ReturnAddressBalance {

      if(str_starts_with($address, 'smr')) {
        $useNetwork = $this->networks['shimmer'] = $this->networks['shimmer'] ?? new Connect('shimmer:mainnet');
      }
      elseif(str_starts_with($address, 'rms')) {
        $useNetwork = $this->networks['shimmer_testnet'] = $this->networks['shimmer_testnet'] ?? new Connect('shimmer:testnet');
      }
      elseif(str_starts_with($address, 'iota')) {
        $useNetwork = $this->networks['iota'] = $this->networks['iota'] ?? new Connect('iota:mainnet');
      }
      elseif(str_starts_with($address, 'atoi')) {
        $useNetwork = $this->networks['iota_devnet'] = $this->networks['iota_devnet'] ?? new Connect('iota:devnet');
      }
      $ret = (new getBalance($useNetwork))->address($address)
                                          ->run();
      if($calcMarketData) {
        $ret->calcedMarketData = $this->calcMarketData((int)$ret->balance, $ret->marketData->__toArray());
      }

      return $ret;
    }

    public function calcMarketData(int $balance, array $marketData): array {
      [$coin] = array_keys($marketData);
      //
      $ret = [
        'balance' => $balance,
        'balanceCalc' => $balance / 1000000,
        'coin'    => $coin,
        'price'   => $marketData[$coin],
        'calc'    => [
          'usd' => $balance / 1000000 * $marketData[$coin]['usd'],
          'eur' => $balance / 1000000 * $marketData[$coin]['eur'],
        ],
      ];

      return $ret;
    }
  }
  $example = new timsonLabs_example_01();
  $ret     = $example->getBalance('atoi1qqghchyvvegq3jt0a4jg5392t63zmfhk0pkqj8czpelr7ey67ekgsat9sky', true);

  print_r($ret->calcedMarketData);

  // outputs like this
  /*
  Array
    (
        [balance] => 10000000
        [balanceCalc] => 10
        [coin] => iota
        [price] => Array
            (
                [usd] => 0.261515
                [eur] => 0.262077
                [last_updated_at] => 1663325034
            )

        [calc] => Array
            (
                [usd] => 2.61515
                [eur] => 2.62077
            )

    )
  */