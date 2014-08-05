'use strict';

/* Controllers */

var mainControllers = angular.module('mainControllers',[]);

mainControllers.controller('globalCtrl',['$scope','$http', '$interval',
	function($scope,$http,$interval){
		$scope.msgNotify={};
		var timer = $interval(function(){
			$http.get('../../CI/index.php/personal_center/letter_notify/format/json').success(function(data){
				$scope.msgNotify.Num = data.sum;
				if (data.sum == 0)
				{
					$scope.msgNotify.Show = false;
				}
				else
				{
					$scope.msgNotify.Show = true;
				}
			});
		},60000,0,false);
		$scope.self={};
		$http.get('../../CI/index.php/public_function/myrealname/format/json').success(function(data){
				$scope.self.realname = data.myrealname;
			});
		$http.get('../../CI/index.php/public_function/myuid/format/json').success(function(data){
				$scope.self.uid = data.myuid;
			});
		$scope.logout = function(){
			$http.get('../../CI/index.php/login/user_logout/format/json').success(function(response){
				if(response.state == "success")
				{
					window.location.assign("../sign");
				}
			});
		}
	}]);

mainControllers.controller('mainCtrl',['$scope','$http',
	function($scope,$http){
		$scope.qList={};
		if($.isEmptyObject($scope.qList))
		{
			$http.get('../../CI/index.php/qa_center/question_date/format/json').success(function(data){
				$scope.qList = data;
			});
		}
		$scope.questionByDate = function() {
			$http.get('../../CI/index.php/qa_center/question_date/format/json').success(function(data){
				$scope.qList = data;
			});
		}
		$scope.questionByUser = function() {
			$http.get('../../CI/index.php/qa_center/question_focus/format/json').success(function(data){
				if (typeof(data) == typeof("string"))
				{
					$scope.qList = {};
				}
				else
				{
					$scope.qList = data;
				}
			});
		}
		$scope.questionByDay = function() {
			$http.get('../../CI/index.php/qa_center/question_day/format/json').success(function(data){
				$scope.qList = data;
			});
		}
		$scope.follow = function(id,$index){
			$http.get('../../CI/index.php/qa_center/question_attention/'+id+'/format/json').success(function(data){
				if(data.follow == 0)
				{
					$scope.qList[$index].follow = 0;
				}
				else if (data.follow == 1)
				{
					$scope.qList[$index].follow = 1;
				}
			});
		}
	}]);

mainControllers.controller('peopleCtrl',['$scope','$http','$routeParams',
	function($scope,$http,$routeParams){
		$scope.uid = $routeParams.uid;
		$scope.uploader = {};
		$scope.uploader.Show = false;
		$scope.send = {};
		$scope.send.Show = false;
		$scope.transfer = {};
		$scope.transfer.uid = $scope.uid;
		
		$http.get('../../CI/index.php/personal_center/get_profile/'+ $scope.uid +'/format/json').success(function(data){
				$scope.isME = {};
				$scope.realname = data.realname;
				if(data.job == 1){
					$scope.isStudent = false;
					$scope.jobPosition = data.jobid;
					$scope.jobCompany = data.jobplace;
					$scope.school = "";
					$scope.major = "";
				}
				else if(data.job == 0){
					$scope.isStudent = true;
					$scope.major = data.jobid;
					$scope.school = data.jobplace;
					$scope.jobPosition = "";
					$scope.jobPosition = "";
				}
				$scope.city = data.city;
				$scope.gender = data.gender;
				$scope.description = data.description;
				if (data.myprofile == 1){
					$scope.isME.Show = true;
				}
				else if (data.myprofile == 0){
					$scope.isME.Show = false;
				}
				$scope.imgLoc = data.location;
			});

		$http.get('../../CI/index.php/personal_center/my_question/3/0/format/json').success(function(data){
			if (typeof(data) == typeof("string")){
				$scope.myquestion = {};
			}
			else{
				$scope.myquestion = data;
			}
		});

		$http.get('../../CI/index.php/personal_center/my_answer/3/0/format/json').success(function(data){
			if (typeof(data) == typeof("string")){
				$scope.myanswer = {};
			}
			else{
				$scope.myanswer = data;
			}
		});

		$http.get('../../CI/index.php/personal_center/my_attention/3/0/format/json').success(function(data){
			if (typeof(data) == typeof("string")){
				$scope.myattention = {};
			}
			else{
				$scope.myattention = data;
			}
		});

		$scope.modifyImg = function(){
			$scope.uploader.Show = !$scope.uploader.Show;
		}

		$scope.sendMsg = function(){
			$scope.send.Show = !$scope.send.Show;
		}

		$scope.follow = function(id,$index){
			$http.get('../../CI/index.php/qa_center/question_attention/'+id+'/format/json').success(function(data){
				if(data.follow == 0)
				{
					$scope.myquestion[$index].follow = 0;
				}
				else if (data.follow == 1)
				{
					$scope.myquestion[$index].follow = 1;
				}
			});
		}

	}]);

