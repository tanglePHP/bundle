<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  // create network connection to shimmer:testnet
  #$network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // create network connection to iota:devnet
  #$network = new \tanglePHP\Network\Connect('iota:devnet');

  // create network connection to dlt.green node pool (only Mainnet!)
  #$network = new \tanglePHP\Network\Connect('dlt.green:shimmer');
  #$network = new \tanglePHP\Network\Connect('dlt.green:iota');
  // create network connection to dlt.green node pool (shimmer:mainnet)
  $network = new \tanglePHP\Network\Connect();

  // create network connection to own node (IOTA)
  #$network = new \tanglePHP\Network\Connect('https://tanglephp.dlt.green');

  // create network connection to own node (Shimmer)
  #$network = new \tanglePHP\Network\Connect('https://tanglephp.dlt.builders');
  // or full path to api
  #$network = new \tanglePHP\Network\Connect('https://tanglephp.dlt.builders/api');

  // create network connection to shimmer:mainnet
  #$network = new \tanglePHP\Network\Connect('shimmer:mainnet');



  # output connect info
  print_r($network->getInfo());
  print_r($network->getENDPOINTUrls());

  /* Output example
   Array
    (
        [network] => shimmer
        [networkName] => testnet
        [networkId] => 8342982141227064571
        [protocolVersion] => 2
        [singleNodeName] => HORNET
        [singleNodeVersion] => 2.0.0-beta.8
        [singleNodeHealthy] => 1
        [features] => Array
            (
                [0] => pow
            )

        [baseToken] => SMR
        [coinType] => 4219
        [bech32Hrp] => rms
    )
   */
