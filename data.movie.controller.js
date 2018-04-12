/*
 *Controller where we get the data on the movies
 */
(function() {
    'use strict';
    
    var myApp = angular.module("movies");
    myApp.controller("dataControl",function($scope, $http, $window) {
        //define data for the app
        $http.get('getmovies.php')
            .then(function(response) {
                $scope.data = response.data.value;
            }
                );
        /*
        $scope.data = {
            "titles":[
                {"name":"Apocalypse Now","director":"Francis Ford Coppola","release":"August 15, 1979","video":"<iframe src='https://www.youtube.com/embed/FTjG-Aux_yQ' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>"},
                {"name":"Interstellar","director":"Christopher Nolan","release":"October 26, 2014","video":"<iframe src='https://www.youtube.com/embed/Lm8p5rlrSkY' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>"},
                {"name":"Saving Private Ryan","director":"Steven Spielberg","release":"July 24, 1998","video":"<iframe src='https://www.youtube.com/embed/RYID71hYHzg' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>"},
                {"name":"The Dark Knight","director":"Christopher Nolan","release":"July 18, 2008","video":"<iframe src='https://www.youtube.com/embed/EXeTwQWrcwY' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>"},
                {"name":"No Country For Old Men","director":"The Coen Brothers","release":"November 9, 2007","video":"<iframe src='https://www.youtube.com/embed/38A__WT3-o0' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>"},       
        ]
        };
        */
       $scope.query = {};
       $scope.queryBy = "$";
       
       //this variable will hold the page number that should be highleted in the menu bar
       //0 is home.
       $scope.menuHighlight = 0;
       
       //function to send new movie information to web api to add it to the database
       $scope.newMovie = function(movieDetails) {
        var movieupload = angular.copy(movieDetails);
        
        $http.post("newmovie.php", movieupload)
            .then(function(response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error:' + response.data.message);
                    } else {
                        //successful
                        $window.location.href = "index.html";
                    }
                } else {
                   alert('unexpected error'); 
                }
            });
        
       };
       
       
       //function to delete a player. It receives the players name and id and calls a php web api to complete deletion from the database.
       $scope.deleteMovie = function(title, id) {
        if (confirm("Are you sure you want to delete " + title + "?")){
        
                $http.post("deletemovie.php", {"id" : id})
                    .then(function(response) {
                        if (response.status == 200) {
                            if (response.data.status == 'error') {
                                alert('error:' + response.data.message);
                            } else {
                                //successful
                                $window.location.href = "index.html";
                            }
                        } else {
                           alert('unexpected error'); 
                        }
                    }
                );
            } 
       };
       
        //function to edit new movie information to web api to add it to the database
       $scope.editMovie = function(movieDetails) {
        var movieupload = angular.copy(movieDetails);
        
        $http.post("editmovie.php", movieupload)
            .then(function(response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error:' + response.data.message);
                    } else {
                        //successful
                        $window.location.href = "index.html";
                    }
                } else {
                   alert('unexpected error'); 
                }
            });
        
       };
       
       
       /*
        * Set the edit mode of a particular player
        * on is true if we are setting edit mode to be on, false otherwise
        * movie corresponds to the movie to which we are setting an edit mode
        */
       $scope.setEditMode = function(on, movie){
        if(on){
            //movie.reldate = parseInt(movie.reldate); 
            $scope.editmovie = angular.copy(movie); 
            movie.editMode = true; 
        } else {
            $scope.editmovie = null;
            movie.editMode = false;
        }
       };
       
       /*
        *Gets the edit mode for a particular movie
        */
        $scope.getEditMode = function(movie){
            return movie.editMode;

       };
       
     //function to send new account information to web api to add it to the database
       $scope.newAccount = function(accountDetails) {
        var accountupload = angular.copy(accountDetails);
        
        $http.post("newaccount.php", accountupload)
            .then(function(response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error:' + response.data.message);
                    } else {
                        //successful
                        $window.location.href = "index.html";
                    }
                } else {
                   alert('unexpected error'); 
                }
            });
            
            
        
       };
    //function to send new account information to web api to add it to the database
       $scope.login = function(accountDetails) {
        var accountupload = angular.copy(accountDetails);
        
        $http.post("login.php", accountupload)
            .then(function(response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error:' + response.data.message);
                    } else {
                        //successful
                        $window.location.href = "index.html";
                    }
                } else {
                   alert('unexpected error'); 
                }
            });
            
            
        
       };
       
     //function to log the user out
       $scope.logout = function() {
        
        $http.post("logout.php")
            .then(function(response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error:' + response.data.message);
                    } else {
                        //successful
                        $window.location.href = "index.html";
                    }
                } else {
                   alert('unexpected error'); 
                }
            });
            
            
        
       };
       
    //function to check if user is logged in
       $scope.checkifloggedin = function() {
        
        $http.post("isloggedin.php")
            .then(function(response) {
                if (response.status == 200) {
                    if (response.data.status == 'error') {
                        alert('error:' + response.data.message);
                    } else {
                        //successful
                        //set $scope.isloggedin based on whether the user is logged in or not
                        $scope.isloggedin = response.data.loggedin;
                    }
                } else {
                   alert('unexpected error'); 
                }
            });
            
            
        
       };
       
       
       
       
       

    });
    
})();
