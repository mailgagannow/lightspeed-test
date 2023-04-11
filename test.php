<?php
function get_lottery_picks($strings) {
    $lottery_picks = array();
    foreach ($strings as $string) {
        // Check that the string has exactly 7 digits
        if (strlen($string) < 7 || strlen($string)> 14) {
            continue;
        }
        
        // Check that the digits are unique and between 1 and 59
        $digits = str_split($string);
        if (count(array_unique($digits)) != 7 || array_filter($digits, function($d) { return ($d < 1 || $d > 59); })) {
            continue;
        }
        
        // Check that the digits are in increasing order
        $sorted_digits = $digits;
        sort($sorted_digits);
        if ($digits !== $sorted_digits) {
            continue;
        }
        
        // If all checks pass, add the lottery pick to the array
        $lottery_pick = implode(" ", $digits);
        $lottery_picks[$string] = $lottery_pick;
    }
    return $lottery_picks;
}

$strings = array("569815571556", "4938532894754", "1234567", "472844278465445");
$lottery_picks = get_lottery_picks($strings);
foreach ($lottery_picks as $key=>$value) {
    echo $key.'->'.$value . "\n";
}
