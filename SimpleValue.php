<?php

class SimpleValue
{
    private $value;

    public function set($value)
    {
        $this->value = $value;
    }

    public function get()
    {
        return $this->value;
    }
}