mainControllers.controller('messageCtrl',['$scope','$http','$routeParams',
	function($scope,$http,$routeParams){
		$scope.uid = $routeParams.uid;
		$http.get('../../CI/index.php/personal_center/letter_friend/format/json').success(function(data){
			if (typeof(data) == typeof("string")){
				$scope.myMessage = {};
			}
			else{
				$scope.myMessage = data;
			}
			});
	}]);

mainControllers.controller('talkCtrl',['$scope','$http','$routeParams',
	function($scope,$http,$routeParams){
		$scope.uid = $routeParams.uid;
		$scope.other = {};
		$http.get('../../CI/index.php/public_function/middle_photo/'+$scope.uid+'/format/json').success(function(data){
			$scope.other.img = data.location;
		});
		$http.get('../../CI/index.php/public_function/uidrealname/'+$scope.uid+'/format/json').success(function(data){
			$scope.other.realname = data.uidrealname;
		});
		$http.get('../../CI/index.php/public_function/middle_photo/'+$scope.self.uid+'/format/json').success(function(data){
			$scope.self.img = data.location;
		});

		$http.get('../../CI/index.php/personal_center/letter_talk/'+$scope.uid+'/format/json').success(function(data){
			if (typeof(data) == typeof("string")){
				$scope.myTalk = {};
			}
			else{
				$scope.myTalk = data;
			}
			});

		$scope.postMsg = function(m,id){
			var url = '../../CI/index.php/personal_center/letter_send/format/json/';
			m.uid=id;
			$http({
				method: 'POST',
				url: url,
				data: m,
			}).success(function(response){
                if(response.state == "success")
                {
                	console.log("gagagaga");
                	window.location.reload();
                }
            }).error(function(response){
                alert("Error!");
            })
		};
	}]);

mainControllers.controller('settingCtrl',['$scope','$http','$routeParams',
	function($scope,$http,$routeParams){
		$scope.uid = $routeParams.uid;
		$http.get('../../CI/index.php/public_function/uidrealname/'+ $scope.uid +'/format/json').success(function(data){
				$scope.realname = data.uidrealname;
			});
	}]);

