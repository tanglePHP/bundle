<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  use tanglePHP\Core\Exception\Api;
  use tanglePHP\Core\Exception\Converter;
  use tanglePHP\Core\Exception\Helper;
  use tanglePHP\Core\Helper\JSON;
  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\getBalance;
  use tanglePHP\SingleNodeClient\Models\ReturnAddressBalance;

  /**
   * Class timsonLabs_example_01
   *
   * @author       Stefan Braun <stefan.braun@tanglePHP.com>
   * @copyright    Copyright (c) 2022, StefanBraun
   * @version      2022.10.06-1028
   */
  class timsonLabs_example_02 {
    /**
     * @var array|null[]
     */
    protected array $networks = [
      'iota'            => null,
      'shimmer'         => null,
      'iota_devnet'     => null,
      'shimmer_testnet' => null,
    ];
    /**
     * @var Connect
     */
    protected Connect $useNetwork;
    /**
     * @var array
     */
    public array $marketData;
    /**
     * @var array
     */
    public array $marketDataBalance;
    /**
     * @var array
     */
    public array $participation;
    /**
     * @var JSON|ReturnAddressBalance
     */
    public JSON|ReturnAddressBalance $return;
    /**
     * @var bool|int
     */
    public ?bool $status = null;

    /**
     * @param string $address
     *
     * @return JSON|ReturnAddressBalance
     * @throws Api
     * @throws Converter
     * @throws Helper
     */
    public function getBalance(string $address): JSON|ReturnAddressBalance {
      $checkParticipation = false;
      if(str_starts_with($address, 'smr')) {
        $this->useNetwork = $this->networks['shimmer'] = $this->networks['shimmer'] ?? new Connect('shimmer:mainnet');
      }
      elseif(str_starts_with($address, 'rms')) {
        $this->useNetwork = $this->networks['shimmer_testnet'] = $this->networks['shimmer_testnet'] ?? new Connect('shimmer:testnet');
      }
      elseif(str_starts_with($address, 'iota')) {
        $this->useNetwork   = $this->networks['iota'] = $this->networks['iota'] ?? new Connect('https://chrysalis-nodes.iota.cafe/');
        $checkParticipation = true;
      }
      elseif(str_starts_with($address, 'atoi')) {
        $this->useNetwork = $this->networks['iota_devnet'] = $this->networks['iota_devnet'] ?? new Connect('iota:devnet');
      }
      else {
        // default to shimmer_testnet
        $this->useNetwork = $this->networks['shimmer_testnet'] = $this->networks['shimmer_testnet'] ?? new Connect('shimmer:testnet');
      }
      //
      $this->return = (new getBalance($this->useNetwork))->address($address)
                                                         ->run();
      if(isset($this->return->balance)) {
        $this->status            = true;
        $this->marketData        = ($this->return->marketData->__toArray());
        $this->marketDataBalance = ($this->return->marketData_balance->__toArray());
        $this->participation     = $this->getParticipation($address);
      }
      else {
        $this->status = false;
        // handle error!
      }

      return $this->return;
    }

    /**
     * @param $address
     *
     * @return array
     * @throws Api
     * @throws Helper
     */
    private function getParticipation($address): array {
      $return = [];
      $ret    = $this->useNetwork->singleNode->v1->addressParticipation($address);
      if(isset($ret->rewards)) {
        foreach($ret->rewards as $eventId => $reward) {
          $add           = [];
          $add['info']   = $this->useNetwork->singleNode->v1->eventParticipation($eventId);
          $add['status'] = $this->useNetwork->singleNode->v1->eventStatusParticipation($eventId);
          $return[]      = $add;
        }
      }

      return $return;
    }
  }
  //
  $example = new timsonLabs_example_02();
  $example->getBalance('iota1qzedfjw5tzrk74kvf04cfhjkf5m3379d3v77g2xkc4um94c9qvsnqjp33kv');
  if($example->status) {
    print_r($example->marketData);
    print_r($example->marketDataBalance);
    print_r($example->participation);
  }
  else {
    echo $example->return;
    // handle
  }




