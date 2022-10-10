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

## Basic - Crypto (Mnemonic)

The mnemonic is a "memory aid", it consists of 24 words. This is named "seed phrase" (BIP39). BIP39 is the most common standard used for seed phrases.

---

## Use in tanglePHP

### Include autoload 

```PHP
// include tanglePHP autoload
require_once("autoload.php");
```

### Create random mnemonic 

```PHP
$mnemonic = tanglePHP\Core\Helper\Simplifier::createMnemonic();
```

### Create mnemonic with 24 words

```PHP
$mnemonic = \tanglePHP\Core\Helper\Simplifier::reverseMnemonic('giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
```

### Check that the mnemonic is valid for 24 words

```PHP
$mnemonic = \tanglePHP\Core\Helper\Simplifier::checkMnemonic('dynamic giant museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
// returns (bool)false
```

---

## Examples

+ [01_mnemonic](https://github.com/tanglePHP/bundle/blob/main/examples/src/crypto/01_mnemonic.php)

---

<- Back to [Overview](000_index.md)