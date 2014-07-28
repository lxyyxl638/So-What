'use strict';

/* Controllers */
var appController = angular.module('appController',[]);

appController.controller('appCtrl',['$scope','$http',
	function($scope,$http){
		$scope.navBar.show = false;
	}]);

