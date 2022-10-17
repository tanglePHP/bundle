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

## SingleNodeClient - getParticipation

The staking information of a bech32address can also be queried using tanglePHP.

---

## Use in tanglePHP

#### Support: Shimmer (v1) only


```PHP
 // include tanglePHP autoload from tanglePHP/bundle
  require_once("autoload.php");

  use tanglePHP\Network\Connect;

  // create network connection
  $network = new Connect('https://chrysalis-nodes.iota.cafe/');
  // print result of node routes
  $ret = $network->singleNode->v1->addressParticipation("iota1qzedfjw5tzrk74kvf04cfhjkf5m3379d3v77g2xkc4um94c9qvsnqjp33kv");
```

---

### Output initial information
Below is an example of the return:

```PHP
  # output
  foreach($ret->rewards as $eventId => $reward) {
    
    // get event information
    $info   = $network->singleNode->v1->eventParticipation($eventId);
    // get event status information
    $status = $network->singleNode->v1->eventStatusParticipation($eventId);

    echo PHP_EOL;
    echo $eventId . PHP_EOL;
    echo $info . PHP_EOL;
    echo $status . PHP_EOL;
    echo "amount: " . $reward->amount . PHP_EOL;
    echo "symbol: " . $reward->symbol . PHP_EOL;
    echo "minimumReached: " . $reward->minimumReached . PHP_EOL;
  }
  
  /* Output example
    57607d9f8cefc366c3ead71f5b1d76cef1b36a07eb775158c541107951d4aecb
    {"name":"Assembly","milestoneIndexCommence":2041634,"milestoneIndexStart":2102114,"milestoneIndexEnd":2879714,"payload":{"type":1,"text":"Assembly Staking Round 1","symbol":"microASMB","numerator":4,"denominator":1000000,"requiredMinimumRewards":1000000,"additionalInfo":"Tracking the initial staking period for the token distribution of the upcoming Assembly network."},"additionalInfo":"Assembly is a permissionless, highly scalable multi-chain network to build and deploy composable smart contracts. Create. Shape. Build the future of open worlds."}
    {"milestoneIndex":2879714,"status":"ended","staking":{"staked":1886137345866695,"rewarded":5805198730725779,"symbol":"microASMB"},"checksum":"b784c0016d5edb474a605c09fb7ad3e8b1e92d9466c177bb29304b51dcb52018"}
    amount: 373984303996800
    symbol: microASMB
    minimumReached: 1
    
    79958d5ccaaa81cea1dc8b589655d369b16c72f27a44433ba22c5b0a7dc89356
    {"name":"Assembly Round 3","milestoneIndexCommence":3914403,"milestoneIndexStart":3940323,"milestoneIndexEnd":4717923,"payload":{"type":1,"text":"Assembly Staking Round 3","symbol":"microASMB","numerator":1,"denominator":1000000,"requiredMinimumRewards":1000000,"additionalInfo":"Tracking the third staking period for the token distribution of the upcoming Assembly network."},"additionalInfo":"Assembly is a permissionless, highly scalable multi-chain network to build and deploy composable smart contracts. Create. Shape. Build the future of open worlds."}
    {"milestoneIndex":4629051,"status":"holding","staking":{"staked":1534597956787362,"rewarded":907119279977506,"symbol":"microASMB"},"checksum":"bde45b26f4ec9c6a1abbeae1adfd57233b2127edaf0a77402d9b68440368ee8c"}
    amount: 77563451250130
    symbol: microASMB
    minimumReached: 1
    
    90ab02d8f700fcb3b31ff577416ecb105697a664738bec45b626920337a280e0
    {"name":"Assembly Round 2","milestoneIndexCommence":3067769,"milestoneIndexStart":3093689,"milestoneIndexEnd":3871289,"payload":{"type":1,"text":"Assembly Staking Round 2","symbol":"microASMB","numerator":2,"denominator":1000000,"requiredMinimumRewards":1000000,"additionalInfo":"Tracking the second staking period for the token distribution of the upcoming Assembly network."},"additionalInfo":"Assembly is a permissionless, highly scalable multi-chain network to build and deploy composable smart contracts. Create. Shape. Build the future of open worlds."}
    {"milestoneIndex":3871289,"status":"ended","staking":{"staked":1607110521964606,"rewarded":2387828646796566,"symbol":"microASMB"},"checksum":"2b8fd3cafbecc879da591184119a8f70dd150e0584e26d0417496d3746961254"}
    amount: 186593687109578
    symbol: microASMB
    minimumReached: 1
    
    f6dbdad416e0470042d3fe429eb0e91683ba171279bce01be6d1d35a9909a981
    {"name":"Shimmer","milestoneIndexCommence":2041634,"milestoneIndexStart":2102114,"milestoneIndexEnd":2879714,"payload":{"type":1,"text":"Shimmer Genesis Staking","symbol":"SMR","numerator":1,"denominator":1000000,"requiredMinimumRewards":10000000,"additionalInfo":"Tracking the initial token distribution of the upcoming Shimmer network."},"additionalInfo":"The incentivized staging network to advance major innovations by IOTA. Whatever happens, happens - the future of Shimmer will be up to you. Learn, build, earn and grow together."}
    {"milestoneIndex":2879714,"status":"ended","staking":{"staked":1885509698991556,"rewarded":1450910768336284,"symbol":"SMR"},"checksum":"ce2a345ece469615bc52990895e4eaecbc34adb98346fe5a60ddf8764dc5585c"}
    amount: 93496075804800
    symbol: SMR
    minimumReached: 1
  */
```

---

## Examples

+ [25_getParticipation](https://github.com/tanglePHP/examples/blob/main/src/singlenode-client/Simple/25_getParticipation.php)

## PHPDoc

+ [V1 - method_addressParticipation](https://tanglephp.com/phpdoc/classes/tanglePHP-SingleNodeClient-ConnectorV1.html#method_addressParticipation)
+ [V1 - method_eventParticipation](https://tanglephp.com/phpdoc/classes/tanglePHP-SingleNodeClient-ConnectorV1.html#method_eventParticipation)
+ [V1 - method_eventStatusParticipation](https://tanglephp.com/phpdoc/classes/tanglePHP-SingleNodeClient-ConnectorV1.html#method_eventStatusParticipation)

---

<- Back to [Overview](000_index.md)