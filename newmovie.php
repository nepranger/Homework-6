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
$title = $data['title'];
$director = $data['director'];
$reldate = $data['reldate'];
$video = $data['video'];


//set up variables to handle errors
//is complete will be false if we find any problems when checking the data
$isComplete = true;

//error message we will send back to angular if we have any problems
$errorMessage = "";

//
// Validation
//

// check if title, director, and reldate meets criteria
if (!isset($title) || (strlen($title) < 2)){
    $isComplete = false;
    $errorMessage .= "Please enter a title with at least two characters. ";
    
} else {
    $title = makeStringSafe($db, $title);
}


if (!isset($director) || (strlen($director) < 2)){
    $isComplete = false;
    $errorMessage .= "Please enter a director with at least two characters. ";
    
} else {
    $director = makeStringSafe($db, $director);
}


if (!isset($reldate) || (strlen($reldate) < 2)){
    $isComplete = false;
    $errorMessage .= "Please enter a release date with at least two characters. ";
    
} else {
    $reldate = makeStringSafe($db, $reldate); 
}




$video = makeStringSafe($db, $video);



//check if we already have a player with the same name, country, and club as the one we are adding/processing
if($isComplete){
    // set up a query to check if this player is already in the database
    $query = "SELECT title FROM movies WHERE title ='$title' AND director = '$director' AND reldate = '$reldate'";
    
    //we need to now run the query
    $result = queryDB($query, $db);
    
    //check on the number of records returned
    if (nTuples($result) > 0){
        $isComplete = false;
        $errorMessage .= "The movie $title, directed by $director, released on $reldate is already in the database.  "; 
    }
}



// if we get this far and $isComplete is true it means we should add the player into the database.
if ($isComplete){
    
    // we will setup the insert statement to add this new record into the database
    $insertquery = "INSERT INTO movies(title, director, reldate, video) VALUES ('$title', '$director', '$reldate', '$video')";
    
    // run the insert statement
    queryDB($insertquery, $db);
    
    // get the id of the player we just entered
    $movieid = mysqli_insert_id($db);
    
    // send a response back to angular
    $response = array();
    $response['status'] = 'success';
    $response['id'] = $movieid;
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