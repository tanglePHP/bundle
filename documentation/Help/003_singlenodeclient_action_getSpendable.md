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

## SingleNodeClient - getSpendable

In most projects, Firefly sends a transaction to an address. To check these transactions and determine the sender, there is the action "getSpendable".

---

## Use in tanglePHP

#### Support: Shimmer (v2) & IOTA (v1)

```PHP
 // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\getSpendable;

  // create network connection
  $network = new Connect('shimmer:testnet');
  // send transaction
  $ret = (new getSpendable($network->singleNode))->address('rms1qpqjkprc4c8ft2nrtaz7xktgsn3xwzcvn9q2mn7d59ykgmmycf7fwnn25nz')
                                                 ->run();
```

---

### Output initial information

Below is an example of the return:

```PHP
  # output
  // print single information
  print_r($ret);
  
  /* Output example
    Array
    (
        [0] => tanglePHP\SingleNodeClient\Models\ReturnAddressInfo Object
            (
                [_input:protected] => tanglePHP\Core\Helper\JSON Object
                    (
                        [array] => Array
                            (
                                [addressFrom] => rms1qrl3rcymcz0tc8exktv95fyx760yrmgpwgt3wxh2j9uf06ml6th0urcdcag
                                [addressTo] => rms1qrl3rcymcz0tc8exktv95fyx760yrmgpwgt3wxh2j9uf06ml6th0urcdcag
                                [amount] => 999000000
                                [milestoneIndexBooked] => 1485414
                                [milestoneTimestampBooked] => 1665562415
                                [datetime] => 2022-10-12 10:13:35
                                [outputId] => 0x3609554573647bd59bc86f2bdff68b16ae56630c63cbdfa4693c63bb7abef38f0100
                                [blockId] => 0xec25205032ebbb8ac1a0b27a012a0601c238e6c0d7134ad8077b5694bbcbb646
                                [transactionId] => 0x3609554573647bd59bc86f2bdff68b16ae56630c63cbdfa4693c63bb7abef38f
                                [explorerUrl] => https://explorer.shimmer.network/testnet/block/0xec25205032ebbb8ac1a0b27a012a0601c238e6c0d7134ad8077b5694bbcbb646
                            )
    
                        [string:protected] => {"addressFrom":"rms1qrl3rcymcz0tc8exktv95fyx760yrmgpwgt3wxh2j9uf06ml6th0urcdcag","addressTo":"rms1qrl3rcymcz0tc8exktv95fyx760yrmgpwgt3wxh2j9uf06ml6th0urcdcag","amount":999000000,"milestoneIndexBooked":1485414,"milestoneTimestampBooked":1665562415,"datetime":"2022-10-12 10:13:35","outputId":"0x3609554573647bd59bc86f2bdff68b16ae56630c63cbdfa4693c63bb7abef38f0100","blockId":"0xec25205032ebbb8ac1a0b27a012a0601c238e6c0d7134ad8077b5694bbcbb646","transactionId":"0x3609554573647bd59bc86f2bdff68b16ae56630c63cbdfa4693c63bb7abef38f","explorerUrl":"https:\/\/explorer.shimmer.network\/testnet\/block\/0xec25205032ebbb8ac1a0b27a012a0601c238e6c0d7134ad8077b5694bbcbb646"}
                    )
    
                [addressFrom] => rms1qrl3rcymcz0tc8exktv95fyx760yrmgpwgt3wxh2j9uf06ml6th0urcdcag
                [addressTo] => rms1qrl3rcymcz0tc8exktv95fyx760yrmgpwgt3wxh2j9uf06ml6th0urcdcag
                [amount] => 999000000
                [milestoneIndexBooked] => 1485414
                [milestoneTimestampBooked] => 1665562415
                [datetime] => 2022-10-12 10:13:35
                [blockId] => 0xec25205032ebbb8ac1a0b27a012a0601c238e6c0d7134ad8077b5694bbcbb646
                [transactionId] => 0x3609554573647bd59bc86f2bdff68b16ae56630c63cbdfa4693c63bb7abef38f
                [explorerUrl] => https://explorer.shimmer.network/testnet/block/0xec25205032ebbb8ac1a0b27a012a0601c238e6c0d7134ad8077b5694bbcbb646
                [outputId] => 0x3609554573647bd59bc86f2bdff68b16ae56630c63cbdfa4693c63bb7abef38f0100
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
                                        [singleNodeVersion] => 2.0.0-beta.10
                                        [singleNodeHealthy] => 1
                                        [features] => Array
                                            (
                                                [0] => pow
                                            )
    
                                        [baseToken] => SMR
                                        [coinType] => 4219
                                        [bech32Hrp] => rms
                                    )
    
                                [string:protected] => {"network":"shimmer","networkName":"testnet","networkId":"8342982141227064571","protocolVersion":2,"singleNodeName":"HORNET","singleNodeVersion":"2.0.0-beta.10","singleNodeHealthy":true,"features":["pow"],"baseToken":"SMR","coinType":4219,"bech32Hrp":"rms"}
                            )
    
                        [network] => shimmer
                        [networkName] => testnet
                        [networkId] => 8342982141227064571
                        [protocolVersion] => 2
                        [singleNodeName] => HORNET
                        [singleNodeVersion] => 2.0.0-beta.10
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
    
            )
    
    )
  */
```

---

## Examples

+ [02_getSpendable](https://github.com/tanglePHP/bundle/blob/main/examples/src/singlenode-client/Action/02_getSpendable.php)


## PHPDoc

+ [getSpendable](https://tanglephp.com/phpdoc/classes/tanglePHP-SingleNodeClient-Action-getSpendable.html)

---

<- Back to [Overview](000_index.md)