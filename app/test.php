<?php

function printer (int $input, array $chars, string $separator = '/'): string {
    $baseStr = '';

    $len = count($chars);

    if ($len > $input) {
        throw new \Exception('Error: Chars > Input');
    }

    for ($i = 0; $i < $input; $i++) {
        $j = $i + 1;

        for ($indexChar = 0; $j != 0; $indexChar++) {

            if ($indexChar > ($len - 1)) {
                $indexChar = 0;
            }

            $baseStr .= $chars[$indexChar];

            if (($j - 1) != 0) {
                $baseStr .= $separator;
            }

            $j--;
        }

        if ($i != ($input - 1)) {
            $baseStr .= "\n";
        }
    }

    return $baseStr;
}

$str = printer(64, ['*', '#', '@']);


echo $str;
