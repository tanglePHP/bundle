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

## SingleNodeClient - sendTransaction

Sending tokens (IOTA/Shimmer) is done with the "sendTransaction" action. For this, the amount, the address to whom it is to be sent is required. Alternatively, the accountIndex & addressIndex (please have a look at "[Crypto Address](002_basic_crypto_address.md)" for more information), a message and settings can be specified.

---

## Use in tanglePHP

#### Support: Shimmer (v2) & IOTA (v1)


```PHP
 // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\sendTransaction;

  // create network connection
  $network = new Connect('shimmer:testnet');
  // send transaction
  echo $ret = (new sendTransaction($network->singleNode))->amount(1000000)
                                                         ->seedInput("MNEMONIC,Seed,...")
                                                         //->accountIndex(0)
                                                         //->addressIndex(0)
                                                         ->toAddress('ba4ca851e2674f87bd795f0f398e2e8886f5bfa62c5b97007bbe4504683a66a1')
                                                         //->message("#tanglePHP", "transaction test! follow me on Twitter @tanglePHP")
                                                         ->message("#tanglePHP", [
                                                           'key1' => "transaction test!",
                                                           'key2' => "follow me on Twitter @tanglePHP",
                                                         ])
                                                         //->setting(['checkTransaction' => true])
                                                         ->run();
```

> In Protocoll v2 there is a StorageDeposit, this is a minimum amount which anchors the message in the tangle. If the Amount is lower than the StorageDeposit, an error message is displayed.


---

### Output initial information
Below is an example of the return:

```PHP
  # output
      // print single information
      echo PHP_EOL;
      echo $ret->explorerUrl . PHP_EOL;
      echo $ret->blockId . PHP_EOL;
      echo $ret->check . PHP_EOL;
      // print network informations
      echo $ret->networkInfo . PHP_EOL;
      // print market informations
      echo $ret->marketData . PHP_EOL;
      echo $ret->marketData_balance . PHP_EOL;
  
  /* Output example
    {"blockId":"0xec25205032ebbb8ac1a0b27a012a0601c238e6c0d7134ad8077b5694bbcbb646","check":"included","explorerUrl":"https:\/\/explorer.shimmer.network\/testnet\/block\/0xec25205032ebbb8ac1a0b27a012a0601c238e6c0d7134ad8077b5694bbcbb646","marketData":{"shimmer":{"usd":0.08468,"eur":0.087197,"last_updated_at":1665562307}},"networkInfo":{"network":"shimmer","networkName":"testnet","networkId":"8342982141227064571","protocolVersion":2,"singleNodeName":"HORNET","singleNodeVersion":"2.0.0-beta.10","singleNodeHealthy":true,"features":["pow"],"baseToken":"SMR","coinType":4219,"bech32Hrp":"rms"},"marketData_balance":{"last_updated_at":1665562307,"balance":1000000,"balanceCalc":1,"coin":"shimmer","price":{"usd":0.08468,"eur":0.087197,"last_updated_at":1665562307},"calc":{"usd":0.08468,"eur":0.087197}}}
    https://explorer.shimmer.network/testnet/block/0xec25205032ebbb8ac1a0b27a012a0601c238e6c0d7134ad8077b5694bbcbb646
    0xec25205032ebbb8ac1a0b27a012a0601c238e6c0d7134ad8077b5694bbcbb646
    included
    {"network":"shimmer","networkName":"testnet","networkId":"8342982141227064571","protocolVersion":2,"singleNodeName":"HORNET","singleNodeVersion":"2.0.0-beta.10","singleNodeHealthy":true,"features":["pow"],"baseToken":"SMR","coinType":4219,"bech32Hrp":"rms"}
    {"shimmer":{"usd":0.08468,"eur":0.087197,"last_updated_at":1665562307}}
    {"last_updated_at":1665562307,"balance":1000000,"balanceCalc":1,"coin":"shimmer","price":{"usd":0.08468,"eur":0.087197,"last_updated_at":1665562307},"calc":{"usd":0.08468,"eur":0.087197}}
  */
```

---

## Examples

+ [08_sendTransaction](https://github.com/tanglePHP/bundle/blob/main/examples/src/singlenode-client/Action/08_sendTransaction.php)

---

<- Back to [Overview](000_index.md)