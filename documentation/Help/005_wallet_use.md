![](.meta/Banner.png)

> #### Please be aware that this Examples are in an early development state and the API of the library as well as the "Stardust" protocol is subject to change, it is NOT ready to use in production.

<a href="https://discord.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Discord-9cf.svg?style=social&logo=discord" alt="Discord"></a>
<a href="https://twitter.com/tanglePHP/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Twitter-@tanglePHP-9cf.svg?style=social&logo=twitter" alt="Twitter"></a> ‖
<a href="https://www.tanglephp.com/" style="text-decoration:none;"><img src="https://img.shields.io/badge/tanglePHP-grey?style=flat-square&logo=tanglePHP" alt="Shimmer"></a>
<a href="https://www.iota.org/" style="text-decoration:none;"><img src="https://img.shields.io/badge/IOTA-grey?style=flat-square&logo=iota" alt="IOTA"></a>
<a href="https://www.shimmer.network/" style="text-decoration:none;"><img src="https://img.shields.io/badge/Shimmer-grey?style=flat-square&logo=shimmer" alt="Shimmer"></a> ‖
<a href="https://www.php.net/" style="text-decoration:none;"><img src="https://img.shields.io/badge/PHP->= 8.1.x-blue?style=flat-square&logo=php" alt=">PHP 8"></a>
<a href="https://github.com/iota-community/iota.php/LICENSE" style="text-decoration:none;"><img src="https://img.shields.io/badge/license-Apache--2.0-green?style=flat-square" alt="Apache-2.0 license"></a>

---

## Wallet - useWallet

tanglePHP's wallet library offers the easiest way to manage your seed/mnemonic. In order to use this, a SeedInput is required and the network.
After that, the addresses can be opened and queried in a simple way.
For more information on how addresses work, please open this [chapter](./002_basic_crypto_address.md)

---

## Use in tanglePHP

#### Support: Shimmer (v2) & IOTA (v1)

```PHP
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");
  
  // Open wallet
  $wallet    = new \tanglePHP\Wallet\Run($mnemonic, 'shimmer:testnet');
  
  // create address (0/0)
  $address_0 = $wallet->address();
  // create address (0/1)
  $address_1 = $wallet->address(0, 1);
```

---

## Output initial information

