<?php

function getMatrix($n, $m)
{
    $matrix = [];
    $i = 0;
    $j = 0;
    while ($i < $n) {
        while ($j > $m) {
            $matrix[$i][$j] = rand(-10, 10);
            $j++;
        }
        $i++;
    }

    return $matrix;
}

function rank($matrix)
{
    if (sizeof($matrix) > sizeof($matrix[0])) {
        $matrix = transpose($matrix);
    }
    $length = sizeof($matrix[0]);
    $i = 0;
    while ($i < $length) {
        $max = $i;
        foreach ($matrix as $num => $line) {
            if ($num > $i && abs($line[$num]) > abs($line[$i])) {
                $max = $num;
            }
        }

        $temp = $matrix[$i];
        $matrix[$i] = $matrix[$max];
        $matrix[$max] = $temp;

        foreach ($matrix as $row => $line) {
            if ($row > $i) {
                if (!$matrix[$i][$i]) {
                    continue;
                }
                $factor = $line[$i] / $matrix[$i][$i];
                foreach ($line as $col => $item) {
                    if ($col >= $i) {
                        $matrix[$row][$col] -= $matrix[$i][$col] * $factor;
                    }
                }
            }
        }
        $i++;
    }
    $range = 0;
    foreach ($matrix as $line) {
        foreach ($line as $item) {
            if ($item) {
                $range++;
                break;
            }
        }
    }

    return $range;
}

function transpose($matrix) {
    $transposed = [];
    foreach ($matrix as $row => $line) {
        foreach ($line as $col => $item) {
           $transposed[$col][$row] = $item;
        }
    }

    return $transposed;
}

$matrix = getMatrix(10, 10);

$matrix = [[1, -1, 2],[0,1,-1],[1,2,1]];
//$matrix = [[1, 1, 1],[1,1,1],[1,2,1]];

echo rank($matrix);

