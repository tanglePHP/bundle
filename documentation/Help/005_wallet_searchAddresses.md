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

## Wallet - searchAddresses

Addresses can be searched for within the wallet. To do this, the wallet must be opened, then "searchAddresses" can be used to search for addresses that have a balance of more than 0, for example.

The first parameter specifies how many AccountIndexes are to be checked. This parameter would be the "Wallets" in Firefly.

The second parameter specifies how many addresses are to be searched for/checked (AddressIndex). In Firefly, this parameter would be the individual/newly generated addresses within a "wallet".

The third parameter specifies whether addresses with zero balance should be output or not.

---

## Use in tanglePHP

#### Support: Shimmer (v2) & IOTA (v1)

```PHP
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");
  
  // Open wallet
  $wallet    = new \tanglePHP\Wallet\Run($mnemonic, 'shimmer:testnet');
  
  // search Addresses
  $found = $wallet->searchAddresses(1,1, false);
```

---

## Output initial information

```PHP
  # output
  print_r($found);

  
  /* Output example
    Array
    (
        [0] => tanglePHP\SingleNodeClient\Models\ReturnAddressBalance Object
            (
                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                    (
                        [array] => Array
                            (
                                [path] => m/44'/4219'/0'/0'/0'
                                [addressEd25519] => d4686d71647240aa5d3bdcd54007319e987f29d991c4f970b8b2210e8086162c
                                [addressBech32] => rms1qr2xsmt3v3eyp2ja80wd2sq8xx0fslefmxguf7tshzezzr5qsctzc2f5dg6
                                [balance] => 2179750200
                                [nativeTokens] => Array
                                    (
                                        [0] => Array
                                            (
                                                [0] => Array
                                                    (
                                                        [id] => 0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80200000000
                                                        [amount] => 0xa870b
                                                    )
    
                                                [1] => Array
                                                    (
                                                        [id] => 0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80400000000
                                                        [amount] => 0x186a0
                                                    )
    
                                            )
    
                                        [1] => Array
                                            (
                                                [0] => Array
                                                    (
                                                        [id] => 0x086f029f830c5f0664a67c0237c821aa27c59cca0ec0d9bfb453b1f6f4fff83c8c0100000000
                                                        [amount] => 0x3e8
                                                    )
    
                                            )
    
                                        [2] => Array
                                            (
                                                [0] => Array
                                                    (
                                                        [id] => 0x08638bd0379861ef36be006efb000a5db6b5374b6401b6caebc65dff4b623db9970100000000
                                                        [amount] => 0x3e8
                                                    )
    
                                            )
    
                                    )
    
                                [marketData] => Array
                                    (
                                        [shimmer] => Array
                                            (
                                                [usd] => 0.080905
                                                [eur] => 0.082024
                                                [last_updated_at] => 1666076744
                                            )
    
                                    )
    
                                [marketData_balance] => Array
                                    (
                                        [last_updated_at] => 1666076744
                                        [balance] => 2179750200
                                        [balanceCalc] => 2179.7502
                                        [coin] => shimmer
                                        [price] => Array
                                            (
                                                [usd] => 0.080905
                                                [eur] => 0.082024
                                                [last_updated_at] => 1666076744
                                            )
    
                                        [calc] => Array
                                            (
                                                [usd] => 176.352689931
                                                [eur] => 178.7918304048
                                            )
    
                                    )
    
                                [ledgerIndex] => 1588297
                            )
    
                        [string:protected] => {"path":"m\/44'\/4219'\/0'\/0'\/0'","addressEd25519":"d4686d71647240aa5d3bdcd54007319e987f29d991c4f970b8b2210e8086162c","addressBech32":"rms1qr2xsmt3v3eyp2ja80wd2sq8xx0fslefmxguf7tshzezzr5qsctzc2f5dg6","balance":"2179750200","nativeTokens":{"0":{"0":{"id":"0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80200000000","amount":"0xa870b"},"1":{"id":"0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80400000000","amount":"0x186a0"}},"1":{"0":{"id":"0x086f029f830c5f0664a67c0237c821aa27c59cca0ec0d9bfb453b1f6f4fff83c8c0100000000","amount":"0x3e8"}},"2":{"0":{"id":"0x08638bd0379861ef36be006efb000a5db6b5374b6401b6caebc65dff4b623db9970100000000","amount":"0x3e8"}}},"marketData":{"shimmer":{"usd":0.080905,"eur":0.082024,"last_updated_at":1666076744}},"marketData_balance":{"last_updated_at":1666076744,"balance":2179750200,"balanceCalc":2179.7502,"coin":"shimmer","price":{"usd":0.080905,"eur":0.082024,"last_updated_at":1666076744},"calc":{"usd":176.35268993100001,"eur":178.79183040479998}},"ledgerIndex":1588297}
                    )
    
                [balance] => 2179750200
                [addressBech32] => rms1qr2xsmt3v3eyp2ja80wd2sq8xx0fslefmxguf7tshzezzr5qsctzc2f5dg6
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
                                                        [id] => 0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80200000000
                                                        [amount] => 0xa870b
                                                    )
    
                                                [1] => Array
                                                    (
                                                        [id] => 0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80400000000
                                                        [amount] => 0x186a0
                                                    )
    
                                            )
    
                                        [1] => Array
                                            (
                                                [0] => Array
                                                    (
                                                        [id] => 0x086f029f830c5f0664a67c0237c821aa27c59cca0ec0d9bfb453b1f6f4fff83c8c0100000000
                                                        [amount] => 0x3e8
                                                    )
    
                                            )
    
                                        [2] => Array
                                            (
                                                [0] => Array
                                                    (
                                                        [id] => 0x08638bd0379861ef36be006efb000a5db6b5374b6401b6caebc65dff4b623db9970100000000
                                                        [amount] => 0x3e8
                                                    )
    
                                            )
    
                                    )
    
                                [string:protected] => [[{"id":"0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80200000000","amount":"0xa870b"},{"id":"0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80400000000","amount":"0x186a0"}],[{"id":"0x086f029f830c5f0664a67c0237c821aa27c59cca0ec0d9bfb453b1f6f4fff83c8c0100000000","amount":"0x3e8"}],[{"id":"0x08638bd0379861ef36be006efb000a5db6b5374b6401b6caebc65dff4b623db9970100000000","amount":"0x3e8"}]]
                            )
    
                        [0] => tanglePHP\Core\Models\ResponseArray Object
                            (
                                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                    (
                                        [array] => Array
                                            (
                                                [0] => Array
                                                    (
                                                        [id] => 0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80200000000
                                                        [amount] => 0xa870b
                                                    )
    
                                                [1] => Array
                                                    (
                                                        [id] => 0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80400000000
                                                        [amount] => 0x186a0
                                                    )
    
                                            )
    
                                        [string:protected] => [{"id":"0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80200000000","amount":"0xa870b"},{"id":"0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80400000000","amount":"0x186a0"}]
                                    )
    
                                [0] => tanglePHP\Core\Models\ResponseArray Object
                                    (
                                        [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                            (
                                                [array] => Array
                                                    (
                                                        [id] => 0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80200000000
                                                        [amount] => 0xa870b
                                                    )
    
                                                [string:protected] => {"id":"0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80200000000","amount":"0xa870b"}
                                            )
    
                                        [id] => 0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80200000000
                                        [amount] => 0xa870b
                                    )
    
                                [1] => tanglePHP\Core\Models\ResponseArray Object
                                    (
                                        [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                            (
                                                [array] => Array
                                                    (
                                                        [id] => 0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80400000000
                                                        [amount] => 0x186a0
                                                    )
    
                                                [string:protected] => {"id":"0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80400000000","amount":"0x186a0"}
                                            )
    
                                        [id] => 0x089a72eae14acca5f2ab1238b2ef3158a9168787228db96cef745191e8de56a3a80400000000
                                        [amount] => 0x186a0
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
                                                        [id] => 0x086f029f830c5f0664a67c0237c821aa27c59cca0ec0d9bfb453b1f6f4fff83c8c0100000000
                                                        [amount] => 0x3e8
                                                    )
    
                                            )
    
                                        [string:protected] => [{"id":"0x086f029f830c5f0664a67c0237c821aa27c59cca0ec0d9bfb453b1f6f4fff83c8c0100000000","amount":"0x3e8"}]
                                    )
    
                                [0] => tanglePHP\Core\Models\ResponseArray Object
                                    (
                                        [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                            (
                                                [array] => Array
                                                    (
                                                        [id] => 0x086f029f830c5f0664a67c0237c821aa27c59cca0ec0d9bfb453b1f6f4fff83c8c0100000000
                                                        [amount] => 0x3e8
                                                    )
    
                                                [string:protected] => {"id":"0x086f029f830c5f0664a67c0237c821aa27c59cca0ec0d9bfb453b1f6f4fff83c8c0100000000","amount":"0x3e8"}
                                            )
    
                                        [id] => 0x086f029f830c5f0664a67c0237c821aa27c59cca0ec0d9bfb453b1f6f4fff83c8c0100000000
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
                                                        [id] => 0x08638bd0379861ef36be006efb000a5db6b5374b6401b6caebc65dff4b623db9970100000000
                                                        [amount] => 0x3e8
                                                    )
    
                                            )
    
                                        [string:protected] => [{"id":"0x08638bd0379861ef36be006efb000a5db6b5374b6401b6caebc65dff4b623db9970100000000","amount":"0x3e8"}]
                                    )
    
                                [0] => tanglePHP\Core\Models\ResponseArray Object
                                    (
                                        [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                            (
                                                [array] => Array
                                                    (
                                                        [id] => 0x08638bd0379861ef36be006efb000a5db6b5374b6401b6caebc65dff4b623db9970100000000
                                                        [amount] => 0x3e8
                                                    )
    
                                                [string:protected] => {"id":"0x08638bd0379861ef36be006efb000a5db6b5374b6401b6caebc65dff4b623db9970100000000","amount":"0x3e8"}
                                            )
    
                                        [id] => 0x08638bd0379861ef36be006efb000a5db6b5374b6401b6caebc65dff4b623db9970100000000
                                        [amount] => 0x3e8
                                    )
    
                            )
    
                    )
    
                [ledgerIndex] => 1588297
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
                                                [usd] => 0.080905
                                                [eur] => 0.082024
                                                [last_updated_at] => 1666076744
                                            )
    
                                    )
    
                                [string:protected] => {"shimmer":{"usd":0.080905,"eur":0.082024,"last_updated_at":1666076744}}
                            )
    
                        [shimmer] => tanglePHP\Core\Models\ResponseArray Object
                            (
                                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                    (
                                        [array] => Array
                                            (
                                                [usd] => 0.080905
                                                [eur] => 0.082024
                                                [last_updated_at] => 1666076744
                                            )
    
                                        [string:protected] => {"usd":0.080905,"eur":0.082024,"last_updated_at":1666076744}
                                    )
    
                                [usd] => 0.080905
                                [eur] => 0.082024
                                [last_updated_at] => 1666076744
                            )
    
                    )
    
                [marketData_balance] => tanglePHP\Core\Models\ResponseArray Object
                    (
                        [_input:protected] => tanglePHP\Core\Helper\JSON Object
                            (
                                [array] => Array
                                    (
                                        [last_updated_at] => 1666076744
                                        [balance] => 2179750200
                                        [balanceCalc] => 2179.7502
                                        [coin] => shimmer
                                        [price] => Array
                                            (
                                                [usd] => 0.080905
                                                [eur] => 0.082024
                                                [last_updated_at] => 1666076744
                                            )
    
                                        [calc] => Array
                                            (
                                                [usd] => 176.352689931
                                                [eur] => 178.7918304048
                                            )
    
                                    )
    
                                [string:protected] => {"last_updated_at":1666076744,"balance":2179750200,"balanceCalc":2179.7502,"coin":"shimmer","price":{"usd":0.080905,"eur":0.082024,"last_updated_at":1666076744},"calc":{"usd":176.35268993100001,"eur":178.79183040479998}}
                            )
    
                        [last_updated_at] => 1666076744
                        [balance] => 2179750200
                        [balanceCalc] => 2179.7502
                        [coin] => shimmer
                        [price] => tanglePHP\Core\Models\ResponseArray Object
                            (
                                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                    (
                                        [array] => Array
                                            (
                                                [usd] => 0.080905
                                                [eur] => 0.082024
                                                [last_updated_at] => 1666076744
                                            )
    
                                        [string:protected] => {"usd":0.080905,"eur":0.082024,"last_updated_at":1666076744}
                                    )
    
                                [usd] => 0.080905
                                [eur] => 0.082024
                                [last_updated_at] => 1666076744
                            )
    
                        [calc] => tanglePHP\Core\Models\ResponseArray Object
                            (
                                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                    (
                                        [array] => Array
                                            (
                                                [usd] => 176.352689931
                                                [eur] => 178.7918304048
                                            )
    
                                        [string:protected] => {"usd":176.35268993100001,"eur":178.79183040479998}
                                    )
    
                                [usd] => 176.352689931
                                [eur] => 178.7918304048
                            )
    
                    )
    
                [path] => m/44'/4219'/0'/0'/0'
                [addressEd25519] => d4686d71647240aa5d3bdcd54007319e987f29d991c4f970b8b2210e8086162c
            )
    
    )
  */
```

---


## Examples

+ [02_WalletSearchAddresses](https://github.com/tanglePHP/bundle/blob/main/examples/src/wallet/02_WalletSearchAddresses.php)

## PHPDoc

+ [Wallet-Run](https://tanglephp.com/phpdoc/classes/tanglePHP-Wallet-Run.html)
+ [Wallet-Type-Address](https://tanglephp.com/phpdoc/classes/tanglePHP-Wallet-Type-Address.html)

---

<- Back to [Overview](000_index.md)