```PHP
  # output
  echo "CoinType: " . $wallet->getCoinType() . PHP_EOL;
  echo "WalletSeed: " . $wallet->getSeed() . PHP_EOL;
  echo "WalletMnemonic: " . $mnemonic . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;
  echo "Address 0" . PHP_EOL;
  echo "AddressPath: " . $address_0->getPathString() . PHP_EOL;
  echo "Address: 0x" . $address_0->getAddress() . PHP_EOL;
  echo "AddressBech32: " . $address_0->getAddressBech32() . PHP_EOL;
  echo "Balance: " . $address_0->getBalance()->balance . PHP_EOL;
  echo "Balance MarketData: " . $address_0->getBalance()->marketData_balance . PHP_EOL;
  echo "Balance Spendable: " . $address_0->getBalanceSpendable()->balance . PHP_EOL;
  echo PHP_EOL;
  echo "###################################################################################" . PHP_EOL;
  echo "Address 1" . PHP_EOL;
  $address_1_fullInfo = $address_1->getFullInfo();
  print_r($address_1_fullInfo);
  echo "###################################################################################" . PHP_EOL;

  
  /* Output example
    CoinType: 4219
    WalletSeed: a7263c9c84ae6aa9c88ae84bfd224aab87f187b57404d462ab6764c52303bb9ae51f54acc5473b1c366dc8559c04d49d6533edf19110918f9e2474443acd33f3
    WalletMnemonic: giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally
    ###################################################################################
    Address 0
    AddressPath: m/44'/4219'/0'/0'/0'
    Address: 0xd4686d71647240aa5d3bdcd54007319e987f29d991c4f970b8b2210e8086162c
    AddressBech32: rms1qr2xsmt3v3eyp2ja80wd2sq8xx0fslefmxguf7tshzezzr5qsctzc2f5dg6
    Balance: 2179750200
    Balance MarketData: {"last_updated_at":1666075989,"balance":2179750200,"balanceCalc":2179.7502,"coin":"shimmer","price":{"usd":0.080951,"eur":0.08203,"last_updated_at":1666075989},"calc":{"usd":176.45295844019998,"eur":178.804908906}}
    Balance Spendable: 2179699600
    
    ###################################################################################
    Address 1
    tanglePHP\SingleNodeClient\Models\ReturnAddressBalance Object
    (
        [_input:protected] => tanglePHP\Core\Helper\JSON Object
            (
                [array] => Array
                    (
                        [path] => m/44'/4219'/0'/0'/1'
                        [addressEd25519] => 5b039e78c28eb3e010ebb5993e210efc5c5a1767950991a873ce0ce6eb17a46c
                        [addressBech32] => rms1qpds88ncc28t8cqsaw6ej03ppm79ckshv72snydgw08qeehtz7jxcz6pw2d
                        [balance] => 3002805900
                        [nativeTokens] => Array
                            (
                                [0] => Array
                                    (
                                        [0] => Array
                                            (
                                                [id] => 0x0825e69a473a0062de58a0678097b3a26ddaf441fd373910cc44f1aee90dbd13c90100000000
                                                [amount] => 0x3e8
                                            )
    
                                    )
    
                                [1] => Array
                                    (
                                        [0] => Array
                                            (
                                                [id] => 0x0897baa705a215df2788032abf334c834995716e5c188ff281f70fc4dcb48f4a5c0100000000
                                                [amount] => 0x3e8
                                            )
    
                                    )
    
                                [2] => Array
                                    (
                                        [0] => Array
                                            (
                                                [id] => 0x08928d2b0e181ccf1b435b1f2f1247356fb30646da95e8d48ee472d469d9a76d210100000000
                                                [amount] => 0x3e8
                                            )
    
                                    )
    
                            )
    
                        [marketData] => Array
                            (
                                [shimmer] => Array
                                    (
                                        [usd] => 0.080951
                                        [eur] => 0.08203
                                        [last_updated_at] => 1666075989
                                    )
    
                            )
    
                        [marketData_balance] => Array
                            (
                                [last_updated_at] => 1666075989
                                [balance] => 3002805900
                                [balanceCalc] => 3002.8059
                                [coin] => shimmer
                                [price] => Array
                                    (
                                        [usd] => 0.080951
                                        [eur] => 0.08203
                                        [last_updated_at] => 1666075989
                                    )
    
                                [calc] => Array
                                    (
                                        [usd] => 243.0801404109
                                        [eur] => 246.320167977
                                    )
    
                            )
    
                        [ledgerIndex] => 1588137
                    )
    
                [string:protected] => {"path":"m\/44'\/4219'\/0'\/0'\/1'","addressEd25519":"5b039e78c28eb3e010ebb5993e210efc5c5a1767950991a873ce0ce6eb17a46c","addressBech32":"rms1qpds88ncc28t8cqsaw6ej03ppm79ckshv72snydgw08qeehtz7jxcz6pw2d","balance":"3002805900","nativeTokens":{"0":{"0":{"id":"0x0825e69a473a0062de58a0678097b3a26ddaf441fd373910cc44f1aee90dbd13c90100000000","amount":"0x3e8"}},"1":{"0":{"id":"0x0897baa705a215df2788032abf334c834995716e5c188ff281f70fc4dcb48f4a5c0100000000","amount":"0x3e8"}},"2":{"0":{"id":"0x08928d2b0e181ccf1b435b1f2f1247356fb30646da95e8d48ee472d469d9a76d210100000000","amount":"0x3e8"}}},"marketData":{"shimmer":{"usd":0.080951,"eur":0.08203,"last_updated_at":1666075989}},"marketData_balance":{"last_updated_at":1666075989,"balance":3002805900,"balanceCalc":3002.8059,"coin":"shimmer","price":{"usd":0.080951,"eur":0.08203,"last_updated_at":1666075989},"calc":{"usd":243.0801404109,"eur":246.320167977}},"ledgerIndex":1588137}
            )
    
        [balance] => 3002805900
        [addressBech32] => rms1qpds88ncc28t8cqsaw6ej03ppm79ckshv72snydgw08qeehtz7jxcz6pw2d
        [nativeTokens] => tanglePHP\Core\Models\ResponseArray Object
            (
                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                    (
                        [array] => Array
                            (
                                [0] => Array
                                    (
                                        [0] => Array
                                            (
                                                [id] => 0x0825e69a473a0062de58a0678097b3a26ddaf441fd373910cc44f1aee90dbd13c90100000000
                                                [amount] => 0x3e8
                                            )
    
                                    )
    
                                [1] => Array
                                    (
                                        [0] => Array
                                            (
                                                [id] => 0x0897baa705a215df2788032abf334c834995716e5c188ff281f70fc4dcb48f4a5c0100000000
                                                [amount] => 0x3e8
                                            )
    
                                    )
    
                                [2] => Array
                                    (
                                        [0] => Array
                                            (
                                                [id] => 0x08928d2b0e181ccf1b435b1f2f1247356fb30646da95e8d48ee472d469d9a76d210100000000
                                                [amount] => 0x3e8
                                            )
    
                                    )
    
                            )
    
                        [string:protected] => [[{"id":"0x0825e69a473a0062de58a0678097b3a26ddaf441fd373910cc44f1aee90dbd13c90100000000","amount":"0x3e8"}],[{"id":"0x0897baa705a215df2788032abf334c834995716e5c188ff281f70fc4dcb48f4a5c0100000000","amount":"0x3e8"}],[{"id":"0x08928d2b0e181ccf1b435b1f2f1247356fb30646da95e8d48ee472d469d9a76d210100000000","amount":"0x3e8"}]]
                    )
    
                [0] => tanglePHP\Core\Models\ResponseArray Object
                    (
                        [_input:protected] => tanglePHP\Core\Helper\JSON Object
                            (
                                [array] => Array
                                    (
                                        [0] => Array
                                            (
                                                [id] => 0x0825e69a473a0062de58a0678097b3a26ddaf441fd373910cc44f1aee90dbd13c90100000000
                                                [amount] => 0x3e8
                                            )
    
                                    )
    
                                [string:protected] => [{"id":"0x0825e69a473a0062de58a0678097b3a26ddaf441fd373910cc44f1aee90dbd13c90100000000","amount":"0x3e8"}]
                            )
    
                        [0] => tanglePHP\Core\Models\ResponseArray Object
                            (
                                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                    (
                                        [array] => Array
                                            (
                                                [id] => 0x0825e69a473a0062de58a0678097b3a26ddaf441fd373910cc44f1aee90dbd13c90100000000
                                                [amount] => 0x3e8
                                            )
    
                                        [string:protected] => {"id":"0x0825e69a473a0062de58a0678097b3a26ddaf441fd373910cc44f1aee90dbd13c90100000000","amount":"0x3e8"}
                                    )
    
                                [id] => 0x0825e69a473a0062de58a0678097b3a26ddaf441fd373910cc44f1aee90dbd13c90100000000
                                [amount] => 0x3e8
                            )
    
                    )
    
                [1] => tanglePHP\Core\Models\ResponseArray Object
                    (
                        [_input:protected] => tanglePHP\Core\Helper\JSON Object
                            (
                                [array] => Array
                                    (
                                        [0] => Array
                                            (
                                                [id] => 0x0897baa705a215df2788032abf334c834995716e5c188ff281f70fc4dcb48f4a5c0100000000
                                                [amount] => 0x3e8
                                            )
    
                                    )
    
                                [string:protected] => [{"id":"0x0897baa705a215df2788032abf334c834995716e5c188ff281f70fc4dcb48f4a5c0100000000","amount":"0x3e8"}]
                            )
    
                        [0] => tanglePHP\Core\Models\ResponseArray Object
                            (
                                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                    (
                                        [array] => Array
                                            (
                                                [id] => 0x0897baa705a215df2788032abf334c834995716e5c188ff281f70fc4dcb48f4a5c0100000000
                                                [amount] => 0x3e8
                                            )
    
                                        [string:protected] => {"id":"0x0897baa705a215df2788032abf334c834995716e5c188ff281f70fc4dcb48f4a5c0100000000","amount":"0x3e8"}
                                    )
    
                                [id] => 0x0897baa705a215df2788032abf334c834995716e5c188ff281f70fc4dcb48f4a5c0100000000
                                [amount] => 0x3e8
                            )
    
                    )
    
                [2] => tanglePHP\Core\Models\ResponseArray Object
                    (
                        [_input:protected] => tanglePHP\Core\Helper\JSON Object
                            (
                                [array] => Array
                                    (
                                        [0] => Array
                                            (
                                                [id] => 0x08928d2b0e181ccf1b435b1f2f1247356fb30646da95e8d48ee472d469d9a76d210100000000
                                                [amount] => 0x3e8
                                            )
    
                                    )
    
                                [string:protected] => [{"id":"0x08928d2b0e181ccf1b435b1f2f1247356fb30646da95e8d48ee472d469d9a76d210100000000","amount":"0x3e8"}]
                            )
    
                        [0] => tanglePHP\Core\Models\ResponseArray Object
                            (
                                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                    (
                                        [array] => Array
                                            (
                                                [id] => 0x08928d2b0e181ccf1b435b1f2f1247356fb30646da95e8d48ee472d469d9a76d210100000000
                                                [amount] => 0x3e8
                                            )
    
                                        [string:protected] => {"id":"0x08928d2b0e181ccf1b435b1f2f1247356fb30646da95e8d48ee472d469d9a76d210100000000","amount":"0x3e8"}
                                    )
    
                                [id] => 0x08928d2b0e181ccf1b435b1f2f1247356fb30646da95e8d48ee472d469d9a76d210100000000
                                [amount] => 0x3e8
                            )
    
                    )
    
            )
    
        [ledgerIndex] => 1588137
        [networkInfo] => tanglePHP\Core\Models\ResponseArray Object
            (
                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                    (
                        [array] => Array
                            (
                                [network] => shimmer
                                [networkName] => testnet
                                [networkId] => 8342982141227064571
                                [protocolVersion] => 2
                                [singleNodeName] => HORNET
                                [singleNodeVersion] => 2.0.0-rc.2
                                [singleNodeHealthy] => 1
                                [features] => Array
                                    (
                                        [0] => pow
                                    )
    
                                [baseToken] => SMR
                                [coinType] => 4219
                                [bech32Hrp] => rms
                            )
    
                        [string:protected] => {"network":"shimmer","networkName":"testnet","networkId":"8342982141227064571","protocolVersion":2,"singleNodeName":"HORNET","singleNodeVersion":"2.0.0-rc.2","singleNodeHealthy":true,"features":["pow"],"baseToken":"SMR","coinType":4219,"bech32Hrp":"rms"}
                    )
    
                [network] => shimmer
                [networkName] => testnet
                [networkId] => 8342982141227064571
                [protocolVersion] => 2
                [singleNodeName] => HORNET
                [singleNodeVersion] => 2.0.0-rc.2
                [singleNodeHealthy] => 1
                [features] => tanglePHP\Core\Models\ResponseArray Object
                    (
                        [_input:protected] => tanglePHP\Core\Helper\JSON Object
                            (
                                [array] => Array
                                    (
                                        [0] => pow
                                    )
    
                                [string:protected] => ["pow"]
                            )
    
                        [0] => pow
                    )
    
                [baseToken] => SMR
                [coinType] => 4219
                [bech32Hrp] => rms
            )
    
        [marketData] => tanglePHP\Core\Models\ResponseArray Object
            (
                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                    (
                        [array] => Array
                            (
                                [shimmer] => Array
                                    (
                                        [usd] => 0.080951
                                        [eur] => 0.08203
                                        [last_updated_at] => 1666075989
                                    )
    
                            )
    
                        [string:protected] => {"shimmer":{"usd":0.080951,"eur":0.08203,"last_updated_at":1666075989}}
                    )
    
                [shimmer] => tanglePHP\Core\Models\ResponseArray Object
                    (
                        [_input:protected] => tanglePHP\Core\Helper\JSON Object
                            (
                                [array] => Array
                                    (
                                        [usd] => 0.080951
                                        [eur] => 0.08203
                                        [last_updated_at] => 1666075989
                                    )
    
                                [string:protected] => {"usd":0.080951,"eur":0.08203,"last_updated_at":1666075989}
                            )
    
                        [usd] => 0.080951
                        [eur] => 0.08203
                        [last_updated_at] => 1666075989
                    )
    
            )
    
        [marketData_balance] => tanglePHP\Core\Models\ResponseArray Object
            (
                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                    (
                        [array] => Array
                            (
                                [last_updated_at] => 1666075989
                                [balance] => 3002805900
                                [balanceCalc] => 3002.8059
                                [coin] => shimmer
                                [price] => Array
                                    (
                                        [usd] => 0.080951
                                        [eur] => 0.08203
                                        [last_updated_at] => 1666075989
                                    )
    
                                [calc] => Array
                                    (
                                        [usd] => 243.0801404109
                                        [eur] => 246.320167977
                                    )
    
                            )
    
                        [string:protected] => {"last_updated_at":1666075989,"balance":3002805900,"balanceCalc":3002.8059,"coin":"shimmer","price":{"usd":0.080951,"eur":0.08203,"last_updated_at":1666075989},"calc":{"usd":243.0801404109,"eur":246.320167977}}
                    )
    
                [last_updated_at] => 1666075989
                [balance] => 3002805900
                [balanceCalc] => 3002.8059
                [coin] => shimmer
                [price] => tanglePHP\Core\Models\ResponseArray Object
                    (
                        [_input:protected] => tanglePHP\Core\Helper\JSON Object
                            (
                                [array] => Array
                                    (
                                        [usd] => 0.080951
                                        [eur] => 0.08203
                                        [last_updated_at] => 1666075989
                                    )
    
                                [string:protected] => {"usd":0.080951,"eur":0.08203,"last_updated_at":1666075989}
                            )
    
                        [usd] => 0.080951
                        [eur] => 0.08203
                        [last_updated_at] => 1666075989
                    )
    
                [calc] => tanglePHP\Core\Models\ResponseArray Object
                    (
                        [_input:protected] => tanglePHP\Core\Helper\JSON Object
                            (
                                [array] => Array
                                    (
                                        [usd] => 243.0801404109
                                        [eur] => 246.320167977
                                    )
    
                                [string:protected] => {"usd":243.0801404109,"eur":246.320167977}
                            )
    
                        [usd] => 243.0801404109
                        [eur] => 246.320167977
                    )
    
            )
    
        [path] => m/44'/4219'/0'/0'/1'
        [addressEd25519] => 5b039e78c28eb3e010ebb5993e210efc5c5a1767950991a873ce0ce6eb17a46c
    )
    ###################################################################################
  */
```

---


## Examples

+ [01_useWallet](https://github.com/tanglePHP/bundle/blob/main/examples/src/wallet/01_useWallet.php)

## PHPDoc

+ [Wallet-Run](https://tanglephp.com/phpdoc/classes/tanglePHP-Wallet-Run.html)
+ [Wallet-Type-Address](https://tanglephp.com/phpdoc/classes/tanglePHP-Wallet-Type-Address.html)

---

<- Back to [Overview](000_index.md)