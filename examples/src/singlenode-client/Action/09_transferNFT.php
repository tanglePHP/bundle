<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\transferNFT;

  // create network connection
  $network = new Connect('shimmer:testnet');
  // loading mnemonic
  $mnemonic = require_once("../../../.assets/createMnemonic.php");
  // transfer NFT
  echo $ret = (new transferNFT($network->singleNode))->seedInput($mnemonic)
                                                     ->accountIndex(0)
                                                     ->addressIndex(0)
                                                     ->nftId('d63a4a3b7d080a5f9f2bfdd83e62a8b90f287977ff1c1cb10ae34d857630c1a0')
                                                     ->toAddress('rms1qr2xsmt3v3eyp2ja80wd2sq8xx0fslefmxguf7tshzezzr5qsctzc2f5dg6')
                                                     ->run();
  // print single information
  echo PHP_EOL;
  echo "explorerUrl: " . $ret->explorerUrl . PHP_EOL;
  echo "blockId: " . $ret->blockId . PHP_EOL;
  echo "check: " . $ret->check . PHP_EOL;
  echo "metadata: " . $ret->metadata . PHP_EOL;
  // print network informations
  echo "networkInfo: " . $ret->networkInfo . PHP_EOL;