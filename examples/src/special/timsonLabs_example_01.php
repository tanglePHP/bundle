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
     *
     * @return JSON|ReturnAddressBalance
     * @throws Api
     * @throws Converter
     * @throws Helper
     */
    public function getBalance(string $address): JSON|ReturnAddressBalance {

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
      } else {
        // default to shimmer_testnet
      $useNetwork = $this->networks['shimmer_testnet'] = $this->networks['shimmer_testnet'] ?? new Connect('shimmer:testnet');
      }

      return (new getBalance($useNetwork))->address($address)
                                          ->run();
    }

  }
  $example = new timsonLabs_example_01();
  $ret     = $example->getBalance('atoi1qqghchyvvegq3jt0a4jg5392t63zmfhk0pkqj8czpelr7ey67ekgsat9sky');
  if(isset($ret->balance)) {
    print_r($ret->marketData_balance->__toArray());
  } else {
    // handle return!
    echo $ret;
  }
  // outputs like this
  /*
    Array
    (
        [last_updated_at] => 1663345383
        [balance] => 10000000
        [balanceCalc] => 10
        [coin] => iota
        [price] => Array
            (
                [usd] => 0.260018
                [eur] => 0.259846
                [last_updated_at] => 1663345383
            )

        [calc] => Array
            (
                [usd] => 2.60018
                [eur] => 2.59846
            )

    )
  */