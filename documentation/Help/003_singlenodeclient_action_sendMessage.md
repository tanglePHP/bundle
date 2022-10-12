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

There is a simple action "sendMessage" for sending messages, the "tag" (string) is specified as the first parameter, the 2nd parameter can be a string or an array.

Messages are not firmly anchored in the Tangle and can no longer be found over time. There is also a solution for this, see "sendTransaction".

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
  // send message
  echo $ret = (new sendMessage($network->singleNode))->message('#tanglePHP', 'tanglePHP sendMessage test! follow me on Twitter @tanglePHP')
                                                     ->setting('checkTransaction', false)
                                                     ->run();
```

> If checkTransaction is set to true, a query is started in the background until the tangle has validated it.


Alternatively, an array can also be transferred instead of the message string, and a JSON string is then generated in the background. The "Data" message is then anchored as JSON.

```PHP
 // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\getBalance;

  // create network connection
  $network = new Connect('shimmer:testnet');
  // send message
  echo $ret = (new sendMessage($network->singleNode))->message('#tanglePHP', ['key1' => 'msg1', 'key2' => 'msg2'])
                                                     ->run();
```

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
  echo $ret->networkInfo;
  
  /* Output example
    {"blockId":"0x8b0e096180555375c2a29daf486cd5740830a3421be4bd8b7fa99219e9971dfa","check":null,"explorerUrl":"https:\/\/explorer.shimmer.network\/testnet\/block\/0x8b0e096180555375c2a29daf486cd5740830a3421be4bd8b7fa99219e9971dfa","networkInfo":{"network":"shimmer","networkName":"testnet","networkId":"8342982141227064571","protocolVersion":2,"singleNodeName":"HORNET","singleNodeVersion":"2.0.0-beta.10","singleNodeHealthy":true,"features":["pow"],"baseToken":"SMR","coinType":4219,"bech32Hrp":"rms"}}
    https://explorer.shimmer.network/testnet/block/0x8b0e096180555375c2a29daf486cd5740830a3421be4bd8b7fa99219e9971dfa
    0x8b0e096180555375c2a29daf486cd5740830a3421be4bd8b7fa99219e9971dfa
    
    {"network":"shimmer","networkName":"testnet","networkId":"8342982141227064571","protocolVersion":2,"singleNodeName":"HORNET","singleNodeVersion":"2.0.0-beta.10","singleNodeHealthy":true,"features":["pow"],"baseToken":"SMR","coinType":4219,"bech32Hrp":"rms"}
  */
```

---

## Examples

+ [03_sendMessage](https://github.com/tanglePHP/bundle/blob/main/examples/src/singlenode-client/Action/03_sendMessage.php)

---

<- Back to [Overview](000_index.md)