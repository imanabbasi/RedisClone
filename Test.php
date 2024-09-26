<?php
require_once 'RedisClone.php';

$redis = new RedisClone();

$redis->set('smile', 1);
$redis->set('sad', 2);
$redis->set('hello', 3);

print_r("Data: ");
print_r($redis->getData());

echo "Get smile: ".$redis->get('smile')."\n";
echo "Get sad: ".$redis->get('sad')."\n";
echo "Get goodbye: ".$redis->get('goodbye')."\n";
echo "Get goodbye with default 4: ".$redis->get('goodbye', 4)."\n";

$redis->hset('mood', 'smile', 1);
$redis->hset('mood', 'sad', 2);
$redis->hset('mood', 'hello', 3);

print_r("Data: ");
print_r($redis->getData());

echo "HGET for mood key and smile hashtable key: ".$redis->hget('mood', 'smile')."\n";
echo "HGET for mood key and sad hashtable key: ".$redis->hget('mood', 'sad')."\n";
echo "HGET for mood key and sad goodbye key: ".$redis->hget('mood', 'goodbye')."\n";
echo "HGET for mood key and sad goodbye key with default 4: ".$redis->hget('mood', 'goodbye', 4)."\n";

$redis->zadd('fruits', 10, 'apple');
$redis->zadd('fruits', 5, 'banana');
$redis->zadd('fruits', 15, 'cherry');

print_r("Data: ");
print_r($redis->getData());

echo "apple score: ".$redis->zscore('fruits', 'apple')."\n";
echo "banana score: ".$redis->zscore('fruits', 'banana')."\n";
echo "cherry score: ".$redis->zscore('fruits', 'cherry')."\n";
echo "orange score: ".$redis->zscore('fruits', 'orange')."\n";

echo "apple rank: ".$redis->zrank('fruits', 'apple')."\n";
echo "banana rank: ".$redis->zrank('fruits', 'banana')."\n";
echo "cherry rank: ".$redis->zrank('fruits', 'cherry')."\n";
echo "orange rank: ".$redis->zrank('fruits', 'orange')."\n";

echo "range 0, 1: ".json_encode($redis->zrange('fruits', 0, 1))."\n";
echo "range 0, 1 With Score: ".json_encode($redis->zrange('fruits', 0, 1, true))."\n";
echo "range 0, 2: ".json_encode($redis->zrange('fruits', 0, 2))."\n";
echo "range 0, 2 With Score: ".json_encode($redis->zrange('fruits', 0, 2, true))."\n";
echo "range 1, 2: ".json_encode($redis->zrange('fruits', 1, 2))."\n";
echo "range 1, 2 With Score: ".json_encode($redis->zrange('fruits', 1, 2, true))."\n";