<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('shimmer:testnet');

  // print result
  echo $ret = $network->singleNode->addressOutput('rms1qp8cy2ydkt20r58prentfw053xhalh5pk2k229wsc5pn3d23w9yzweynmkt');
