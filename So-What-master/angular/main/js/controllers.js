'use strict';

/* Controllers */

var mainControllers = angular.module('mainControllers',[]);

mainControllers.controller('globalCtrl',['$scope','$http',
	function($scope,$http){
		$scope.self={};
		$http.get('../../CI/index.php/public_function/myrealname/format/json').success(function(data){
				$scope.self.realname = data.myrealname;
			});
		$http.get('../../CI/index.php/public_function/myuid/format/json').success(function(data){
				$scope.self.uid = data.myuid;
			});
	}]);

mainControllers.controller('mainCtrl',['$scope','$http',
	function($scope,$http){
		$scope.qList={};
		if($.isEmptyObject($scope.qList))
		{
			$http.get('../../CI/index.php/QA_center/question_date/format/json').success(function(data){
				$scope.qList = data;
			});
		}
		$scope.questionByDate = function() {
			$http.get('../../CI/index.php/QA_center/question_date/format/json').success(function(data){
				$scope.qList = data;
			});
		}
		$scope.questionByUser = function() {
			$http.get('../../CI/index.php/QA_center/question_focus/format/json').success(function(data){
				$scope.qList = data;
			});
		}
		$scope.questionByDay = function() {
			$http.get('../../CI/index.php/QA_center/question_day/format/json').success(function(data){
				$scope.qList = data;
			});
		}
		$scope.follow = function(id){
			if(typeof($scope.followed)==undefined || ($scope.followed==false))
			{
				$scope.followed = true;
			} 
			else
			{
				$scope.followed = false;
			}
		}
	}]);

mainControllers.controller('peopleCtrl',['$scope','$http','$routeParams',
	function($scope,$http,$routeParams){
		$scope.uid = $routeParams.uid;
		$http.get('../../CI/index.php/public_function/uidrealname/'+ $scope.uid +'/format/json').success(function(data){
				$scope.realname = data.uidrealname;
			});
	}]);

mainControllers.controller('questionCtrl',['$scope','$http','$routeParams',
	function($scope,$http,$routeParams){
		$scope.qid = $routeParams.id;
	}]);

mainControllers.controller('askCtrl',['$scope','$http',
	function($scope,$http){
		$scope.askquestion = function(q){
			var url = '../../CI/index.php/QA_center/question_ask/format/json/';
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

mainControllers.controller('oqCtrl',['$scope','$http',
	function($scope,$http){
		
	}]);

mainControllers.controller('notificationCtrl',['$scope','$http',
	function($scope,$http){
		
	}]);

mainControllers.controller('FileController', ['$scope', 'FileUploader', function($scope, FileUploader) {
        var uploader = $scope.uploader = new FileUploader({
            url: '../../CI/index.php/personal_center/profile/format/json'
        });

        // FILTERS

        uploader.filters.push({
            name: 'customFilter',
            fn: function(item /*{File|FileLikeObject}*/, options) {
                return this.queue.length < 1;
            }
        });

        // CALLBACKS

        uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
        };
        uploader.onAfterAddingFile = function(fileItem) {
            console.info('onAfterAddingFile', fileItem);
        };
        uploader.onAfterAddingAll = function(addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
        };
        uploader.onBeforeUploadItem = function(item) {
            console.info('onBeforeUploadItem', item);
        };
        uploader.onProgressItem = function(fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
        };
        uploader.onProgressAll = function(progress) {
            console.info('onProgressAll', progress);
        };
        uploader.onSuccessItem = function(fileItem, response, status, headers) {
            console.info('onSuccessItem', fileItem, response, status, headers);
        };
        uploader.onErrorItem = function(fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
        };
        uploader.onCancelItem = function(fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
        };
        uploader.onCompleteItem = function(fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
        };
        uploader.onCompleteAll = function() {
            console.info('onCompleteAll');
        };

        console.info('uploader', uploader);
    }]);

