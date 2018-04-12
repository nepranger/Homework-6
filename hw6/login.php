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
    $query = "SELECT id, hashedpass FROM account WHERE username ='$username'";
    
    //we need to now run the query
    $result = queryDB($query, $db);
    
    //make sure the username is correct here
    if (nTuples($result) == 0){
        $errorMessage .= "The username $username, does not correspond to any account in the system. ";
        $isComplete = false;
    }
}



if ($isComplete){
    // there is an account that corresponds to the email that the user entered
    //get the hashed password for that account
    $row = nextTuple($result);
    $hashedpass = $row['hashedpass'];
    $id = $row['id'];
    
    //compare entered password to the password on the database
    if ($hashedpass != crypt($password, $hashedpass)){
        //if password is incorrect
        $errorMessage .= "The password you entered is incorrect. ";
        $isComplete = false;
    }
}    
if ($isComplete){
    //password was entered correctly
    
    //start a session
    //if the session variable username is set, then we assume that the user is logged in.
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['accountid'] = $id;
    
    //send a response back
    $response = array();
    $response['status'] = 'success';
    $response['message'] = 'logged in';
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