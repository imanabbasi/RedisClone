<?php

require 'SimpleValue.php';
require 'HashTable.php';
require 'SkipList.php';

class RedisClone
{
    public array $data = [];

    public function getData()
    {
        return $this->data;
    }

    public function clearData()
    {
        $this->data = [];
    }

    public function set($key, $value)
    {
        $this->data = $this->setWithData($key, $value, $this->getData());
    }

    private function setWithData($key, $value, $data = [])
    {
        if (strlen($key) == 1) {
            if (
                ! array_key_exists($key, $data) ||
                ! array_key_exists('_value', $data[$key])
            ) {
                $data[$key]['_value'] = new SimpleValue();
            }

            $data[$key]['_value']->set($value);
        } else {
            $character = substr($key, 0, 1);
            $parent = substr($key, 1);
            $data[$character] = $this->setWithData($parent, $value, $data[$character] ?? []);
        }

        return $data;
    }

    public function get($key, $default = null)
    {
        return $this->getWithData($key, $this->getData()) ?? $default;
    }

    private function getWithData($key, $data = [])
    {
        if (strlen($key) == 1) {
            if (
                ! array_key_exists($key, $data) ||
                ! array_key_exists('_value', $data[$key])
            ) {
                return null;
            }

            $simpleValue = $data[$key]['_value'];

            return $simpleValue->get();
        } else {
            $character = substr($key, 0, 1);

            if (! array_key_exists($character, $data)) {
                return null;
            }

            $parent = substr($key, 1);
            $data = $this->getWithData($parent, $data[$character]);
        }

        return $data;
    }

    public function hset($key, $hashtableKey, $value)
    {
        $this->data = $this->hsetWithData($key, $hashtableKey, $value, $this->getData());
    }

    private function hsetWithData($key, $hashtableKey, $value, $data = [])
    {
        if (strlen($key) == 1) {
            if (
                ! array_key_exists($key, $data) ||
                ! array_key_exists('_value', $data[$key])
            ) {
                $data[$key]['_value'] = new HashTable();
            }

            $data[$key]['_value']->set($hashtableKey, $value);
        } else {
            $character = substr($key, 0, 1);
            $parent = substr($key, 1);
            $data[$character] = $this->hsetWithData($parent, $hashtableKey, $value, $data[$character] ?? []);
        }

        return $data;
    }

    public function hget($key, $hashtableKey, $default = null)
    {
        return $this->hgetWithData($key, $hashtableKey, $this->getData()) ?? $default;
    }

    private function hgetWithData($key, $hashtableKey, $data = [])
    {
        if (strlen($key) == 1) {
            if (
                ! array_key_exists($key, $data) ||
                ! array_key_exists('_value', $data[$key])
            ) {
                return null;
            }

            $hashTable = $data[$key]['_value'];

            return $hashTable->get($hashtableKey);
        } else {
            $character = substr($key, 0, 1);

            if (! array_key_exists($character, $data)) {
                return null;
            }

            $parent = substr($key, 1);
            $data = $this->hgetWithData($parent, $hashtableKey, $data[$character]);
        }

        return $data;
    }

    public function zadd($key, $score, $value)
    {
        $this->data = $this->zaddWithData($key, $score, $value, $this->getData());
    }

    private function zaddWithData($key, $score, $value, $data = [])
    {
        if (strlen($key) == 1) {
            if (
                ! array_key_exists($key, $data) ||
                ! array_key_exists('_value', $data[$key])
            ) {
                $data[$key]['_value'] = new SkipList();
            }

            $data[$key]['_value']->zadd($score, $value);
        } else {
            $character = substr($key, 0, 1);
            $parent = substr($key, 1);
            $data[$character] = $this->zaddWithData($parent, $score, $value, $data[$character] ?? []);
        }

        return $data;
    }

    public function zscore($key, $value)
    {
        return $this->zscoreWithData($key, $value, $this->getData());
    }

    private function zscoreWithData($key, $value, $data = [])
    {
        if (strlen($key) == 1) {
            if (
                ! array_key_exists($key, $data) ||
                ! array_key_exists('_value', $data[$key])
            ) {
                return null;
            }

            $skipList = $data[$key]['_value'];

            return $skipList->zscore($value);
        } else {
            $character = substr($key, 0, 1);

            if (! array_key_exists($character, $data)) {
                return null;
            }

            $parent = substr($key, 1);
            $data = $this->zscoreWithData($parent, $value, $data[$character]);
        }

        return $data;
    }

    public function zrank($key, $value)
    {
        return $this->zrankWithData($key, $value, $this->getData());
    }

    private function zrankWithData($key, $value, $data = [])
    {
        if (strlen($key) == 1) {
            if (
                ! array_key_exists($key, $data) ||
                ! array_key_exists('_value', $data[$key])
            ) {
                return null;
            }

            $skipList = $data[$key]['_value'];

            return $skipList->zrank($value);
        } else {
            $character = substr($key, 0, 1);

            if (! array_key_exists($character, $data)) {
                return null;
            }

            $parent = substr($key, 1);
            $data = $this->zrankWithData($parent, $value, $data[$character]);
        }

        return $data;
    }

    public function zrange($key, $start, $end, $withScore = false)
    {
        return $this->zrangeWithData($key, $start, $end, $withScore, $this->getData());
    }

    private function zrangeWithData($key, $start, $end, $withScore, $data = [])
    {
        if (strlen($key) == 1) {
            if (
                ! array_key_exists($key, $data) ||
                ! array_key_exists('_value', $data[$key])
            ) {
                return null;
            }

            $skipList = $data[$key]['_value'];

            return $skipList->zrange($start, $end, $withScore);
        } else {
            $character = substr($key, 0, 1);

            if (! array_key_exists($character, $data)) {
                return null;
            }

            $parent = substr($key, 1);
            $data = $this->zrangeWithData($parent, $start, $end, $withScore, $data[$character]);
        }

        return $data;
    }
}