// outputs like this
/*

Array
(
    [iota] => Array
        (
            [usd] => 0.274307
            [eur] => 0.277441
            [last_updated_at] => 1665045392
        )

)
Array
(
    [last_updated_at] => 1665045392
    [balance] => 120313976273841
    [balanceCalc] => 120313976.27384
    [coin] => iota
    [price] => Array
        (
            [usd] => 0.274307
            [eur] => 0.277441
            [last_updated_at] => 1665045392
        )

    [calc] => Array
        (
            [usd] => 33002965.889749
            [eur] => 33380029.891391
        )

)
Array
(
    [0] => Array
        (
            [info] => tanglePHP\SingleNodeClient\Api\v1\ResponseParticipationEvent Object
                (
                    [_input:protected] => tanglePHP\Core\Helper\JSON Object
                        (
                            [array] => Array
                                (
                                    [name] => Assembly
                                    [milestoneIndexCommence] => 2041634
                                    [milestoneIndexStart] => 2102114
                                    [milestoneIndexEnd] => 2879714
                                    [payload] => Array
                                        (
                                            [type] => 1
                                            [text] => Assembly Staking Round 1
                                            [symbol] => microASMB
                                            [numerator] => 4
                                            [denominator] => 1000000
                                            [requiredMinimumRewards] => 1000000
                                            [additionalInfo] => Tracking the initial staking period for the token distribution of the upcoming Assembly network.
                                        )

                                    [additionalInfo] => Assembly is a permissionless, highly scalable multi-chain network to build and deploy composable smart contracts. Create. Shape. Build the future of open worlds.
                                )

                            [string:protected] => {"name":"Assembly","milestoneIndexCommence":2041634,"milestoneIndexStart":2102114,"milestoneIndexEnd":2879714,"payload":{"type":1,"text":"Assembly Staking Round 1","symbol":"microASMB","numerator":4,"denominator":1000000,"requiredMinimumRewards":1000000,"additionalInfo":"Tracking the initial staking period for the token distribution of the upcoming Assembly network."},"additionalInfo":"Assembly is a permissionless, highly scalable multi-chain network to build and deploy composable smart contracts. Create. Shape. Build the future of open worlds."}
                        )

                    [name] => Assembly
                    [milestoneIndexCommence] => 2041634
                    [milestoneIndexStart] => 2102114
                    [milestoneIndexEnd] => 2879714
                    [payload] => tanglePHP\Core\Models\ResponseArray Object
                        (
                            [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                (
                                    [array] => Array
                                        (
                                            [type] => 1
                                            [text] => Assembly Staking Round 1
                                            [symbol] => microASMB
                                            [numerator] => 4
                                            [denominator] => 1000000
                                            [requiredMinimumRewards] => 1000000
                                            [additionalInfo] => Tracking the initial staking period for the token distribution of the upcoming Assembly network.
                                        )

                                    [string:protected] => {"type":1,"text":"Assembly Staking Round 1","symbol":"microASMB","numerator":4,"denominator":1000000,"requiredMinimumRewards":1000000,"additionalInfo":"Tracking the initial staking period for the token distribution of the upcoming Assembly network."}
                                )

                            [type] => 1
                            [text] => Assembly Staking Round 1
                            [symbol] => microASMB
                            [numerator] => 4
                            [denominator] => 1000000
                            [requiredMinimumRewards] => 1000000
                            [additionalInfo] => Tracking the initial staking period for the token distribution of the upcoming Assembly network.
                        )

                    [additionalInfo] => Assembly is a permissionless, highly scalable multi-chain network to build and deploy composable smart contracts. Create. Shape. Build the future of open worlds.
                )

            [status] => tanglePHP\SingleNodeClient\Api\v1\ResponseParticipationEvent Object
                (
                    [_input:protected] => tanglePHP\Core\Helper\JSON Object
                        (
                            [array] => Array
                                (
                                    [milestoneIndex] => 2879714
                                    [status] => ended
                                    [staking] => Array
                                        (
                                            [staked] => 1886137345866695
                                            [rewarded] => 5805198730725779
                                            [symbol] => microASMB
                                        )

                                    [checksum] => b784c0016d5edb474a605c09fb7ad3e8b1e92d9466c177bb29304b51dcb52018
                                )

                            [string:protected] => {"milestoneIndex":2879714,"status":"ended","staking":{"staked":1886137345866695,"rewarded":5805198730725779,"symbol":"microASMB"},"checksum":"b784c0016d5edb474a605c09fb7ad3e8b1e92d9466c177bb29304b51dcb52018"}
                        )

                    [milestoneIndex] => 2879714
                    [status] => ended
                    [staking] => tanglePHP\Core\Models\ResponseArray Object
                        (
                            [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                (
                                    [array] => Array
                                        (
                                            [staked] => 1886137345866695
                                            [rewarded] => 5805198730725779
                                            [symbol] => microASMB
                                        )

                                    [string:protected] => {"staked":1886137345866695,"rewarded":5805198730725779,"symbol":"microASMB"}
                                )

                            [staked] => 1886137345866695
                            [rewarded] => 5805198730725779
                            [symbol] => microASMB
                        )

                    [checksum] => b784c0016d5edb474a605c09fb7ad3e8b1e92d9466c177bb29304b51dcb52018
                )

        )

    [1] => Array
        (
            [info] => tanglePHP\SingleNodeClient\Api\v1\ResponseParticipationEvent Object
                (
                    [_input:protected] => tanglePHP\Core\Helper\JSON Object
                        (
                            [array] => Array
                                (
                                    [name] => Assembly Round 3
                                    [milestoneIndexCommence] => 3914403
                                    [milestoneIndexStart] => 3940323
                                    [milestoneIndexEnd] => 4717923
                                    [payload] => Array
                                        (
                                            [type] => 1
                                            [text] => Assembly Staking Round 3
                                            [symbol] => microASMB
                                            [numerator] => 1
                                            [denominator] => 1000000
                                            [requiredMinimumRewards] => 1000000
                                            [additionalInfo] => Tracking the third staking period for the token distribution of the upcoming Assembly network.
                                        )

                                    [additionalInfo] => Assembly is a permissionless, highly scalable multi-chain network to build and deploy composable smart contracts. Create. Shape. Build the future of open worlds.
                                )

                            [string:protected] => {"name":"Assembly Round 3","milestoneIndexCommence":3914403,"milestoneIndexStart":3940323,"milestoneIndexEnd":4717923,"payload":{"type":1,"text":"Assembly Staking Round 3","symbol":"microASMB","numerator":1,"denominator":1000000,"requiredMinimumRewards":1000000,"additionalInfo":"Tracking the third staking period for the token distribution of the upcoming Assembly network."},"additionalInfo":"Assembly is a permissionless, highly scalable multi-chain network to build and deploy composable smart contracts. Create. Shape. Build the future of open worlds."}
                        )

                    [name] => Assembly Round 3
                    [milestoneIndexCommence] => 3914403
                    [milestoneIndexStart] => 3940323
                    [milestoneIndexEnd] => 4717923
                    [payload] => tanglePHP\Core\Models\ResponseArray Object
                        (
                            [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                (
                                    [array] => Array
                                        (
                                            [type] => 1
                                            [text] => Assembly Staking Round 3
                                            [symbol] => microASMB
                                            [numerator] => 1
                                            [denominator] => 1000000
                                            [requiredMinimumRewards] => 1000000
                                            [additionalInfo] => Tracking the third staking period for the token distribution of the upcoming Assembly network.
                                        )

                                    [string:protected] => {"type":1,"text":"Assembly Staking Round 3","symbol":"microASMB","numerator":1,"denominator":1000000,"requiredMinimumRewards":1000000,"additionalInfo":"Tracking the third staking period for the token distribution of the upcoming Assembly network."}
                                )

                            [type] => 1
                            [text] => Assembly Staking Round 3
                            [symbol] => microASMB
                            [numerator] => 1
                            [denominator] => 1000000
                            [requiredMinimumRewards] => 1000000
                            [additionalInfo] => Tracking the third staking period for the token distribution of the upcoming Assembly network.
                        )

                    [additionalInfo] => Assembly is a permissionless, highly scalable multi-chain network to build and deploy composable smart contracts. Create. Shape. Build the future of open worlds.
                )

            [status] => tanglePHP\SingleNodeClient\Api\v1\ResponseParticipationEvent Object
                (
                    [_input:protected] => tanglePHP\Core\Helper\JSON Object
                        (
                            [array] => Array
                                (
                                    [milestoneIndex] => 4534876
                                    [status] => holding
                                    [staking] => Array
                                        (
                                            [staked] => 1526584110993619
                                            [rewarded] => 762977976259810
                                            [symbol] => microASMB
                                        )

                                    [checksum] => f6e0f2080f3b67dfe5799e21695c2a453a3dfd9087faace0bffe3c5f1df336ee
                                )

                            [string:protected] => {"milestoneIndex":4534876,"status":"holding","staking":{"staked":1526584110993619,"rewarded":762977976259810,"symbol":"microASMB"},"checksum":"f6e0f2080f3b67dfe5799e21695c2a453a3dfd9087faace0bffe3c5f1df336ee"}
                        )

                    [milestoneIndex] => 4534876
                    [status] => holding
                    [staking] => tanglePHP\Core\Models\ResponseArray Object
                        (
                            [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                (
                                    [array] => Array
                                        (
                                            [staked] => 1526584110993619
                                            [rewarded] => 762977976259810
                                            [symbol] => microASMB
                                        )

                                    [string:protected] => {"staked":1526584110993619,"rewarded":762977976259810,"symbol":"microASMB"}
                                )

                            [staked] => 1526584110993619
                            [rewarded] => 762977976259810
                            [symbol] => microASMB
                        )

                    [checksum] => f6e0f2080f3b67dfe5799e21695c2a453a3dfd9087faace0bffe3c5f1df336ee
                )

        )

    [2] => Array
        (
            [info] => tanglePHP\SingleNodeClient\Api\v1\ResponseParticipationEvent Object
                (
                    [_input:protected] => tanglePHP\Core\Helper\JSON Object
                        (
                            [array] => Array
                                (
                                    [name] => Assembly Round 2
                                    [milestoneIndexCommence] => 3067769
                                    [milestoneIndexStart] => 3093689
                                    [milestoneIndexEnd] => 3871289
                                    [payload] => Array
                                        (
                                            [type] => 1
                                            [text] => Assembly Staking Round 2
                                            [symbol] => microASMB
                                            [numerator] => 2
                                            [denominator] => 1000000
                                            [requiredMinimumRewards] => 1000000
                                            [additionalInfo] => Tracking the second staking period for the token distribution of the upcoming Assembly network.
                                        )

                                    [additionalInfo] => Assembly is a permissionless, highly scalable multi-chain network to build and deploy composable smart contracts. Create. Shape. Build the future of open worlds.
                                )

                            [string:protected] => {"name":"Assembly Round 2","milestoneIndexCommence":3067769,"milestoneIndexStart":3093689,"milestoneIndexEnd":3871289,"payload":{"type":1,"text":"Assembly Staking Round 2","symbol":"microASMB","numerator":2,"denominator":1000000,"requiredMinimumRewards":1000000,"additionalInfo":"Tracking the second staking period for the token distribution of the upcoming Assembly network."},"additionalInfo":"Assembly is a permissionless, highly scalable multi-chain network to build and deploy composable smart contracts. Create. Shape. Build the future of open worlds."}
                        )

                    [name] => Assembly Round 2
                    [milestoneIndexCommence] => 3067769
                    [milestoneIndexStart] => 3093689
                    [milestoneIndexEnd] => 3871289
                    [payload] => tanglePHP\Core\Models\ResponseArray Object
                        (
                            [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                (
                                    [array] => Array
                                        (
                                            [type] => 1
                                            [text] => Assembly Staking Round 2
                                            [symbol] => microASMB
                                            [numerator] => 2
                                            [denominator] => 1000000
                                            [requiredMinimumRewards] => 1000000
                                            [additionalInfo] => Tracking the second staking period for the token distribution of the upcoming Assembly network.
                                        )

                                    [string:protected] => {"type":1,"text":"Assembly Staking Round 2","symbol":"microASMB","numerator":2,"denominator":1000000,"requiredMinimumRewards":1000000,"additionalInfo":"Tracking the second staking period for the token distribution of the upcoming Assembly network."}
                                )

                            [type] => 1
                            [text] => Assembly Staking Round 2
                            [symbol] => microASMB
                            [numerator] => 2
                            [denominator] => 1000000
                            [requiredMinimumRewards] => 1000000
                            [additionalInfo] => Tracking the second staking period for the token distribution of the upcoming Assembly network.
                        )

                    [additionalInfo] => Assembly is a permissionless, highly scalable multi-chain network to build and deploy composable smart contracts. Create. Shape. Build the future of open worlds.
                )

            [status] => tanglePHP\SingleNodeClient\Api\v1\ResponseParticipationEvent Object
                (
                    [_input:protected] => tanglePHP\Core\Helper\JSON Object
                        (
                            [array] => Array
                                (
                                    [milestoneIndex] => 3871289
                                    [status] => ended
                                    [staking] => Array
                                        (
                                            [staked] => 1607110521964606
                                            [rewarded] => 2387828646796566
                                            [symbol] => microASMB
                                        )

                                    [checksum] => 2b8fd3cafbecc879da591184119a8f70dd150e0584e26d0417496d3746961254
                                )

                            [string:protected] => {"milestoneIndex":3871289,"status":"ended","staking":{"staked":1607110521964606,"rewarded":2387828646796566,"symbol":"microASMB"},"checksum":"2b8fd3cafbecc879da591184119a8f70dd150e0584e26d0417496d3746961254"}
                        )

                    [milestoneIndex] => 3871289
                    [status] => ended
                    [staking] => tanglePHP\Core\Models\ResponseArray Object
                        (
                            [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                (
                                    [array] => Array
                                        (
                                            [staked] => 1607110521964606
                                            [rewarded] => 2387828646796566
                                            [symbol] => microASMB
                                        )

                                    [string:protected] => {"staked":1607110521964606,"rewarded":2387828646796566,"symbol":"microASMB"}
                                )

                            [staked] => 1607110521964606
                            [rewarded] => 2387828646796566
                            [symbol] => microASMB
                        )

                    [checksum] => 2b8fd3cafbecc879da591184119a8f70dd150e0584e26d0417496d3746961254
                )

        )

    [3] => Array
        (
            [info] => tanglePHP\SingleNodeClient\Api\v1\ResponseParticipationEvent Object
                (
                    [_input:protected] => tanglePHP\Core\Helper\JSON Object
                        (
                            [array] => Array
                                (
                                    [name] => Shimmer
                                    [milestoneIndexCommence] => 2041634
                                    [milestoneIndexStart] => 2102114
                                    [milestoneIndexEnd] => 2879714
                                    [payload] => Array
                                        (
                                            [type] => 1
                                            [text] => Shimmer Genesis Staking
                                            [symbol] => SMR
                                            [numerator] => 1
                                            [denominator] => 1000000
                                            [requiredMinimumRewards] => 10000000
                                            [additionalInfo] => Tracking the initial token distribution of the upcoming Shimmer network.
                                        )

                                    [additionalInfo] => The incentivized staging network to advance major innovations by IOTA. Whatever happens, happens - the future of Shimmer will be up to you. Learn, build, earn and grow together.
                                )

                            [string:protected] => {"name":"Shimmer","milestoneIndexCommence":2041634,"milestoneIndexStart":2102114,"milestoneIndexEnd":2879714,"payload":{"type":1,"text":"Shimmer Genesis Staking","symbol":"SMR","numerator":1,"denominator":1000000,"requiredMinimumRewards":10000000,"additionalInfo":"Tracking the initial token distribution of the upcoming Shimmer network."},"additionalInfo":"The incentivized staging network to advance major innovations by IOTA. Whatever happens, happens - the future of Shimmer will be up to you. Learn, build, earn and grow together."}
                        )

                    [name] => Shimmer
                    [milestoneIndexCommence] => 2041634
                    [milestoneIndexStart] => 2102114
                    [milestoneIndexEnd] => 2879714
                    [payload] => tanglePHP\Core\Models\ResponseArray Object
                        (
                            [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                (
                                    [array] => Array
                                        (
                                            [type] => 1
                                            [text] => Shimmer Genesis Staking
                                            [symbol] => SMR
                                            [numerator] => 1
                                            [denominator] => 1000000
                                            [requiredMinimumRewards] => 10000000
                                            [additionalInfo] => Tracking the initial token distribution of the upcoming Shimmer network.
                                        )

                                    [string:protected] => {"type":1,"text":"Shimmer Genesis Staking","symbol":"SMR","numerator":1,"denominator":1000000,"requiredMinimumRewards":10000000,"additionalInfo":"Tracking the initial token distribution of the upcoming Shimmer network."}
                                )

                            [type] => 1
                            [text] => Shimmer Genesis Staking
                            [symbol] => SMR
                            [numerator] => 1
                            [denominator] => 1000000
                            [requiredMinimumRewards] => 10000000
                            [additionalInfo] => Tracking the initial token distribution of the upcoming Shimmer network.
                        )

                    [additionalInfo] => The incentivized staging network to advance major innovations by IOTA. Whatever happens, happens - the future of Shimmer will be up to you. Learn, build, earn and grow together.
                )

            [status] => tanglePHP\SingleNodeClient\Api\v1\ResponseParticipationEvent Object
                (
                    [_input:protected] => tanglePHP\Core\Helper\JSON Object
                        (
                            [array] => Array
                                (
                                    [milestoneIndex] => 2879714
                                    [status] => ended
                                    [staking] => Array
                                        (
                                            [staked] => 1885509698991556
                                            [rewarded] => 1450910768336284
                                            [symbol] => SMR
                                        )

                                    [checksum] => ce2a345ece469615bc52990895e4eaecbc34adb98346fe5a60ddf8764dc5585c
                                )

                            [string:protected] => {"milestoneIndex":2879714,"status":"ended","staking":{"staked":1885509698991556,"rewarded":1450910768336284,"symbol":"SMR"},"checksum":"ce2a345ece469615bc52990895e4eaecbc34adb98346fe5a60ddf8764dc5585c"}
                        )

                    [milestoneIndex] => 2879714
                    [status] => ended
                    [staking] => tanglePHP\Core\Models\ResponseArray Object
                        (
                            [_input:protected] => tanglePHP\Core\Helper\JSON Object
                                (
                                    [array] => Array
                                        (
                                            [staked] => 1885509698991556
                                            [rewarded] => 1450910768336284
                                            [symbol] => SMR
                                        )

                                    [string:protected] => {"staked":1885509698991556,"rewarded":1450910768336284,"symbol":"SMR"}
                                )

                            [staked] => 1885509698991556
                            [rewarded] => 1450910768336284
                            [symbol] => SMR
                        )

                    [checksum] => ce2a345ece469615bc52990895e4eaecbc34adb98346fe5a60ddf8764dc5585c
                )

        )

)

*/