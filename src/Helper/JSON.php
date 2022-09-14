<?php namespace tanglePHP\Core\Helper;

use ArrayAccess;
use tanglePHP\Core\Exception\Helper as HelperException;

/**
 * Class JSON
 *
 * @package      tanglePHP\Core\Helper
 * @author       Stefan Braun <stefan.braun@tanglePHP.com>
 * @copyright    Copyright (c) 2022, StefanBraun
 * @version      2022.08.31-1651
 */
final class JSON implements ArrayAccess {
  /**
   * @var array
   */
  public array $array;

  /**
   * JSON constructor.
   *
   * @param string $string
   *
   * @throws HelperException
   */
  public function __construct(protected string $string) {
    if(!Converter::isJSON($this->string)) {
      throw new HelperException("String have to be in JSON format");
    }
    $this->array = $this->decode(true);
  }

  /**
   * @param $offset
   * @param $value
   *
   * @return void
   */
  public function offsetSet($offset, $value): void {
    if(is_null($offset)) {
      $this->array[] = $value;
    }
    else {
      $this->array[$offset] = $value;
    }
  }

  /**
   * @param $offset
   *
   * @return bool
   */
  public function offsetExists($offset): bool {
    return isset($this->array[$offset]);
  }

  /**
   * @param $offset
   *
   * @return void
   */
  public function offsetUnset($offset): void {
    unset($this->array[$offset]);
  }

  /**
   * @param $offset
   *
   * @return mixed
   */
  public function offsetGet($offset): mixed {
    return $this->array[$offset] ?? null;
  }

  /**
   * @param mixed $value
   * @param int   $flags
   * @param int   $depth
   *
   * @return JSON
   * @throws HelperException
   */
  static public function create(mixed $value, int $flags = 0, int $depth = 512): JSON {
    if($value instanceof JSON) {
      return $value;
    }
    if(is_string($value) && Converter::isJSON($value)) {
      return new JSON($value);
    }
    if(is_string($value)) {
      return new JSON('{"JSON":"' . $value . '"}');
    }

    return new JSON(json_encode($value, $flags, $depth));
  }

  /**
   * @param bool|null $associative
   * @param int       $depth
   * @param int       $flags
   *
   * @return mixed
   */
  private function decode(?bool $associative = false, int $depth = 512, int $flags = 0): mixed {
    return json_decode($this->string, $associative, $depth, $flags);
  }

  /**
   * @param int $flags
   * @param int $depth
   *
   * @return string
   */
  public function encode(int $flags = 0, int $depth = 512): string {
    return json_encode($this->array, $flags, $depth);
  }

  /**
   * @return array
   */
  public function __toArray(): array {
    return $this->array;
  }

  /**
   * @return string
   */
  public function __toString(): string {
    return $this->encode();
  }

  /**
   * @param string $name
   *
   * @return mixed
   */
  public function __get(string $name): mixed {
    return $this->array[$name] ?? 'Undefined property';
  }
}