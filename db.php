<?php


function getConnection()
{
    $servername = "0.0.0.0:3306";
    $username = "root";
    $password = "qwe";
    $dbname = "test";

// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}


$conn = getConnection();

function prepareDB()
{
    $conn = getConnection();
    $from = time() - 432000;
    for ($i = 1; $i <= 1000000; $i++) {
        $login = rand($from, time());
        $logout = rand($login, time() + 2);
        $userId = rand(1, 1000);
        if ($login%2) {
            $sql = "INSERT INTO session (user_id, login_time, logout_time)
        VALUES ('$userId', '$login', '$logout')";
        } else {
            $sql = "INSERT INTO session (user_id, login_time)
        VALUES ('$userId', '$login')";
        }

        if ($conn->query($sql) === TRUE) {
            echo $i;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}

//Example "13 August 2023";
$date = "13 August 2023";
function getData($date) {
    $login = strtotime($date);
    $logout = strtotime($date) + 86400;
    $conn = getConnection();
//    $sql = "SELECT id, user_id, login_time, logout_time FROM session
//                WHERE login_time >= '$login' AND logout_time <= '$logout' OR logout_time IS NULL ";


    $sql = "SELECT id, user_id, login_time, logout_time FROM session 
                WHERE id IN (SELECT id FROM session 
                WHERE login_time >= '$login' AND logout_time <= '$logout' OR logout_time IS NULL)
                AND login_time >= (SELECT MIN(logout_time) FROM session 
                WHERE login_time >= '$login' AND logout_time <= '$logout' OR logout_time IS NULL)
                AND logout_time <= (SELECT MAX(login_time) FROM session 
                WHERE login_time >= '$login' AND logout_time <= '$logout' OR logout_time IS NULL)";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sessions = [];
        while ($row = $result->fetch_assoc()) {
            $sessions[] = $row;
        }
        return $sessions;
    } else {
        echo "0 results";
    }
    $conn->close();
}

//prepareDB();
getData($date);
