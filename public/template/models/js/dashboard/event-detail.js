(function($) {
    /* "use strict" */


 var dzChartlist = function(){
	//let draw = Chart.controllers.line.__super__.draw; //draw shadow
	var screenWidth = $(window).width();
	var chartBar = function(){
		if(jQuery('#chart_widget_2').length > 0 ){
	
			const chart_widget_2 = document.getElementById("chart_widget_2").getContext('2d');
			//generate gradient
			const chart_widget_2gradientStroke = chart_widget_2.createLinearGradient(250, 0, 0, 0);
			chart_widget_2gradientStroke.addColorStop(1, "#EA7A9A");
			chart_widget_2gradientStroke.addColorStop(0, "#FAC7B6");

			// chart_widget_2.attr('height', '100');

			new Chart(chart_widget_2, {
				type: 'bar',
				data: {
					defaultFontFamily: 'Poppins',
					labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
					datasets: [
						{
							label: "My First dataset",
							data: [15, 40, 55, 40, 25, 35, 40, 50, 85, 40],
							borderColor: 'rgba(254, 99, 78, 1)',
							borderWidth: "0",
							backgroundColor: 'rgba(254, 99, 78, 1)', 
							hoverBackgroundColor: 'rgba(254, 99, 78, 1)'
						}
					]
				},
				options: {
					plugins:{
						legend:false,
						
					},
					responsive: true, 
					maintainAspectRatio: false,  
					scales: {
						y: {
							display: false, 
							max: 100, 
							min: 0, 
							ticks: {
								beginAtZero: true, 
								display: false, 
								stepSize: 10
							}, 
							grid: {
								display: false, 
								drawBorder: false
							}
						},
						x:{
							display: false, 
							barPercentage: 0.4, 
							grid: {
								display: false, 
								drawBorder: false
							}, 
							ticks: {
								display: false
							}
						}
					}
				}
			});

		}
		
		
	}
	
	var donutChart1 = function(){
		$("span.donut").peity("donut", {
			width: "90",
			height: "90"
		});
	}
	var donutChart2 = function(){
		$("span.donut2").peity("donut", {
			width: "70",
			height: "70"
		});
	}
	
	var widgetChart1 = function(){
		if(jQuery('#widgetChart1').length > 0 ){
			const chart_widget_1 = document.getElementById("widgetChart1").getContext('2d');
			new Chart(chart_widget_1, {
				type: "line",
				data: {
					labels: ["January", "February", "March", "April", "May", "June", "July", "Aug"],

					datasets: [{
						label: "Sales Stats",
						backgroundColor: ['rgba(19, 180, 151, 0)'],
						borderColor: '#18b1ea',
						pointBackgroundColor: '#18b1ea',
						pointBorderColor: '#18b1ea',
						borderWidth:6,
						borderRadius:10,
						pointHoverBackgroundColor: '#18b1ea',
						tension:0.5,
						pointHoverBorderColor: '#18b1ea',
						
						data: [5, 1, 5, 1, 7, 2, 6, 1]
					}]
				},
				options: {
					title: {
						display: !1
					},
					
					plugins:{
						legend:false,
						tooltip: {
							intersect: !1,
							mode: "nearest",
							xPadding: 10,
							yPadding: 10,
							caretPadding: 10
						},						
					},
					responsive: !0,
					maintainAspectRatio: !1,
					hover: {
						mode: "index"
					},
					scales: {
						x: {
							display: !1,
							grid: !1,
							scaleLabel: {
								display: !0,
								labelString: "Month"
							}
						},
						y:{
							display: !1,
							grid: !1,
							scaleLabel: {
								display: !0,
								labelString: "Value"
							},
							ticks: {
								beginAtZero: !0
							}
						}
					},
					elements: {
						
						point: {
							radius: 0,
							borderWidth: 0
						}
					},
					layout: {
						padding: {
							left: 0,
							right: 0,
							top: 5,
							bottom: 0
						}
					}
				}
			});

		}
	}
	
	var radialBar = function(){
		var options = {
          series: [46],
		  chart: {
		  height: 250,
		  type: 'radialBar',
		},
		plotOptions: {
		  radialBar: {
			hollow: {
			  size: '55%',
			  background: '#fff',
              image: undefined,
              imageOffsetX: 0,
              imageOffsetY: 0,
              position: 'front',
			},
			dataLabels: {
				value:{
					offsetY: 0,
					fontSize:'24px',
					color:'black'
				}
			}
		  },
		},
		fill: {
          type: 'gradient',
		  colors:'#18b1ea',
          gradient: {
              shade: 'dark',
              shadeIntensity: 0.15,
              inverseColors: false,
              opacityFrom: 1,
              opacityTo: 1,
              stops: [0, 50, 65, 91]
          },
        },
        stroke: {
			lineCap: 'round',
		  colors:'#18b1ea'
        },
		labels: [''],
		};

		var chart = new ApexCharts(document.querySelector("#radialBar"), options);
		chart.render();
	}
	/* Function ============ */
		return {
			init:function(){
			},
			
			
			load:function(){
				chartBar();
				donutChart1();
				donutChart2();
				widgetChart1();
				radialBar();
			},
			
			resize:function(){
				
			}
		}
	
	}();

	jQuery(document).ready(function(){
	});
		
	jQuery(window).on('load',function(){
		setTimeout(function(){
			dzChartlist.load();
		}, 1000); 
		
	});

	jQuery(window).on('resize',function(){
		
		
	});     

})(jQuery);