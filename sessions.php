<?php
include 'db.php';

$date = "11 August 2023";


//id, user_id, login_time, logout_time
function fullLoadTime($date) {
    $sessions = getData($date);
    $temp = [];

    foreach ($sessions as $k => $target) {
        $counter = 0;
        foreach ($sessions as $session) {
            if ($target['login_time'] <= $session['login_time']
                ||
                $target['logout_time'] >= $session['logout_time']) {
                $counter++;
            }
        }
        if ($k) {
            if ($temp['count'] < $counter) {
                $temp['id'] = $target['id'];
                $temp['count'] = $counter;
            }
        } else {
            $temp['id'] = $target['id'];
            $temp['count'] = $counter;
        }
    }

    echo $temp['id'], '-------' ,$temp['count'];

}

fullLoadTime($date);


function recursiveCounter($sessions, $num) {


}
