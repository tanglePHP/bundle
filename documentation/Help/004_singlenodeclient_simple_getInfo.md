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

## SingleNodeClient - getInfo

With getInfo it is possible to display the node information. Some relevant information is used in various actions for calculations.

---

## Use in tanglePHP

#### Support: Shimmer (v2) & IOTA (v1)


```PHP
 // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");

  use tanglePHP\Network\Connect;

  // create network connection
  $network = new Connect('shimmer:testnet');
  // get result of node routes
  $ret = $network->singleNode->info();
```

---

### Output initial information
Below is an example of the return:

```PHP
  # output
      // print result of node information
      echo PHP_EOL;
      echo $ret . PHP_EOL;
      
  
  /* Output example
    {"name":"HORNET","version":"2.0.0-rc.2","status":{"isHealthy":false,"latestMilestone":{"index":1542263,"timestamp":1665846660,"milestoneId":"0xd533ea342a0faf0adf1fee6861eb4d6a98ebeb7a197fac8c9e2ac878e20ea249"},"confirmedMilestone":{"index":1542263,"timestamp":1665846660,"milestoneId":"0xd533ea342a0faf0adf1fee6861eb4d6a98ebeb7a197fac8c9e2ac878e20ea249"},"pruningIndex":1241694},"metrics":{"blocksPerSecond":"0","referencedBlocksPerSecond":"0","referencedRate":"0"},"supportedProtocolVersions":[2],"protocol":{"version":2,"networkName":"testnet","bech32Hrp":"rms","minPowScore":1500,"belowMaxDepth":15,"rentStructure":{"vByteCost":100,"vByteFactorData":1,"vByteFactorKey":10},"tokenSupply":"1450896407249092"},"pendingProtocolParameters":[],"baseToken":{"name":"Shimmer","tickerSymbol":"SMR","unit":"SMR","subunit":"glow","decimals":6,"useMetricPrefix":false},"features":["pow"]}
  */
```

Output single informations

```PHP
  # output
      // print single informations
      echo PHP_EOL;
      if($network->singleNode->getProtocolVersion() == '2') {
        echo $ret->name . PHP_EOL;
        echo $ret->version . PHP_EOL;
        //
        echo $ret->status . PHP_EOL;
        echo $ret->metrics . PHP_EOL;
        echo $ret->supportedProtocolVersions . PHP_EOL;
        echo $ret->protocol . PHP_EOL;
        echo $ret->pendingProtocolParameters . PHP_EOL;
        echo $ret->baseToken . PHP_EOL;
        echo $ret->features . PHP_EOL;
      }
      elseif($network->singleNode->getProtocolVersion() == '1') {
        echo $ret->name . PHP_EOL;
        echo $ret->version . PHP_EOL;
        //
        echo $ret->isHealthy . PHP_EOL;
        echo $ret->networkId . PHP_EOL;
        echo $ret->bech32HRP . PHP_EOL;
        echo $ret->minPoWScore . PHP_EOL;
        echo $ret->messagesPerSecond . PHP_EOL;
        echo $ret->referencedMessagesPerSecond . PHP_EOL;
        echo $ret->referencedRate . PHP_EOL;
        echo $ret->latestMilestoneTimestamp . PHP_EOL;
        echo $ret->latestMilestoneIndex . PHP_EOL;
        echo $ret->confirmedMilestoneIndex . PHP_EOL;
        echo $ret->pruningIndex . PHP_EOL;
        echo $ret->features;
      }
      
  
  /* Output example
    HORNET
    2.0.0-rc.2
    {"isHealthy":false,"latestMilestone":{"index":1542263,"timestamp":1665846660,"milestoneId":"0xd533ea342a0faf0adf1fee6861eb4d6a98ebeb7a197fac8c9e2ac878e20ea249"},"confirmedMilestone":{"index":1542263,"timestamp":1665846660,"milestoneId":"0xd533ea342a0faf0adf1fee6861eb4d6a98ebeb7a197fac8c9e2ac878e20ea249"},"pruningIndex":1241694}
    {"blocksPerSecond":"0","referencedBlocksPerSecond":"0","referencedRate":"0"}
    [2]
    {"version":2,"networkName":"testnet","bech32Hrp":"rms","minPowScore":1500,"belowMaxDepth":15,"rentStructure":{"vByteCost":100,"vByteFactorData":1,"vByteFactorKey":10},"tokenSupply":"1450896407249092"}
    []
    {"name":"Shimmer","tickerSymbol":"SMR","unit":"SMR","subunit":"glow","decimals":6,"useMetricPrefix":false}
    ["pow"]
  */
```

---

## Examples

+ [02_getNodeInfo](https://github.com/tanglePHP/bundle/blob/main/examples/src/singlenode-client/Simple/02_getNodeInfo.php)

## PHPDoc

+ [method_info](https://tanglephp.com/phpdoc/classes/tanglePHP-SingleNodeClient-Connector.html#method_info)
+ [V1 - method_info](https://tanglephp.com/phpdoc/classes/tanglePHP-SingleNodeClient-ConnectorV1.html#method_info)
+ [V2 - method_info](https://tanglephp.com/phpdoc/classes/tanglePHP-SingleNodeClient-ConnectorV2.html#method_info)

---

<- Back to [Overview](000_index.md)