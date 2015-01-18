angular.module('epigrafikaModul').controller('adminChart', ['$scope', '$http','$window', function ($scope, $http,$window){
$scope.colors=["#FF0F00","#F8FF01","#04D215","#0D8ECF","#2A0CD0","#8A0CCF","#754DEB"];
$scope.chartData1=null;
$scope.chartData2=null;
$http.get('../server/korisnik.php?type=chart', {responseType: 'JSON',cache: 'false'}).
			success(function(data, status, headers, config){
				if(data!=="null"){
				$scope.chartData1=data.data;
				for(d in $scope.chartData1){
						$scope.chartData1[d].boja=$scope.colors[d];
					}
				}
			}).
			error(function(data, status, headers, config){
			console.log("Greska");
			});
            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = $scope.chartData1;
                chart.categoryField = "datumRegistrovanja";
                // the following two lines makes chart 3D
                chart.depth3D = 20;
                chart.angle = 30;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 90;
                categoryAxis.dashLength = 5;
                categoryAxis.gridPosition = "start";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.title = "Datum registracije";
                valueAxis.dashLength = 5;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = "novi";
                graph.colorField = "boja";
                graph.balloonText = "<span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                chart.addGraph(graph);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = false;
                chartCursor.categoryBalloonEnabled = false;
                chart.addChartCursor(chartCursor);

                chart.creditsPosition = "top-right";


                // WRITE
                chart.write("chartdiv1");
				chart.validateData();
				console.log("Korsnici chart");
            });
			
	$http.get('../server/objekat.php?type=chart', {responseType: 'JSON',cache: 'false'}).
			success(function(data, status, headers, config){
				if(data!=="null"){
				$scope.chartData2=data.data;
				for(d in $scope.chartData2){
						$scope.chartData2[d].boja=$scope.colors[d];
					}
				}
			}).
			error(function(data, status, headers, config){
			console.log("Greska");
			});
            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = $scope.chartData2;
                chart.categoryField = "datumKreiranja";
                // the following two lines makes chart 3D
                chart.depth3D = 20;
                chart.angle = 30;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.labelRotation = 90;
                categoryAxis.dashLength = 5;
                categoryAxis.gridPosition = "start";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.title = "Datum kreiranja";
                valueAxis.dashLength = 5;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = "novi";
                graph.colorField = "boja";
                graph.balloonText = "<span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>";
                graph.type = "column";
                graph.lineAlpha = 0;
                graph.fillAlphas = 1;
                chart.addGraph(graph);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = false;
                chartCursor.categoryBalloonEnabled = false;
                chart.addChartCursor(chartCursor);

                chart.creditsPosition = "top-right";


                // WRITE
				
                chart.write("chartdiv2");
				chart.validateNow();
				
				console.log("Objekat chart");
            });

}]);
console.info("Inicijalizovan admin.");