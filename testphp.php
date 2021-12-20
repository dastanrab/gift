<?php
$pattern ="/^09(0[1-2]|1[0-9]|3[0-9]|2[0-1])-?[0-9]{3}-?[0-9]{4}/";
if(preg_match($pattern,"09388985617")){
    echo("ok");

}else{
    echo("fail");
}
