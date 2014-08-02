'use strict';

// var signApp = angular.module('signApp',[
// 	'ngRoute',
// 	'signControllers'
// 	]);

var mainApp = angular.module('mainApp', ['ngRoute','angularFileUpload',
	'mainControllers'], function($httpProvider) {
  // Use x-www-form-urlencoded Content-Type
  $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
 
  /**
   * The workhorse; converts an object to x-www-form-urlencoded serialization.
   * @param {Object} obj
   * @return {String}
   */ 
  var param = function(obj) {
    var query = '', name, value, fullSubName, subName, subValue, innerObj, i;
      
    for(name in obj) {
      value = obj[name];
        
      if(value instanceof Array) {
        for(i=0; i<value.length; ++i) {
          subValue = value[i];
          fullSubName = name + '[' + i + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value instanceof Object) {
        for(subName in value) {
          subValue = value[subName];
          fullSubName = name + '[' + subName + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value !== undefined && value !== null)
        query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
    }
      
    return query.length ? query.substr(0, query.length - 1) : query;
  };
 
  // Override $http service's default transformRequest
  $httpProvider.defaults.transformRequest = [function(data) {
    return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
  }];
});

mainApp.config(['$routeProvider',
	function($routeProvider){
		$routeProvider.
		when('/home',{
			templateUrl:'partials/main.html',
			controller:'mainCtrl'
		}).
    when('/open-question',{
      templateUrl:'partials/open-question.html',
      controller:'oqCtrl'
    }).
    when('/notification/:uid',{
      templateUrl:'partials/notification.html',
      controller:'notificationCtrl'
    }).
    when('/people/:uid',{
      templateUrl:'partials/people.html',
      controller:'peopleCtrl'
    }).
    when('/message/:uid',{
      templateUrl:'partials/message.html',
      controller:'messageCtrl'
    }).
    when('/setting/:uid',{
      templateUrl:'partials/settings.html',
      controller:'settingCtrl'
    }).
    when('/question/:id',{
      templateUrl:'partials/question.html',
      controller:'questionCtrl'
    }).
    when('/talk/:uid',{
      templateUrl:'partials/talk.html',
      controller:'talkCtrl'
    }).
		otherwise({
			redirectTo: '/home'
		});
	}]);