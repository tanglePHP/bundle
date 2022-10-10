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

## Basic - Connection

With tanglePHP it is very easy to connect to the Tangle. First the "autoload.php" is required. if composer is used, the "autoload" of composer must of course be loaded.
A connection to the network (Tangle) is then established.

---

## Use in tanglePHP

### Include autoload 

```PHP
// include tanglePHP autoload
require_once("autoload.php");
```

## create network connection 

The following describes how to connect to the different networks (tangles):

### Shimmer

```PHP
// create network connection to shimmer testnet
 $network = new \tanglePHP\Network\Connect('shimmer:testnet');
```
```PHP
// create network connection to shimmer mainnet
$network = new \tanglePHP\Network\Connect('shimmer:mainnet');
```

### IOTA

```PHP
// create network connection to iota devnet
$network = new \tanglePHP\Network\Connect('iota:devnet');
```
```PHP
// create network connection to shimmer mainnet
$network = new \tanglePHP\Network\Connect('shimmer:mainnet');
```

---

### DLT.GREEN

DLT Green offers a node pool, so you don't have to worry about the node itself, whether it's running, up-to-date and/or healthy. A "healthy" node is always sought and connected to.
> At the current time, these nodes always connect to the mainnet

```PHP
// shimmer
$network = new \tanglePHP\Network\Connect('dlt.green:shimmer');
```
```PHP
// iota
$network = new \tanglePHP\Network\Connect('dlt.green:iota');
```

If the 1 parameter is not specified, a connection to the DLT.green node pool (Shimmer mainnet) is always established!

```PHP
// create network connection
 $network = new \tanglePHP\Network\Connect();
```

---

### Connect to your own node

Of course it is also possible to connect to your own IOTA/Shimmer node.

```PHP
// connect to your own node
$network = new \tanglePHP\Network\Connect('https://tanglephp.dlt.green');
```

> The path to the api does not have to be specified unless it has been changed in the node settings or a subdomain has been created for it

---

### Output initial information
The following command can be executed to get the information about the "network":

```PHP
  # output connect info
  print_r($network->getInfo());
  print_r($network->getENDPOINTUrls());

  /* Output example
    Array
    (
        [network] => shimmer
        [networkName] => shimmer
        [networkId] => 14364762045254553490
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
        [bech32Hrp] => smr
    )
  
    Array
    (
        [explorer] => https://explorer.shimmer.network/shimmer/
        [singleNode] => https://lithuania.dlt.builders:443/api/core/v2/
        [market] => https://api.coingecko.com/api/v3/
        [chronicleNode] => https://chronicle.shimmer.network/api/
    )
   */
```

---

## Examples

+ [00_connect](https://github.com/tanglePHP/bundle/blob/main/examples/src/start/00_connect.php)
+ [02_getNodeInfo](https://github.com/tanglePHP/bundle/blob/main/examples/src/singlenode-client/Simple/02_getNodeInfo.php)

---

<- Back to [Overview](000_index.md)