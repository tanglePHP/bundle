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

## SingleNodeClient - getRoutes

It is possible to get the routes via the Node RestApi. This enables tanglePHP to load the necessary tanglePHP plugins and set up further communications. For projects that work with statistics and manage nodes, it can be interesting to output or check this information.

---

## Use in tanglePHP

#### Support: Shimmer (v2) only


```PHP
 // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");

  use tanglePHP\Network\Connect;

  // create network connection
  $network = new Connect('shimmer:testnet');
  // print result of node routes
  $ret = $network->singleNode->routes();
```

---

### Output initial information
Below is an example of the return:

```PHP
  # output
      // print single information
      echo PHP_EOL;
      echo $ret->routes . PHP_EOL;
  
  /* Output example
    ["core\/v2","dashboard-metrics\/v1","indexer\/v1","mqtt\/v1","participation\/v1","poi\/v1","spammer\/v1"]
  */
```

---

## Examples

+ [00_getRoutes](https://github.com/tanglePHP/bundle/blob/main/examples/src/singlenode-client/Simple/00_getRoutes.php)

---

<- Back to [Overview](000_index.md)