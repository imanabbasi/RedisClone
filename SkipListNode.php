<?php

class SkipListNode
{
    public $score;

    public $value;

    public $next;

    public $below;

    public function __construct($score, $value)
    {
        $this->score = $score;
        $this->value = $value;
    }
}