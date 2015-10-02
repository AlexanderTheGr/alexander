(function($) {
    $.fn.alexDataTable = function(app, ctrl, url, view, custom) {
        var defaults = {}
        var alexander = this;
        alexander.hide();
        var $dialog = {}
        var settings = $.extend({}, defaults, custom);
        var dt_table;
        dataTable(app, ctrl, url);
        function dataTable(app, ctrl, url,view) {
            var app = angular.module(app, []).config(function($interpolateProvider) {
                $interpolateProvider.startSymbol('[[').endSymbol(']]');
            });
            var data = {};
            data.id = 1;
            app.controller(ctrl, function($scope, $http) {
                $http.get(url, "options=nodata")
                        .success(function(response) {
                    //$scope.records = response.data;
                    $scope.fields = response.fields;
                    alexander.show();
                    setTimeout(function() {

                        dt_table = $(alexander).dataTable({
                            "pageLength": 100,
                            "processing": true,
                            "serverSide": true,
                            "initComplete": initComplete,
                            "drawCallback": drawCallback,
                            "rowCallback": rowCallback,
                            "createdRow": createdRow,
                            "ajax": {
                                "method": "post",
                                "url": url,
                            }
                        })
                    }, 1)
                });
            });
        }
        function initComplete(settings, json) {

            $(alexander).find('tbody').on('click', 'tr', function() {
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                }
                else {
                    dt_table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                }
                location.href  = view+"/"+$(this).attr("ref");
            });

            $(alexander).find(".search_init").change(function() {
                dt_table.fnFilter(this.value, $(alexander).find(".search_init").index(this));
            });
        }
        function drawCallback(settings) {

        }
        function rowCallback(nRow, aData, iDataIndex) {

        }
        function createdRow(nRow, aData, iDataIndex) {
            $(nRow).attr('ref', aData[0]);
            $(nRow).attr('ng-click', "toggle()");
        }
    }
})(jQuery);
