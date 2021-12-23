
<?php

if(isset($_REQUEST['inputurl']) && $_REQUEST['inputurl']!="") {

    $file = $_REQUEST['inputurl'];
    $result=file_get_contents($file);
    $i=0;
    $pos=array();
    while($i<strlen($result)){
        if (strlen($result)-$i<13){
            break;
        }
        else{
            if ($result[$i]=='d' and $result[$i+1]=='o' and $result[$i+2]=='w' and $result[$i+3]=='n'and $result[$i+4]=='l' and $result[$i+5]=='o' and $result[$i+6]=='a' and $result[$i+7]=='d' and $result[$i+8]=='M' and $result[$i+9]=='o' and $result[$i+10]=='d' and $result[$i+11]=='a' and $result[$i+12]=='l'){
                $pos[] = $i;
                $i++;
            }
            else{
                $i++;
            }
        }

    }
    $string=substr($result,$pos[1]);
    $new_pos=strpos($string,'rounded-pill');
    $href=substr($string,$new_pos);
    $url_pos=strpos($href,'href');
    $href=substr($href,$url_pos);
    $x=0;
    $url="";
    while($x<strlen($href)){
        if ($href[$x]=='"'){
            while ($x<strlen($href)){
                if ($href[$x+1]=='"'){
                    break;
                }
                else{
                    if ($href[$x+1]!='"'){
                        $url.=$href[$x+1];
                        $x++;
                    }
                    else{
                        break;
                    }

                }
            }
            if ($url_pos=strpos($url,'mp3')!=0){ break;}


        }
        else{
            $x++;
        }
    }
   // header('Content-Type: audio/mpeg');
   // header("Content-Disposition: attachment; filename=test.mp3");
   // readfile('1.mp3');
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();


}

?>

<form name="from" method="post" action="">
    <input name="inputurl" type="text" id="inputurl"  value="" />
    <input type="submit" name="Button1" value="دریافت اهنگ" id="Button1" />
</form>


