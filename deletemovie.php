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
$id = $data['id'];



//set up variables to handle errors
//is complete will be false if we find any problems when checking the data
$isComplete = true;

//error message we will send back to angular if we have any problems
$errorMessage = "";

//
// Validation
//

// check if id got sent
if (!isset($id) && ((int)$id == $id)) {
    $isComplete = false;
    $errorMessage .= "The deletemovie.php file requires an integer id to be sent. ";
    
} 




//check if there is a record in the database matching the id.
if($isComplete){
    // set up a query to check if the id passed to this file corresponds to a record in the database
    $query = "SELECT title FROM movies WHERE id=$id";
    
    //we need to now run the query
    $result = queryDB($query, $db);
    
    //check on the number of records returned
    if (nTuples($result) == 0){
        //if we get no records back, it means no records match the id that we got
        $isComplete = false;
        $errorMessage .= "The id $id did not match any records in the movies table. "; 
    }
}



// if we get this far and $isComplete is true it means we should delete the player into the database.
if ($isComplete){
    
    // we will setup the delete statement to remove this record from the database
    $deletequery = "DELETE FROM movies WHERE id=$id";
    
    // run the delete statement
    queryDB($deletequery, $db);
    

    
    // send a response back to angular
    $response = array();
    $response['status'] = 'success';
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