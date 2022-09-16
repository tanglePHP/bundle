<?php
  // include tanglePHP autoload from tanglePHP/bundle
  require_once("../../../autoload.php");

  // 4219 = Shimmer | 4218 = IOTA
  $coinType = 4219;

  // rms = Shimmer testnet | smr = Shimmer mainnnet | atoi = IOTA devnet | iota = IOTA mainnet
  $bech32Hrp = "rms";


  // create mnemonic random
  $mnemonic = tanglePHP\Core\Helper\Simplifier::createMnemonic();
  echo "Random Mnemonic: " . $mnemonic . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;

  // create ed25519Seed
  $ed25519Seed = new \tanglePHP\Core\Type\Ed25519Seed($mnemonic);
  echo "Ed25519Seed: " . $ed25519Seed . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;

  // create addressPath 0
  $addressPath0 = \tanglePHP\Core\Helper\Simplifier::createAddressPath($coinType, 0,0);
  echo "addressPath 0: " . $addressPath0 . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;


  // create addressSeed from addressPath
  $addressSeed0 = $ed25519Seed->generateSeedFromPath($addressPath0);
  echo "addressSeed: " . $addressSeed0 . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;

  // create final address 0
  $address0 = new \tanglePHP\Core\Type\Ed25519Address($addressSeed0->keyPair()->public);
  echo "address 0: " . $addressPath0 . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;


  // final addressBech32
  echo "addressBech32 0: " . $address0->toAddressBetch32($bech32Hrp) . PHP_EOL;
  echo "###################################################################################" . PHP_EOL;