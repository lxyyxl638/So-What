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
			// $scope.user = angular.copy(user);
			var url = 'http://localhost/sowhatdemo/index.php/api/form/formu/format/json/';
			//var data = $.param(user);
			$http({
				method: 'POST',
				url: url,
				data: user,
				//headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}).success(function(response){
                alert(response);
            }).error(function(response){
                alert(response);
            })
        
		};

	}]);