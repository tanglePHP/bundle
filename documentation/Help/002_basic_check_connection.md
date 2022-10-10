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

A network connection can be checked in tanglePHP. In some cases it is necessary to query whether this connection is connected to a FaucetServer or a ChronicleNode.

---

## Use in tanglePHP

### Include autoload 

```PHP
// include tanglePHP autoload
require_once("autoload.php");
// create network connection to shimmer testnet
 $network = new \tanglePHP\Network\Connect('shimmer:testnet');
```

### check FaucetServer

In both cases a "bool" is returned

```PHP
// check has faucet server
$ret = $network->hasFaucetServer();
```

### check ChronicleNode

```PHP
// check has chronicle node
$ret = $network->hasChronicleNode();
```



---

## Examples

+ [01_check](https://github.com/tanglePHP/bundle/blob/main/examples/src/start/01_check.php)

---

<- Back to [Overview](000_index.md)