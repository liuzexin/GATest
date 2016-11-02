<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/11/1
 * Time: 上午9:29
 */

echo strrchr('898989/html','89') . "\n";
echo strpos('4567', '8')?1:3 . "\n";

echo mb_substr('我爱你Aasss',1,3) . "\n";
 var_dump(mb_split('爱','我爱你'));

var_dump(substr_replace('我','abc',1,1));

$arr = [
    '1'=> '我爱你',
    'sort' =>'www',
    'liuzexin' => 'helitong',
    's' => 'helitong'
];

var_dump(array_slice($arr,1,2));


