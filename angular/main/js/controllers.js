'use strict';

/* Controllers */

var mainControllers = angular.module('mainControllers',[]);

mainControllers.controller('mainCtrl',['$scope','$http',
	function($scope,$http){

	}]);

mainControllers.controller('peopleCtrl',['$scope','$http',
	function($scope,$http){

	}]);

mainControllers.controller('askCtrl',['$scope','$http',
	function($scope,$http){
		$scope.askquestion = function(q){
			var url = '../../CI/index.php/question_center/question_ask/format/json/';
			$http({
				method: 'POST',
				url: url,
				data: q,
			}).success(function(response){
                alert("提问成功");
            }).error(function(response){
                alert("Error!");
            })
		};
	}]);