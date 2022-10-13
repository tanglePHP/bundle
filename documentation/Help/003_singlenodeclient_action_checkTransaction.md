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

## SingleNodeClient - checkTransaction

Of course there is the possibility to check transactions, this call takes place by default with the "sendTransaction" action.
But transactions that are not made via tanglePHP may also have to be checked. For this there is the action "checkTransaction".

---

## Use in tanglePHP

#### Support: Shimmer (v2) & IOTA (v1)


```PHP
 // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\checkTransaction;

  // create network connection
  $network = new Connect('shimmer:testnet');
  // check transaction (blockId)
  echo $ret = (new checkTransaction($network->singleNode))->blockId("0x5c060723d699f0fdd4210b1f148fbe2ff5b0f2afc6b5dd7a275c778908513c5f")
                                                          ->run();
```

> The messageId is transferred in the V1 protocol!

---

A string is always returned, the following feedback can be given, provided that there is no conflict, "included" is returned:

```PHP
  // protocoll V2
  public array $conflictReason = [
    1   => "the referenced UTXO was already spent.",
    2   => "the referenced UTXO was already spent while confirming this milestone.",
    3   => "the referenced UTXO cannot be found.",
    4   => "the sum of the inputs and output values does not match.",
    5   => "the unlock block signature is invalid.",
    6   => "the configured timelock is not yet expired.",
    7   => "the given native tokens are invalid.",
    8   => "the return amount in a transaction is not fulfilled by the output side.",
    9   => "the input unlock is invalid.",
    10  => "the inputs commitment is invalid.",
    11  => "an output contains a Sender with an ident (address) which is not unlocked.",
    12  => "the chain state transition is invalid.",
    255 => "the semantic validation failed.",
  ];
  
  // protocoll V1
  public array $conflictReasonV1 = [
    1 => "referenced UTXO was already spent.",
    2 => "referenced UTXO was already spent while confirming this milestone.",
    3 => "referenced UTXO cannot be found.",
    4 => "sum of the inputs and output values does not match.",
    5 => "unlock block signature is invalid.",
    6 => "input or output type used is unsupported.",
    7 => "used address type is unsupported.",
    8 => "dust allowance for the address is invalid.",
    9 => "semantic validation failed.",
  ];
```

---

### Output initial information
Below is an example of the return:

```PHP
  # output  
  /* Output example
    included
  */
```

---

## Examples

+ [04_checkTransaction](https://github.com/tanglePHP/bundle/blob/main/examples/src/singlenode-client/Action/04_checkTransaction.php)

---

<- Back to [Overview](000_index.md)