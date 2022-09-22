<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../../autoload.php");

  // create network connection
  $network = new \tanglePHP\Network\Connect('iota:devnet');

  // print result
  echo $ret = $network->singleNode->addressOutput('atoi1qrnhxtx78lg577jrffd5y6scv9lxj8maelmvrq2whsjnplr0llp3ucyd3rm');
