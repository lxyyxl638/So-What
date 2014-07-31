'use strict';

/* Controllers */

var infoControllers = angular.module('infoControllers',[]);

infoControllers.controller('basicCtrl',['$scope','$http',
	function($scope,$http){

		$scope.basicSubmit = function(basic){
			var url = '../../CI/index.php/signup/secondsignup/format/json/';
			var job = basic.job;
			$http({
				method: 'POST',
				url: url,
				data: basic,
			}).success(function(response){
                if(response.state == "success")
                {
                	if(job==0){
						window.location.assign("http://localhost/So-What/angular/info/#/smore");
					}
					else{
						window.location.assign("http://localhost/So-What/angular/info/#/jmore");
					}
                }
            }).error(function(response){
                alert("Error!");
            })
		};
	}]);

infoControllers.controller('moreCtrl',['$scope','$http',
	function($scope,$http){
		$scope.moreSubmit = function(more){
			var url = '../../CI/index.php/signup/thirdsignup/format/json/';
			$http({
				method: 'POST',
				url: url,
				data: more,
			}).success(function(response){
                if(response.state == "success")
                {
					window.location.assign("http://localhost/So-What/angular/main");                	
                }
            }).error(function(response){
                alert("Error!");
            })
		};
	}]);