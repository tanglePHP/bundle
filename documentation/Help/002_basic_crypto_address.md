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

## Basic - Crypto (Address)

To create an address in the IOTA ecosystem, an ed25519 seed is created from the mnemonic (in Firefly this would be the "profile").

An address path is then created, for which the CoinType is required (4219 = Shimmer | 4218 = IOTA), the AccountIndex (in Firefly it would be e.g.: "Wallet 1, Wallet 2,...), the
AddressIndex (in Firefly this would be the created  address, in Firefly the value is increased by 1 when generating a new address)

An address seed is then created using "Slip0010".

The final address is then generated from this address seed.

In Chrysalis and Stardust the address is then converted into a Bech32 string. Furthermore, you can alternatively output the Ed25519 address. In "DevNet 2.0" the address is displayed as base58, so there is also the possibility in tanglePHP to have this string output.

---

## Use in tanglePHP

### Include autoload

```PHP
// include tanglePHP autoload
require_once("autoload.php");
```

### Create mnemonic

```PHP
$mnemonic = \tanglePHP\Core\Helper\Simplifier::reverseMnemonic('giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
```

### Create ed25519Seed

```PHP
$ed25519Seed = tanglePHP\Core\Helper\Simplifier::createEd25519Seed($mnemonic);
```

### Create addressPath

coinType (4219 = Shimmer | 4218 = IOTA), AccountIndex, AddressIndex

```PHP
$addressPath = \tanglePHP\Core\Helper\Simplifier::createAddressPath(4219, 0,0);
```

### Create addressSeed from addressPath

```PHP
$addressSeed = $ed25519Seed->generateSeedFromPath($addressPath);
```

### create final address 0

```PHP
$address = new \tanglePHP\Core\Type\Ed25519Address($addressSeed->keyPair()->public);
```

### Get the bech32 address string

rms = Shimmer testnet | smr = Shimmer mainnnet | atoi = IOTA devnet | iota = IOTA mainnet

```PHP
$addressBech32 = $address->toAddressBetch32("rms");
```

---

### Alternative: get the ed25519 address string

```PHP
$addressBech32 = $address->toAddress();
```

### Alternative: get the base58 address string

```PHP
$addressBech32 = $address->toAddressBase58();
```

---

## Examples

+ [02_address](https://github.com/tanglePHP/bundle/blob/main/examples/src/crypto/02_address.php)

---

<- Back to [Overview](000_index.md)