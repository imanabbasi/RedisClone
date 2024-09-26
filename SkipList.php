<?php

require_once 'SkipListNode.php';

class SkipList
{
    private $head;

    private $maxLevel;

    private $p;

    public function __construct($p = 0.5)
    {
        $this->head = new SkipListNode(PHP_INT_MIN, null);
        $this->maxLevel = 0;
        $this->p = $p;
    }

    public function zadd($score, $member)
    {
        $levels = $this->randomLevel();

        $current = $this->head;
        $update = array_fill(0, $levels + 1, null);

        for ($i = $this->maxLevel; $i >= 0; $i--) {
            while ($current->next && $current->next->score < $score) {
                $current = $current->next;
            }

            $update[$i] = $current;

            if ($i <= $levels) {
                if (! $current->below) {
                    $current->below = new SkipListNode(PHP_INT_MIN, PHP_INT_MIN);
                }

                $current = $current->below;
            }
        }

        $new = new SkipListNode($score, $member);
        $new->below = $current->next;

        for ($i = 0; $i <= $levels; $i++) {
            if ($update[$i] !== null) {
                $new->next = $update[$i]->next;
                $update[$i]->next = $new;
            }
        }

        if ($levels > $this->maxLevel) {
            $this->maxLevel = $levels;
        }
    }

    public function zrank($member)
    {
        $rank = 0;
        $current = $this->head->next;

        while ($current) {
            if ($current->value == $member) {
                return $rank;
            }

            $rank++;
            $current = $current->next;
        }

        return -1;
    }

    public function zscore($member)
    {
        $current = $this->head->next;

        while ($current) {
            if ($current->value == $member) {
                return $current->score;
            }

            $current = $current->next;
        }

        return null;
    }

    public function zrange($start, $stop, $withscores = false)
    {
        $result = [];
        $current = $this->head->next;
        $index = 0;

        while ($current && $index <= $stop) {
            if ($index >= $start && $index < $stop) {
                if ($withscores) {
                    $result[] = [$current->value, $current->score];
                } else {
                    $result[] = $current->value;
                }
            }

            $current = $current->next;
            $index++;
        }

        return $result;
    }

    private function randomLevel()
    {
        $level = 0;
        while (mt_rand() / mt_getrandmax() < $this->p) {
            $level++;
        }

        return $level;
    }
}