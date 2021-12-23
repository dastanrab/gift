<?php
class call_test{
    public string $s;
    public function __construct(string $s)
    {
        $this->s=$s;
    }
    public function __call($name, $arguments)
    {
        print_r($arguments[1]($arguments[2])) ;
    }
}
$t=new call_test('hello');
$request='mr dastan rab';
$t->dastan('/dastan',function ($request){
    echo 'hello'." ".$request;
},$request);
