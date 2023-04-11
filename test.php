<?php
function get_lottery_picks($inputStr)
{
    $totalUniqueDigit = 7;
    $minLen = $totalUniqueDigit * 1;
    $maxLen = $totalUniqueDigit * 2;
    $minLottoValue = 1;
    $maxLottoValue = 59;

    $doubleDigitFound = 0;
    $flag = true;

    $inputLen = strlen($inputStr);
    $minDoubleDigit = $inputLen - $minLen;

    if ($inputLen < $minLen || $inputLen > $maxLen)
    {
        return null;
    }

    $l = array_map('intval', str_split($inputStr));

    if ($inputLen == $minLen)
    {
        // check for 0 or duplicates
        if (!in_array(0, $l) && count($l) == count(array_unique($l)))
        {
            return $l;
        }
        else
        {
            return null;
        }
    }

    $lottery = array();
    // skip iteration before a digit is previously used as double digit number
    $skip = false;

    for ($i = 0;$i < $inputLen;$i++)
    {
        if ($skip == true)
        {
            $skip = false;
            continue;
        }

        // target is reached
        if (count($lottery) == $totalUniqueDigit && $i == $inputLen)
        {
            break;
        }

        // illegal characters, cannot have zero
        if ($l[$i] == 0)
        {
            $flag = false;
            break;
        }

        // valid numbers from 1 to 59
        if ($l[$i] >= 6)
        {
            // first digit is 6 or greater, cannot be double digit
            if (!in_array($l[$i], $lottery))
            {
                array_push($lottery, $l[$i]);
            }
            else
            {
                $flag = false;
                break;
            }
        }
        elseif ($i + 1 < $inputLen)
        {
            // double digit number
            $n = $l[$i] * 10 + $l[$i + 1];
            if ($n >= $minLottoValue && $n <= $maxLottoValue && !in_array($n, $lottery) && $doubleDigitFound < $minDoubleDigit)
            {
                array_push($lottery, $n);
                $doubleDigitFound += 1;
                $skip = true;
            }
            else
            {   
                if (!in_array($l[$i], $lottery))
                {
                    array_push($lottery, $l[$i]);
                }
            }
        }
        else
        {
            if (!in_array($l[$i], $lottery))
            {
                array_push($lottery, $l[$i]);
            }
        }
    }
    if ($flag == true and count($lottery) == $totalUniqueDigit)
    {
        return $lottery;

    }
    else
    {
        return null;
    }

}
$strings = array(
    "569815571556",
    "4938532894754",
    "1234567",
    "472844278465445"
);
foreach ($strings as $value)
{
    $result = get_lottery_picks($value);
    if (!empty($result))
    {
        echo $value . '->' . implode(" ", $result) . "\n";

    }

}

?>