mainControllers.controller('questionCtrl',['$scope','$http','$routeParams',
	function($scope,$http,$routeParams){
		$scope.question = {};
		$scope.question.qid = $routeParams.id;
		$http.get('../../CI/index.php/qa_center/view_question/'+ $scope.question.qid +'/format/json').success(function(data){
				$scope.q = data;
			});
		$http.get('../../CI/index.php/qa_center/view_answer/'+ $scope.question.qid +'/0/format/json').success(function(data){
				if (typeof(data) == typeof("string"))
				{
					$scope.answers = {};
				}
				else
				{
					$scope.answers = data;
					for (var i=0 ; i < $scope.answers.length; i++)
					{
						if ($scope.answers[i].mygood == 1)
						{
							$scope.answers[i].like = false;
							$scope.answers[i].cancellike = true;
							$scope.answers[i].dislike = false;
							$scope.answers[i].canceldislike = false;
						}
						else if ($scope.answers[i].mygood == 0)
						{
							$scope.answers[i].like = true;
							$scope.answers[i].cancellike = false;
							$scope.answers[i].dislike = true;
							$scope.answers[i].canceldislike = false;
						}
						else if ($scope.answers[i].mygood == -1)
						{
							$scope.answers[i].like = false;
							$scope.answers[i].cancellike = false;
							$scope.answers[i].dislike = false;
							$scope.answers[i].cancellike = true;
						}
					}
				}
			});
		$scope.like = function(qid,aid,$index){
			$http.get('../../CI/index.php/qa_center/good/'+qid+'/'+aid+'/format/json').success(function(data){
				if(data.mygood == 1){
					$scope.answers[$index].like = false;
					$scope.answers[$index].cancellike = true;
					$scope.answers[$index].dislike = false;
					$scope.answers[$index].canceldislike = false;
					$scope.answers[$index].good = data.good;
					$scope.answers[$index].bad = data.bad;
				}
				else if(data.mygood == 0){
					$scope.answers[$index].like = true;
					$scope.answers[$index].cancellike = false;
					$scope.answers[$index].dislike = true;
					$scope.answers[$index].canceldislike = false;
					$scope.answers[$index].good = data.good;
					$scope.answers[$index].bad = data.bad;
				}
				else if(data.mygood == -1){
					$scope.answers[$index].like = false;
					$scope.answers[$index].cancellike = false;
					$scope.answers[$index].dislike = false;
					$scope.answers[$index].canceldislike = true;
					$scope.answers[$index].good = data.good;
					$scope.answers[$index].bad = data.bad;
				}
			});
		}
		$scope.dislike = function(qid,aid,$index){
			$http.get('../../CI/index.php/qa_center/bad/'+qid+'/'+aid+'/format/json').success(function(data){
				if(data.mygood == 1){
					$scope.answers[$index].like = false;
					$scope.answers[$index].cancellike = true;
					$scope.answers[$index].dislike = false;
					$scope.answers[$index].canceldislike = false;
					$scope.answers[$index].good = data.good;
					$scope.answers[$index].bad = data.bad;
				}
				else if(data.mygood == 0){
					$scope.answers[$index].like = true;
					$scope.answers[$index].cancellike = false;
					$scope.answers[$index].dislike = true;
					$scope.answers[$index].canceldislike = false;
					$scope.answers[$index].good = data.good;
					$scope.answers[$index].bad = data.bad;
				}
				else if(data.mygood == -1){
					$scope.answers[$index].like = false;
					$scope.answers[$index].cancellike = false;
					$scope.answers[$index].dislike = false;
					$scope.answers[$index].canceldislike = true;
					$scope.answers[$index].good = data.good;
					$scope.answers[$index].bad = data.bad;
				}
			});
		}
	}]);

mainControllers.controller('askCtrl',['$scope','$http',
	function($scope,$http){
		$scope.askquestion = function(q){
			var url = '../../CI/index.php/qa_center/question_ask/format/json/';
			$http({
				method: 'POST',
				url: url,
				data: q,
			}).success(function(response){
                if (response.state == "success")
                {
                	window.location.reload();
                }
            }).error(function(response){
                alert("Error!");
            })
		};
	}]);

mainControllers.controller('answerCtrl',['$scope','$http',
	function($scope,$http){
		$scope.answerquestion = function(a){
			var url = '../../CI/index.php/qa_center/answer/'+$scope.question.qid+'/format/json/';
			$http({
				method: 'POST',
				url: url,
				data: a,
			}).success(function(response){
                if(response.state == "success")
                {
                	console.log("gagagaga");
                	window.location.reload();
                }
            }).error(function(response){
                alert("Error!");
            })
		};
	}]);

mainControllers.controller('oqCtrl',['$scope','$http',
	function($scope,$http){
		
	}]);

mainControllers.controller('notificationCtrl',['$scope','$http','$routeParams',
	function($scope,$http,$routeParams){
		$scope.uid = $routeParams.uid;
		$http.get('../../CI/index.php/public_function/uidrealname/'+ $scope.uid +'/format/json').success(function(data){
				$scope.realname = data.uidrealname;
			});
	}]);

mainControllers.controller('FileController', ['$scope', 'FileUploader', function($scope, FileUploader) {
        var uploader = $scope.uploader = new FileUploader({
            url: '../../CI/index.php/personal_center/modify_profile/format/json'
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

