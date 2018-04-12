<?php

//we need to include these two files in order to work with the datbase
include_once('config.php');
include_once('dbutils.php');

// get a handle to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

// retrieve data from the angular controller
// decode the json object
$data = json_decode(file_get_contents('php://input'), true);

//get each piece of data
$username = $data['username'];
$password = $data['password']; 


//set up variables to handle errors
//is complete will be false if we find any problems when checking the data
$isComplete = true;

//error message we will send back to angular if we have any problems
$errorMessage = "";

//
// Validation
//

// check if account and password meets criteria
if (!isset($username) || (strlen($username) < 4)){
    $isComplete = false;
    $errorMessage .= "Please enter a username with at least four characters. ";
    
} else {
    $title = makeStringSafe($db, $username);
}


if (!isset($password) || (strlen($password) < 6)){
    $isComplete = false;
    $errorMessage .= "Please enter a password with at least six characters. ";
    
} else


//check if we already have a username that matches the one the user entered
if($isComplete){
    // set up a query to check if this username is already in the database
    $query = "SELECT id FROM account WHERE username ='$username'";
    
    //we need to now run the query
    $result = queryDB($query, $db);
    
    //check on the number of records returned
    if (nTuples($result) > 0){
        $isComplete = false;
        $errorMessage .= "The username $username, is already taken. Please select a different username. "; 
    }
}



// if we get this far and $isComplete is true it means we should add the player into the database.
if ($isComplete){
    // create a hashed version of the password
    $hashedpass = crypt($password, getSalt());
    
    // we will setup the insert statement to add this new record into the database
    $insertquery = "INSERT INTO account(username, hashedpass) VALUES ('$username', '$hashedpass')";
    
    // run the insert statement
    queryDB($insertquery, $db);
    
    // get the id of the account we just entered
    $accountid = mysqli_insert_id($db);
    
    // send a response back to angular
    $response = array();
    $response['status'] = 'success';
    $response['id'] = $accountid;
    header('Content-Type: application/json');
    echo(json_encode($response));
    
} else {
    //there's been an error. we need to report it to the angular controller.
    ob_start();
    var_dump($data);
    $postdump = ob_get_clean();
    
    // set up our response array
    $response = array();
    $response['status'] = 'error';
    $response['message'] = $errorMessage . $postdump;
    header('Content-Type: application/json');
    echo(json_encode($response));
    
}



?>