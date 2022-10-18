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

## Wallet - sendToken

To send tokens, an address is opened, then an amount can be sent to another address with "send()".

The receiving address is specified as the first parameter.

The second parameter is the amount (how many tokens should be sent).

---

## Use in tanglePHP

#### Support: Shimmer (v2) & IOTA (v1)

```PHP
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");
  
  // Open wallet
  $wallet    = new \tanglePHP\Wallet\Run($mnemonic, 'shimmer:testnet');
  
  // get address 0/0
  $address_0 = $wallet->address(0, 0);
  // send Tokens
  $ret = $address_0->send('rms1qqdfq7k49zs77q0sk03wagjsrz4qsaqulpl0qw87cjc6z9mn6kzwkk8kzgh', 1000000) . PHP_EOL;
```

---

## Output initial information

```PHP  
  # output
  echo $ret;

  /* Output example
    {"blockId":"0x199ffbbf76f4139cd55b73a3b39febeec1e48bdc55aea1be0b1be3501f807f97","check":"included","explorerUrl":"https:\/\/explorer.shimmer.network\/testnet\/block\/0x199ffbbf76f4139cd55b73a3b39febeec1e48bdc55aea1be0b1be3501f807f97","marketData":{"shimmer":{"usd":0.081191,"eur":0.0824,"last_updated_at":1666077375}},"networkInfo":{"network":"shimmer","networkName":"testnet","networkId":"8342982141227064571","protocolVersion":2,"singleNodeName":"HORNET","singleNodeVersion":"2.0.0-rc.2","singleNodeHealthy":true,"features":["pow"],"baseToken":"SMR","coinType":4219,"bech32Hrp":"rms"},"marketData_balance":{"last_updated_at":1666077375,"balance":1000000,"balanceCalc":1,"coin":"shimmer","price":{"usd":0.081191,"eur":0.0824,"last_updated_at":1666077375},"calc":{"usd":0.081191,"eur":0.0824}}}
  */
```

---


## Examples

+ [03_WalletSendToken](https://github.com/tanglePHP/bundle/blob/main/examples/src/wallet/03_WalletSendToken.php)

## PHPDoc

+ [Wallet-Run](https://tanglephp.com/phpdoc/classes/tanglePHP-Wallet-Run.html)
+ [Wallet-Type-Address](https://tanglephp.com/phpdoc/classes/tanglePHP-Wallet-Type-Address.html)

---

<- Back to [Overview](000_index.md)