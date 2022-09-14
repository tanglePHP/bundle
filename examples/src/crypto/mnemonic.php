<?php
  // include tanglePHP autoload
  require_once("../../../autoload.php");

  // create mnemonic random
  $mnemonic = tanglePHP\Core\Helper\Simplifier::createMnemonic();
  echo "Random Mnemonic: " . $mnemonic . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;


  // create mnemonic with words
  $mnemonic = \tanglePHP\Core\Helper\Simplifier::reverseMnemonic('giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
  echo "mnemonic: " . $mnemonic . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;


  // check mnemonic Words
  $check = \tanglePHP\Core\Helper\Simplifier::checkMnemonic('dynamic giant museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
   // returns (bool)false
  var_dump($check);

