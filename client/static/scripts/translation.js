angular.module('translationModule', []).
    factory('getTranslation', ['$http', function($http) {
            return function(language){
                return $http.get('../languages/' + language + ".json");
            }
        }]);