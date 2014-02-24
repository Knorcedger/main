Witer.directive('chart', function() {
	return {
		restrict: 'E',
		replace: true,
		template: '<canvas id="canvas"></canvas>',
		link: function(scope, element, attrs) {
			var measurementData = scope.measurementData;
			var lineOptions = {
				scaleOverride : true,
			
				//** Required if scaleOverride is true **
				//Number - The number of steps in a hard coded scale
				scaleSteps : 5,
				//Number - The value jump in the hard coded scale
				//scaleStepWidth : 0.5,
				//Number - The scale starting value
				//scaleStartValue : 65,
				animation: false,
				bezierCurve: false,
				scaleLabel : "<%=parseFloat(value).toFixed(1)%>"
			}
			
			var lineChartData = {
				animation: false,
				labels : [],
				datasets : [
					{
						fillColor : "rgba(0, 204, 255, 0)",
						strokeColor : "rgba(0, 204, 255, 1)",
						pointColor : "rgba(0, 204, 255, 1)",
						pointStrokeColor : "#fff",
						data : []
					}
				]
			};
			
			// display 30 values max
			var graphValues = measurementData.length > 30 && 30 || measurementData.length;
			var graphLowest = 10000;
			var graphHighest = 0;
			for (var i = graphValues - 1; i > -1; i--) {
				var date = (new Date(measurementData[i].date)).getDate();
				lineChartData.labels.push(date);
				lineChartData.datasets[0].data.push(measurementData[i].trend);
				
				if (measurementData[i].trend < graphLowest) {
					graphLowest = measurementData[i].trend;
				}
				
				if (measurementData[i].trend > graphHighest) {
					graphHighest = measurementData[i].trend;
				}
			}
			
			lineOptions.scaleStartValue = graphLowest;
			lineOptions.scaleStepWidth = parseFloat(((graphHighest - graphLowest) / 5).toFixed(1));
			
			canvas = document.getElementById("canvas"); 
			canvas.height = window.innerHeight / 2;
			canvas.width = window.innerWidth - 60;
			
			var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData, lineOptions);

		}
	};
});