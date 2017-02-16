var app = angular.module('cms', []).config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{*{').endSymbol('}*}');
});


app.controller('MediaLibraryController', ['$http', function($http) {
    ctrl = this;
    this.img = {
        id: null,
        name: null,
        width: null,
        height: null,
        mime: null,
        size: null,
        cacheImagePath: null
    };
    
    this.showDetails = function(id) {
        $http.get('/admin/rest/images/' + id).then(function (response) {
            ctrl.img = response.data;
        });
    };
    this.deleteImg = function (id) {
        $http.delete('/admin/rest/images/' + id).then(function () {
            
        });
    };
}]);