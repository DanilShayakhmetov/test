<?php
include 'db.php';

ini_set('memory_limit', '-1');
// do the search
$recursive = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('./'));
// now adjust the contents to your desired depth
$recursive->setMaxDepth(-1);

$date = "11 August 2023";

//Classic
//id, user_id, login_time, logout_time
function fullLoadTime($date) {
    $sessions = getData($date);
    $temp['count'] = 0;

    foreach ($sessions as $target) {
        $counter = 0;
        foreach ($sessions as $session) {
            if ($target['login_time'] >= $session['login_time']
                &&
                $target['logout_time'] <= $session['logout_time']) {
                $counter++;
            }
        }

        if ($temp['count'] < $counter) {
            $temp = $target;
            $temp['count'] = $counter;
        }

        echo $temp['count']. '    -   '. $temp['id'] . "\n";
    }

    echo 'Full load service time: ' . date(DATE_ATOM, $temp['login_time']) . '  -  ' . date(DATE_ATOM, $temp['logout_time']).' maximum users: ' .$temp['count'];
}

//Recursive
//id, user_id, login_time, logout_time
function getPeakInterval($date) {
    $sessions = getData($date);
    $temp['count'] = 0;
    $temp = iteration($sessions, $temp);
    echo 'Full load  service time: ' . date(DATE_ATOM, $temp['login_time']) . '  -  ' . date(DATE_ATOM, $temp['logout_time']).' maximum users: ' .$temp['count'];
}

function recursive($sessions, $target, $counter, &$temp) {
    $session = array_shift($sessions);
    if (sizeof($sessions)) {
        if ($target['login_time'] >= $session['login_time']
            &&
            $target['logout_time'] <= $session['logout_time']) {
            $counter++;
        }
        recursive($sessions, $target, $counter, $temp);
    }  else {
        $temp = $target;
        $temp['count'] = $counter;
        return true;
    }
}

function iteration($sessions, $temp) {
    $base = $temp;
    if (sizeof($sessions)) {
        $target = array_shift($sessions);
        recursive($sessions, $target, 0, $temp);
        if ($temp['count'] < $base['count']) {
            $temp = $base;
        }
        echo $temp['count']. '    -   '. $temp['id'] . "\n";
        iteration($sessions, $temp);
    }  else {
        return $temp;
    }
}


//Recursive
//getPeakInterval($date);

//Cycles
fullLoadTime($date);


