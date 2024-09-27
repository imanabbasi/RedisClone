# Redis Clone

## How to use

```php
$redisClone = new RedisClone();

// Get Data
$redisClone->getData();

// Clear Data
$redisClone->clearData();

// Set
$redisClone->set('smile', 1);
$redisClone->set('sad', 2);
$redisClone->set('hello', 3);

// Get
$redisClone->get('smile'); // return 1
$redisClone->get('sad'); // return 2
$redisClone->get('goodbye'); // return NULL, not exist
$redisClone->get('goodbye', 'default'); // return 'default', you can set default value

// Hset
$redisClone->hset('mood', 'smile', 1);
$redisClone->hset('mood', 'sad', 2);
$redisClone->hset('mood', 'hello', 3);

//Hget
$redisClone->hget('mood', 'smile'); // return 1
$redisClone->hget('mood', 'sad'); // return 2
$redisClone->hget('mood', 'goodbye'); // return NULL, not exist
$redisClone->hget('mood', 'goodbye', 'default'); // return 'default', you can set default value

// Zadd
$redisClone->zadd('fruits', 10, 'apple');
$redisClone->zadd('fruits', 5, 'banana');
$redisClone->zadd('fruits', 15, 'cherry');

// Zscore
$redisClone->zscore('fruits', 'apple'); // return 10
$redisClone->zscore('fruits', 'banana'); // return 5
$redisClone->zscore('fruits', 'cherry'); // return 15
$redisClone->zscore('fruits', 'orange'); // return NULL, not exist

// Zrank
$redisClone->zrank('fruits', 'apple'); // return 1
$redisClone->zrank('fruits', 'banana'); // return 0
$redisClone->zrank('fruits', 'cherry'); // return 2
$redisClone->zrank('fruits', 'orange'); // return -1, not exist

// Zrange
$redisClone->zrange('fruits', 0, 1); // return ["banana"]
$redisClone->zrange('fruits', 0, 1, true); // return [["banana",5]]
$redisClone->zrange('fruits', 0, 2); // return ["banana","apple"]
$redisClone->zrange('fruits', 0, 2, true); // return [["banana",5],["apple",10]]
$redisClone->zrange('fruits', 1, 2); // return ["apple"]
$redisClone->zrange('fruits', 1, 2, true); // return [["apple",10]]
```

## How to use HashTable standalone

```php
$hashTable = new HashTable();

// Set
$hashTable->set('smile', 1);
$hashTable->set('sad', 2);
$hashTable->set('ski', 3);

// Get
$hashTable->get('smile'); // return 1
$hashTable->get('sad'); // return 2
$hashTable->get('ski'); // return 3
$hashTable->get('hello'); // return NULL, not exist
```

## How to use SkipList standalone

```php
$skipList = new SkipList();

// Zadd
$skipList->zadd(10, 'apple');
$skipList->zadd(5, 'banana');
$skipList->zadd(15, 'cherry');

// Zscore
$skipList->zscore('apple'); // return 10
$skipList->zscore('banana'); // return 5
$skipList->zscore('cherry'); // return 15
$skipList->zscore('orange'); // return NULL, not exist

// Zrank
$skipList->zrank('apple'); // return 1
$skipList->zrank('banana'); // return 0
$skipList->zrank('cherry'); // return 2
$skipList->zrank('orange'); // return -1, not exist

// Zrange
$skipList->zrange(0, 1); // return ["banana"]
$skipList->zrange(0, 1, true); // return [["banana",5]]
$skipList->zrange(0, 2); // return ["banana","apple"]
$skipList->zrange(0, 2, true); // return [["banana",5],["apple",10]]
$skipList->zrange(1, 2); // return ["apple"]
$skipList->zrange(1, 2, true); // return [["apple",10]]
```