<?php

$str='他希望本國奧委會可以重新考慮把空手道重新列入項目';

$chrArray = preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);

// print_r($chrArray);
shuffle($chrArray);//隨機排敘

$ar=array_slice($chrArray,0,3);//取前面三個元素

echo implode('',$ar); //用空字串接起來三個字
