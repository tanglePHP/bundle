<?php
  // create mnemonic random
  #$mnemonic = tanglePHP\Core\Helper\Simplifier::createMnemonic();
  // create mnemonic with Words
  # $mnemonic = new \tanglePHP\Core\Crypto\Mnemonic('giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
  # $mnemonic = \tanglePHP\Core\Helper\Simplifier::reverseMnemonic('giant dynamic museum toddler six deny defense ostrich bomb access mercy blood explain muscle shoot shallow glad autumn author calm heavy hawk abuse rally');
  $mnemonic = \tanglePHP\Core\Helper\Simplifier::reverseMnemonic('garbage caution genius label cube joy animal merry comfort lobster wrong picnic brain below across question miracle series doll income used pet patrol final');

  echo "mnemonic: " . $mnemonic . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;

  return $mnemonic;