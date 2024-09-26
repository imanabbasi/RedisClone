<?php

require_once 'HashTableNode.php';

class HashTable
{
    public array $data = [];

    public int $size = 10;

    public function __construct($size = 0)
    {
        $size = (int) $size;
        if ($size > 0) {
            $this->size = $size;
        }
    }

    public function set($key, $value)
    {
        $i = $originalIndex = $this->getIndex($key);

        while (true) {
            if (! isset($this->data[$i]) || $key == $this->data[$i]->key) {
                $this->data[$i] = new HashTableNode($key, $value);
                break;
            }

            $i = (++$i % $this->size);

            if ($i == $originalIndex) {
                $this->makeBigger();

                return $this->set($key, $value);
            }
        }

        return $this;
    }

    public function get($key)
    {
        $i = $originalIndex = $this->getIndex($key);
        while (true) {
            if (! isset($this->data[$i])) {
                return null;
            }
            $node = $this->data[$i];
            if ($key == $node->key) {
                return $node->value;
            }

            $i = (++$i % $this->size);

            if ($i == $originalIndex) {
                return null;
            }
        }
    }

    private function getIndex($key)
    {
        return crc32($key) % $this->size;
    }

    private function makeBigger()
    {
        $old_size = $this->size;
        $this->size *= 2;
        $data = [];
        $collisions = [];

        for ($i = 0; $i < $old_size; $i++) {
            if (! empty($this->data[$i])) {
                $node = $this->data[$i];
                $j = $this->getIndex($node->key);

                if (isset($data[$j]) && $data[$j]->key != $node->key) {
                    $collisions[] = $node;
                } else {
                    $data[$j] = $node;
                }
            }
        }

        $this->data = $data;

        foreach ($collisions as $node) {
            $this->set($node->key, $node->value);
        }
    }
}