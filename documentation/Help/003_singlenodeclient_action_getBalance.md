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

## SingleNodeClient - getBalance

In tanglePHP there is an action getBalance() that is called to query the balance.
In protocol v1, a direct query is sent to the node in the background.
In Protocoll v2, a calculation is made in the background, which returns the balance.

The ReturnAddressBalance object is returned.

---

## Use in tanglePHP

#### Support: Shimmer (v2) & IOTA (v1)

```PHP
 // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\getBalance;

  // create network connection
  $network = new Connect('shimmer:testnet');

  // get balance with addressbech32
  echo $ret = (new getBalance($network->singleNode))->address('rms1qpqjkprc4c8ft2nrtaz7xktgsn3xwzcvn9q2mn7d59ykgmmycf7fwnn25nz')
                                                    ->run();
```


---

#### Support: Shimmer (v2) only

It is possible to select the query for which a filter is created

```PHP
  // These funds reside within outputs with additional unlock conditions which might be potentially un-lockable
  echo $ret = (new getBalance($network->singleNode))->address('rms1qpqjkprc4c8ft2nrtaz7xktgsn3xwzcvn9q2mn7d59ykgmmycf7fwnn25nz')
                                                    ->filter(['hasExpiration' => true])
                                                    ->run();
```

```PHP
  // Only spendable funds reside within outputs
  echo $ret = (new getBalance($network->singleNode))->address('rms1qpqjkprc4c8ft2nrtaz7xktgsn3xwzcvn9q2mn7d59ykgmmycf7fwnn25nz')
                                                    ->filter([
                                                      'hasStorageDepositReturn' => false,
                                                      'hasExpiration'           => false,
                                                      'hasTimelock'             => false,
                                                    ])
                                                    ->run();
```

---

### Output initial information
The following command can be run to get the information about the "belance" and "other" outputs:

```PHP
  # output
  // print single information
  echo PHP_EOL;
  echo $ret->balance . PHP_EOL;
  echo $ret->addressBech32 . PHP_EOL;
  echo $ret->nativeTokens . PHP_EOL;
  echo $ret->ledgerIndex . PHP_EOL;
  // print filter informations
  echo $ret->filter . PHP_EOL;
  // print network informations
  echo $ret->networkInfo . PHP_EOL;
  // print market informations
  echo $ret->marketData . PHP_EOL;
  echo $ret->marketData_balance . PHP_EOL;
  
  /* Output example
    2122451700
    rms1qpqjkprc4c8ft2nrtaz7xktgsn3xwzcvn9q2mn7d59ykgmmycf7fwnn25nz
    [[{"id":"0x085ff513fd0d09d124893f7d3213f111259f69a4caa4a66f654e6fd553e6f9087f0100000000","amount":"0x3e8"}],[{"id":"0x0899d847e5254d649032b671909fc325963d845c500644c57df88ff704413a88270100000000","amount":"0x3e8"}],[{"id":"0x08267ac3a226be7a55b0e5324f2481eb78a2fd3e57d10281d029e89586e768d13c0100000000","amount":"0x3e8"}],[{"id":"0x081d344f9447bba34740e2c7d04e7410ae527af1e8e279fe8b83fb8983a638765a0100000000","amount":"0x3e8"}],[{"id":"0x083c1806c71c7af7c3dacbbe37b8702ca04b7a87a991a6ad8ac93b6a8c11da6b880100000000","amount":"0x3e8"}],[{"id":"0x08dc2097c12e8db12919037a46acf13a911ccba1e09a702cbf7e7a8420074f8e6d0100000000","amount":"0x3e8"}],[{"id":"0x08db9fe3648e136f5d7539127ff9c2082139d8dd7b01094713a9035837536356180100000000","amount":"0x3e8"}],[{"id":"0x08fa5666c313f3f2f87135797c88d15040214ea03eedf7977c7002e0570c4a62680100000000","amount":"0x3e8"}],[{"id":"0x08a164187d0119aeb69d164e083a43c5d2092358da64a6bc7e9b583b243da5585e0100000000","amount":"0x3e8"}],[{"id":"0x0879714e7e90fa28c0c3bce91ce7e6cb757e5bf5a1566a701aaca3210200d17de60100000000","amount":"0x3e8"}]]
    1470798
    []
    {"network":"shimmer","networkName":"testnet","networkId":"8342982141227064571","protocolVersion":2,"singleNodeName":"HORNET","singleNodeVersion":"2.0.0-beta.10","singleNodeHealthy":true,"features":["pow"],"baseToken":"SMR","coinType":4219,"bech32Hrp":"rms"}
    {"shimmer":{"usd":0.087216,"eur":0.08957,"last_updated_at":1665488058}}
    {"last_updated_at":1665488058,"balance":2122451700,"balanceCalc":2122.4517,"coin":"shimmer","price":{"usd":0.087216,"eur":0.08957,"last_updated_at":1665488058},"calc":{"usd":185.11174746720002,"eur":190.107998769}}
  */
```

> The "ReturnAddressBalance" object contains the network information, the market data and the calculated market data calculated with the balance as further output options.

---

## Examples

+ [01_getAddressBalanceSpendable](https://github.com/tanglePHP/bundle/blob/main/examples/src/singlenode-client/Action/01_getAddressBalanceSpendable.php)
+ [01_getAddressBalanceConditionallyLocked](https://github.com/tanglePHP/bundle/blob/main/examples/src/singlenode-client/Action/01_getAddressBalanceConditionallyLocked.php)
+ [01_getAddressBalanceTotal](https://github.com/tanglePHP/bundle/blob/main/examples/src/singlenode-client/Action/01_getAddressBalanceTotal.php)
+ [01_getAddressBalanceIOTA](https://github.com/tanglePHP/bundle/blob/main/examples/src/singlenode-client/Action/01_getAddressBalanceIOTA.php)

---

<- Back to [Overview](000_index.md)