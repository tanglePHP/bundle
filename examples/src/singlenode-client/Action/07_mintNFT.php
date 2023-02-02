<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\mintNFT;

  // create network connection
  $network = new Connect('shimmer:testnet');
  // loading mnemonic
  $mnemonic = require_once("../../../.assets/createMnemonic.php");
  // mint NFT
  echo $ret = (new mintNFT($network->singleNode))->seedInput($mnemonic)
                                                 //->toAddress('rms1qpds88ncc28t8cqsaw6ej03ppm79ckshv72snydgw08qeehtz7jxcz6pw2d')
                                                 ->metadata("This is where the immutable NFT metadata goes")
                                                 //->metadataImmutable("This is where the immutable NFT metadata goes")
                                                 ->metadataMutable("This is where the mutable NFT metadata goes")
                                                 ->run();
  // print single information
  echo PHP_EOL;
  echo "explorerUrl: " . $ret->explorerUrl . PHP_EOL;
  echo "blockId: " . $ret->blockId . PHP_EOL;
  echo "check: " . $ret->check . PHP_EOL;
  echo "metadata: " . $ret->metadata . PHP_EOL;
  // print network informations
  echo "networkInfo: " . $ret->networkInfo . PHP_EOL;
  