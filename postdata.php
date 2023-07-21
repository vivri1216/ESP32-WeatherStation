<?php

$servername = “localhost”;
$dbname = “esp_web”;
$username = “admin”;
$password = “1234”;
$apikeyvalue = “789rty”;
$api_key = $value1 = $value2 = “”;

If($_SERVER ["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $apikeyvalue) {
        $value1 = test_input($_POST["value1"]);
        $value2 = test_input($_POST["value2"]);

        $conn = new mysqli($servername, $username, $password, $dbname);
        if($conn -> connect_error){
            die("Connection Failed; " . $conn -> connect_error);
        }
        $sql = "INSERT INTO sensor (value1, value2)
        VALUES ('".$value1."', '".$value2."')";

        if($conn -> query($sql) == TRUE){
            echo  "New record created succesfully";
        }
        else {
            echo "Error: " .$sql. "<br>" . $conn -> error; 
        }
        $conn -> close();
        
    }
    else {
        echo "Wrong API key provided";
    }
}
else {
    echo "No data posted";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
}

?>