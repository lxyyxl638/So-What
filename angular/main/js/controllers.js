'use strict';

/* Controllers */

var mainControllers = angular.module('mainControllers',[]);

mainControllers.controller('mainCtrl',['$scope','$http',
	function($scope,$http){
		$scope.questionByDate = function() {
			$http.get('../../CI/index.php/question_center/question_date/format/json').success(function(data){
				$scope.qList = data;
			});
		}
		$scope.questionByUser = function() {
			$http.get('../../CI/index.php/question_center/question_focus/format/json').success(function(data){
				$scope.qList = data;
			});
		}
		$scope.questionByDay = function() {
			$http.get('../../CI/index.php/question_center/question_day/format/json').success(function(data){
				$scope.qList = data;
			});
		}
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