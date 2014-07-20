'use strict';

/* Controllers */

var signControllers = angular.module('signControllers',[]);

signControllers.controller('signupCtrl',['$scope','$http',
	function($scope,$http){
		$scope.user = {};

		$scope.register = function(user){
			$scope.user = angular.copy(user);
		};

	}]);

signControllers.controller('signinCtrl',['$scope','$http',
	function($scope,$http){

		$scope.login = function(user){
			var url = '../../CI/index.php/api/form/signin/format/json/';
			$http({
				method: 'POST',
				url: url,
				data: user,
			}).success(function(response){
                console.log(response);
            }).error(function(response){
                alert("Error!");
            })
		};
	}]);