<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  use tanglePHP\Core\Exception\Api;
  use tanglePHP\Core\Exception\Converter;
  use tanglePHP\Core\Exception\Helper;
  use tanglePHP\Core\Helper\JSON;
  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\getBalance;
  use tanglePHP\SingleNodeClient\Models\ReturnAddressBalance;

  /**
   * Class timsonLabs_example_01
   *
   * @author       Stefan Braun <stefan.braun@tanglePHP.com>
   * @copyright    Copyright (c) 2022, StefanBraun
   * @version      2022.09.16-1249
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
     * @param string $address
     * @param bool   $calcMarketData
     *
     * @return JSON|ReturnAddressBalance
     * @throws Api
     * @throws Converter
     * @throws Helper
     */
    public function getBalance(string $address, bool $calcMarketData = true): JSON|ReturnAddressBalance {

      $useNetwork = null;

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
      if(isset($ret->balance)) {
        if($calcMarketData) {
          $ret->calcedMarketData = $this->calcMarketData((int)$ret->balance, $ret->marketData->__toArray());
        }
      }

      return $ret;
    }

    /**
     * @param int   $balance
     * @param array $marketData
     *
     * @return array
     */
    public function calcMarketData(int $balance, array $marketData): array {
      [$coin] = array_keys($marketData);
      //
      return [
        'balance'     => $balance,
        'balanceCalc' => $balance / 1000000,
        'coin'        => $coin,
        'price'       => $marketData[$coin],
        'calc'        => [
          'usd' => $balance / 1000000 * $marketData[$coin]['usd'],
          'eur' => $balance / 1000000 * $marketData[$coin]['eur'],
        ],
      ];
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