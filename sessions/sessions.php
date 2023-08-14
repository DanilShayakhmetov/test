<?php
include 'db.php';

$date = "11 August 2023";

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
    }

    echo 'Full load service time: ' . date(DATE_ATOM, $temp['login_time']) . '  -  ' . date(DATE_ATOM, $temp['logout_time']).' maximum users: ' .$temp['count'];

}

fullLoadTime($date);
