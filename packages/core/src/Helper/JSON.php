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
   * Offset to set
   *
   * @link https://php.net/manual/en/arrayaccess.offsetset.php
   *
   * @param mixed $offset <p>
   *                      The offset to assign the value to.
   *                      </p>
   * @param mixed $value  <p>
   *                      The value to set.
   *                      </p>
   *
   * @return void
   */
  public function offsetSet(mixed $offset, mixed $value): void {
    if(is_null($offset)) {
      $this->array[] = $value;
    }
    else {
      $this->array[$offset] = $value;
    }
  }

  /**
   * Whether a offset exists
   *
   * @link https://php.net/manual/en/arrayaccess.offsetexists.php
   *
   * @param mixed $offset <p>
   *                      An offset to check for.
   *                      </p>
   *
   * @return bool true on success or false on failure.
   * </p>
   * <p>
   * The return value will be casted to boolean if non-boolean was returned.
   */
  public function offsetExists(mixed $offset): bool {
    return isset($this->array[$offset]);
  }

  /**
   * Offset to unset
   *
   * @link https://php.net/manual/en/arrayaccess.offsetunset.php
   *
   * @param mixed $offset <p>
   *                      The offset to unset.
   *                      </p>
   *
   * @return void
   */
  public function offsetUnset(mixed $offset): void {
    unset($this->array[$offset]);
  }

  /**
   * Offset to retrieve
   *
   * @link https://php.net/manual/en/arrayaccess.offsetget.php
   *
   * @param mixed $offset <p>
   *                      The offset to retrieve.
   *                      </p>
   *
   * @return mixed Can return all value types.
   */
  public function offsetGet(mixed $offset): mixed {
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