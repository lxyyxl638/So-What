'use strict';

/* Controllers */

var signControllers = angular.module('signControllers',[]);

signControllers.controller('signupCtrl',['$scope','$http',
	function($scope,$http){

		$scope.register = function(user){
			var url = '../../CI/index.php/signup/firstsignup/format/json/';
			$http({
				method: 'POST',
				url: url,
				data: user,
			}).success(function(response){
                if(response.state == "success")
                {
                	var url = '../../CI/index.php/login/userlogin/format/json/';
					$http({
						method: 'POST',
						url: url,
						data: user,
					}).success(function(response){
                		window.location.assign("../../info");
                	})
                }
            }).error(function(response){
                alert("Error!");
            })
		};
	}]);

signControllers.controller('signinCtrl',['$scope','$http',
	function($scope,$http){
		$scope.login = function(user){
			var url = '../../CI/index.php/login/userlogin/format/json/';
			$http({
				method: 'POST',
				url: url,
				data: user,
			}).success(function(response){
                if (response.state == "success")
                {
                	window.location.assign("../../main");
                }
                else if(response.state == "root")
                {
                	window.location.assign("../../admin");
                }
                else
                {
                	alert("fail!");
                }
            }).error(function(response){
                alert("Error!");
            })
		};
	}]);