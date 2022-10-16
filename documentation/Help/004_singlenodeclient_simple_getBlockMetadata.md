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

## SingleNodeClient - getBlockMetadata

To get more information about a block, a simple call to "blockMetadata()" can be made in tanglePHP.

---

## Use in tanglePHP

#### Support: Shimmer (v2) & IOTA (v1)

Get informations about a block

```PHP
 // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");

  use tanglePHP\Network\Connect;

  // create network connection
  $network = new Connect('shimmer:testnet');
  // get result of blockMetadata
  $ret = $network->singleNode->blockMetadata("0x59bf5bbcdedf675bc48ccf25bda04bcb2e608e4f6b933b9714320e0e79b10b03");
```

---

### Output initial information
Below is an example of the return:

```PHP
  # output
      // print result
      echo PHP_EOL;
      echo $ret . PHP_EOL;
      
  /* Output example
   {"blockId":"0x59bf5bbcdedf675bc48ccf25bda04bcb2e608e4f6b933b9714320e0e79b10b03","parents":["0x705ed24dc1b0939d847a19a0ba61a759ffc6853573d6ce3742e2283d00077b4f","0x99ff7d5ee637f4af55fa36273d188b1cae2cab87a2e8e8a4d8def43cd93bbbe0","0x9b3ff62417156c3d03f20fec42b5d30909170dae7edb895da62ce6551d090c4f","0xf1ec0644d82122101452cff19747a52d9db20de8916d1d14e5758cfc6a299cff"],"isSolid":true,"referencedByMilestoneIndex":1557348,"ledgerInclusionState":"noTransaction","whiteFlagIndex":7}
  */
```

---

## Examples

+ [08_getBlockMetadata](https://github.com/tanglePHP/bundle/blob/main/examples/src/singlenode-client/Simple/08_getBlockMetadata.php)

---

<- Back to [Overview](000_index.md)