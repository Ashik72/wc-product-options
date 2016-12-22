<?php 


$pay_struct = "pay_struct_3_30_5";

$pay_struct = explode("_", $pay_struct);

$pay_intervals_days_amount[0] = (!empty( (int) $pay_struct[2]) ? (int) $pay_struct[2] : die());
$pay_intervals_days_amount[1] = (!empty( (int) $pay_struct[3]) ? (int) $pay_struct[3] : '');
$pay_intervals_days_amount[2] = (!empty( (float) $pay_struct[4]) ? (float) $pay_struct[4] : '');

var_dump($pay_intervals_days_amount);

var_dump(date('l jS \of F Y h:i:s A', 1477250021));

?>

