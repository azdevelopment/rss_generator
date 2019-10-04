<?php
/**
 * Interface IRssGenerator
 */

interface IRssGenerator
{
    /**
     * @param $name
     * @param $value
     * @return mixed
     */

    public function __set($name, $value);

    /**
     * @return string
     */

    public function xmlMake(): string;
}
