<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");


  use tanglePHP\Network\Connect;
  use tanglePHP\SingleNodeClient\Action\getBalance;

  // create network connection
  $network = new Connect('iota:mainnet');

  echo $ret = $network->singleNode->addressOutput("iota1qz2s9rpjnfgd09u7yh2vvjyp5vvk79ncf8c36uc8eapxy99s50hzum4xek0");

    echo PHP_EOL;

  foreach($ret->outputIds as $outputId) {

    $output = $network->singleNode->output($outputId);

    var_dump($output);

   // $message = $network->singleNode->v1->messageMetadata($output->messageId);

  }
