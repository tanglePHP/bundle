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

# Overview

Client library for IOTA chrysalis & stardust network, implemeted in PHP to strongly type the objects sent and received from the API.

_The aim of the this lib is to offer PHP developers an easy way to interact with the Stardust protocol._

### Installation

+ [Github | Git](./001_installation_github.md)
+ [Composer](./001_installation_composer.md) (Recommended for easy updates)

### Getting Started

To familiarize yourself with tanglePHP, I recommend starting here and getting an insight. The help pages always combine a description of the functions, step-by-step instructions, examples with outputs and links to examples and phpdoc.

+ The Basics
    + [Connection](./002_basic_connection.md)
    + [Check FaucetServer|ChronicleNode](./002_basic_check_connection.md)

+ Core (Crypto)
    + [Mnemonic (create | check)](./002_basic_crypto_mnemonic.md)
    + [Address (create | check)](./002_basic_crypto_address.md)


+ SingleNodeClient
    + Actions
        + [getBalance](./003_singlenodeclient_action_getBalance.md) (get amount of Address)
        + [sendMessage](./003_singlenodeclient_action_sendMessage.md) (send taggedData)
        + [sendTransaction](./003_singlenodeclient_action_sendTransaction.md) (send IOTA/SMR)
        + [searchTag](./003_singlenodeclient_action_searchTag.md) (search index/tag)
        + [getSpendable](./003_singlenodeclient_action_getSpendable.md) (receive sender information)
        + [checkTransaction](./003_singlenodeclient_action_checkTransaction.md)
    + Simple
        + [getRoutes](./004_singlenodeclient_simple_getRoutes.md) (Returns the available API route groups of the node)
        + [getInfo](./004_singlenodeclient_simple_getInfo.md) (Returns general information about the node)
        + [getBlock](./004_singlenodeclient_simple_getBlock.md) (Find a block by its identifier)
        + [getBlockMetadata](./004_singlenodeclient_simple_getBlockMetadata.md) (Find the metadata of a given block)
        + [getParticipation](./004_singlenodeclient_simple_getParticipation.md) (Staking information)


+ Wallet
  + [openWallet](./005_wallet_open.md)
  + [useWallet](./005_wallet_use.md)
  + [searchAddresses](./005_wallet_searchAddresses.md)
  + [sendToken](./005_wallet_sendToken.md)


+ If you have any problems, don't hesitate to get in touch.
    + [Troubleshooting](./100_troubleshooting.md)

---

## Other

+ [Web | Links](./100_web.md)
+ [Support | Donation](./100_donation.md)
+ [Joining the discussion](./100_discussion.md)

---

<- Back to [Readme](../README.md)