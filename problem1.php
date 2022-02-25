<?php
$a=2;
$b=$a;
$b+=1;
$c=&$a;
$c=4;
echo $a;
echo $b;
echo $c;
//
class A {
    public $name;
    function __construct($name){
        $this->name=$name;
    }
    function sum($num1,$num2){
        return $num1+$num2;
    }
}
// Using call method
$hello = function() {
    return "Hello " . $this->name;
};
$data=[1,2];
$sum = function () use ($data){
    return $this->sum($data[0],$data[1]);
};
echo $sum->call(new A('salman'))
?>
