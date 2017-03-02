var app = angular.module('cms', []).config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{*{').endSymbol('}*}');
});


app.controller('MediaLibraryController', ['$http', '$window', function($http, $window) {
    var self = this;
    
    self.showDetails = function(id) {
        $http.get('/admin/rest/media/' + id).then(function (response) {
            self.media = response.data;
        });
    };
    
    self.delete = function (id) {
        $http.delete('/admin/rest/media/' + id).then(function () {
            $window.location.reload();
        });
    };
}]);


app.controller('LiteralsController', ['$http', function ($http) {
    var self = this;
    
    $http.get('/admin/rest/literals').then(function(response) {
        var count  = response.data.length;
        for(var i = 0; i < count; i++) {
            switch(response.data[i].attr) {
                case 'title':
                    self.title = (response.data[i].value);
                    break;
                case 'author':
                    self.author = (response.data[i].value);
                    break;
                case 'company':
                    self.company = (response.data[i].value);
                    break;
            }
        }
    });
}]);


app.controller('UploadController', ['$scope', function ($scope) {
    var self = this;
    
    self.fileChanged = function (files) {
        self.filename = files[0].name;
        $scope.$apply();
    };
}]);


app.controller('SubController', ['$http', function ($http) {
        var self = this;

        self.submit = function() {
            $http.post('rest/subscribers', JSON.stringify({'email' : self.email})).then(function(response) {
                console.log(response.data);
            });
        };
}]);


app.directive('customOnChange', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attrs) {
            var onChangeFunc = scope.$eval(attrs.customOnChange);
            element.bind('change', function (event) {
                var files = event.target.files;
                onChangeFunc(files);
            });

            element.bind('click', function () {
                element.val('');
            });
        }
    };
});