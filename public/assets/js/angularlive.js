// Transaction feed
var app = angular.module('app', []);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%').endSymbol('%>');
});

app.controller('MainController', ['$scope', '$http', function($scope, $http) {
  $scope.items = [];
  $scope.fetching = false;
  $scope.url = 'api/transactions';

  // Fetch more items
    $scope.getMore = function() {
            if($scope.fetching) return;
            $scope.fetching = true;
            $http.get($scope.url).success(function(items) {
              $scope.fetching = false;
              if(items != $scope.items) {
                $scope.items = [];
                $scope.items = $scope.items.concat(items);
              }
            });
      };

    setInterval($scope.getMore, 5000);
}]);