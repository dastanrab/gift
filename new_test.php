<?php
class back_up{
    public string $first='hi';
    public string $two='bye';
    public array $steps;
  public function __construct()
  {
      $this->steps=[1=>'first',2=>'two'];
  }

    /**
     * @param string $first
     */
    public function setFirst(string $first,int $step=0)
    {
        $this->first .= $first;
        if ($step!=0){
            $name=$this->steps[$step];
            $this->$name=$this->$name.$first;
        }
        return $this;
    }
    public function push(string $add){
        $this->steps[count($this->steps)+1]=$add;
        $this->$add=$add;
        return $this;
    }
}
$test=new back_up();
$test->setFirst(' !',2);
print_r($test->two);
