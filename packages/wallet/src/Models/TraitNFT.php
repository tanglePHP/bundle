<?php namespace tanglePHP\Wallet\Models;

use tanglePHP\Core\Models\AbstractAmount;
use tanglePHP\SingleNodeClient\Action\getNFT;
use tanglePHP\SingleNodeClient\Action\mintNFT;
use tanglePHP\SingleNodeClient\Action\transferNFT;
use tanglePHP\SingleNodeClient\Action\burnNFT;
use tanglePHP\Core\Helper\JSON;
use tanglePHP\Core\Exception\Converter as ExceptionConverter;
use tanglePHP\Core\Exception\Crypto as ExceptionCrypto;
use tanglePHP\Core\Exception\Helper as ExceptionHelper;
use tanglePHP\Core\Exception\Type as ExceptionType;
use tanglePHP\Core\Exception\Api as ExceptionApi;
use SodiumException;
use tanglePHP\SingleNodeClient\Api\v2\Response\Error;
use tanglePHP\SingleNodeClient\Models\ReturnSubmitBlock;

/**
 * Trait TraitNFT
 *
 * @package      tanglePHP\Wallet\Models
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.10.06-2050
 */
trait TraitNFT {
  /**
   * @return JSON
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   * @throws SodiumException
   */
  public function getNFTs(): JSON {
    return (new getNFT($this->wallet->client))->address($this->address->toAddressBetch32($this->wallet->bech32HRP))
                                              ->run();
  }

  /**
   * @param string $blockId
   *
   * @return false|string
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionHelper
   * @throws SodiumException
   */
  public function getNftIdFromBlockId(string $blockId): false|string {
    $ret = $this->getNFTs();
    // Find nftId from mintedNft
    foreach($ret['nfts'] as $nft) {
      if($nft['blockId'] == $blockId) {
        return $nft['nftId'];
      }
    }

    return false;
  }

  /**
   * @param int|string|AbstractAmount $amount
   * @param string|array|null         $data
   * @param string|null               $toAddress
   * @param bool                      $checkTransaction
   *
   * @return ReturnSubmitBlock|Error
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function mintNft(int|string|AbstractAmount $amount, null|string|array $data = null, ?string $toAddress = null, bool $checkTransaction = true): ReturnSubmitBlock|Error {
    $mintNFT = (new mintNFT($this->wallet->client));
    //
    $mintNFT->amount($amount)
            ->seedInput($this->wallet->getSeed())
            ->accountIndex((int)$this->path->getAccountIndex())
            ->addressIndex((int)$this->path->getAddressIndex())
            ->setting(['checkTransaction' => $checkTransaction])
            ->toAddress($toAddress);
    //
    if($data) {
      $mintNFT->metadata($data);
    }

    return $mintNFT->run();
  }

  /**
   * @param string $nftId
   * @param bool   $checkTransaction
   *
   * @return ReturnSubmitBlock|Error
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function burnNft(string $nftId, bool $checkTransaction = true): ReturnSubmitBlock|Error {
    return (new burnNFT($this->wallet->client))->seedInput($this->wallet->getSeed())
                                               ->accountIndex((int)$this->path->getAccountIndex())
                                               ->addressIndex((int)$this->path->getAddressIndex())
                                               ->nftId($nftId)
                                               ->setting(['checkTransaction' => $checkTransaction])
                                               ->run();
  }

  /**
   * @param string $nftId
   * @param string $toAddress
   * @param bool   $checkTransaction
   *
   * @return ReturnSubmitBlock|Error
   * @throws ExceptionApi
   * @throws ExceptionConverter
   * @throws ExceptionCrypto
   * @throws ExceptionHelper
   * @throws ExceptionType
   * @throws SodiumException
   */
  public function transferNft(string $nftId, string $toAddress, bool $checkTransaction = true): ReturnSubmitBlock|Error {
    return (new transferNFT($this->wallet->client))->seedInput($this->wallet->getSeed())
                                                   ->accountIndex((int)$this->path->getAccountIndex())
                                                   ->addressIndex((int)$this->path->getAddressIndex())
                                                   ->nftId($nftId)
                                                   ->toAddress($toAddress)
                                                   ->setting(['checkTransaction' => $checkTransaction])
                                                   ->run();
  }
}