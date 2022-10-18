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

## Wallet - openWallet

tanglePHP's wallet library offers the easiest way to manage your seed/mnemonic. In order to use this, a SeedInput is required and the network.

---

## Use in tanglePHP

#### Support: Shimmer (v2) & IOTA (v1)


```PHP
 // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");
  
  // Open wallet
  $wallet    = new \tanglePHP\Wallet\Run($mnemonic, 'shimmer:testnet');
  // alternative: Open wallet
  # $wallet = tanglePHP\Wallet\Run::open($mnemonic, 'shimmer:testnet');
```

If a $network has already been declared, this can also be specified as the 2nd parameter

```PHP
 // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");
  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');
  
  // Open wallet
  $wallet    = new \tanglePHP\Wallet\Run($mnemonic, $network);
  // alternative: Open wallet
  # $wallet = tanglePHP\Wallet\Run::open($mnemonic, $network);
```

---

## Parameters to pass

```PHP
   /**
   * @param Ed25519Seed|Mnemonic|string|array $seedInput
   * @param Connect|Connector|string          $client
   */
```

---


## Examples

+ [01_useWallet](https://github.com/tanglePHP/bundle/blob/main/examples/src/wallet/01_useWallet.php)

## PHPDoc

+ [Wallet-Run](https://tanglephp.com/phpdoc/classes/tanglePHP-Wallet-Run.html)

---

<- Back to [Overview](000_index.md)