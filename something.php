<?php
$a="hi";
$b="bye";
while ($a!=$b){
    echo $a." ".$b;
    echo "<br>";
    while (1){
        echo $b." ".$a;
        echo "<br>";
        while (1){
             echo $a." ".$b;
            echo "<br>";
            while (1){
                echo $b." ".$a;
                echo "<br>";
                break;
            }
            break;
        }
        break;
    }
    break;
}
