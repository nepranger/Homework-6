/*
 * Filter to enable angular to trust html so it can be displayed on a page
 */
 
(function() {
    'use strict';
    var myApp = angular.module("movies");
    myApp.filter("trustHtml", function($sce) {
        return function(html) {
            return $sce.trustAsHtml(html);
        };
    });

}
)();