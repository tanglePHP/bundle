<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\getNFT;

  // create network connection
  $network = new Connect('shimmer:testnet');
  // get NFTs with addressbech32
  $ret = (new getNFT($network->singleNode))->address('rms1qzaye2z3ufn5lpaa090s7wvw96ygdadl5ck9h9cq0wly2prg8fn2znuzced')
                                           ->run();
  // print result
  echo "NFT found: " . $ret['count'] . PHP_EOL;
  print_r($ret['nfts']);