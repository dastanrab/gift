<?php

function partition(&$array, $left, $right) {
    $pivotIndex = floor($left + ($right - $left) / 2);
    $pivotValue = $array[$pivotIndex];
    $i=$left;
    $j=$right;
    while ($i <= $j) {
        while (($array[$i] < $pivotValue) ) {
            $i++;
        }
        while (($array[$j] > $pivotValue)) {
            $j--;
        }
        if ($i <= $j ) {
            $temp = $array[$i];
            $array[$i] = $array[$j];
            $array[$j] = $temp;
            $i++;
            $j--;
        }
    }
    return $i;
}
function quicksort(&$array, $left, $right) {
    if($left < $right) {
        $pivotIndex = partition($array, $left, $right);
        quicksort($array,$left,$pivotIndex -1 );
        quicksort($array,$pivotIndex, $right);
    }
}
$array=[20,5,9,1,2,33,8];
echo "before \r\n";
foreach($array as $value) {
    echo $value . "\r\n";
}
echo "\r\n\r\n";
echo "after \r\n";
quicksort($array, 0,count($array) -1);
foreach($array as $value) {
    echo $value . "\r\n";
}
