<?php

function prima($n){
  $lastPrime = 0;

  for($i=1;$i<=$n;$i++){  //numbers to be checked as prime

          $counter = 0;
          for($j=1;$j<=$i;$j++){ //all divisible factors


                if($i % $j==0){

                      $counter++;
                }
          }

        //prime requires 2 rules ( divisible by 1 and divisible by itself)
        if($counter==2){

               $lastPrime = $i;
        }
    }
    return $lastPrime;
}


$time_start = microtime(TRUE);
$prime = prima(5000);
$time_end = microtime(TRUE);
$time = $time_end - $time_start;
$msec=round($time*1000);

echo "calculated in $msec msec from ".$_SERVER['SERVER_ADDR'].", result is $prime";
//echo "calculated in \msec from ".$_SERVER['SERVER_ADDR'].", result is ".prima(10000);


?>

