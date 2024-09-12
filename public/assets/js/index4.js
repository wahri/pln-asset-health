$(function () {
	"use strict";
	// chart 1
	Highcharts.chart('chart1', {
		chart: {
			height: 350,
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie',
			styledMode: true
		},
		credits: {
			enabled: false
		},
		title: {
			text: 'Engine Hall Block 1'
		},
		subtitle: {
			text: 'Ratio of systems monitored'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				innerSize: 120,
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.percentage:.1f} %'
				},
				showInLegend: true
			}
		},
		//colors: ['#ff9ad5', '#50b5ff', '#5a65dc'],
		series: [{
			name: 'Unit',
			colorByPoint: true,
			data: [{
				name: 'Normal',
				y: 85
			}, {
				name: 'Abnormal',
				y: 10
			}, {
				name: 'Fault',
				y: 5
			}]
		}],
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					plotOptions: {
						pie: {
							innerSize: 140,
							dataLabels: {
								enabled: false
							}
						}
					},
				}
			}]
		}
	});
	Highcharts.chart('chart2', {
		chart: {
			height: 350,
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie',
			styledMode: true
		},
		credits: {
			enabled: false
		},
		title: {
			text: 'Engine Hall Block 2'
		},
		subtitle: {
			text: 'Ratio of systems monitored'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				innerSize: 120,
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.percentage:.1f} %'
				},
				showInLegend: true
			}
		},
		//colors: ['#ff9ad5', '#50b5ff', '#5a65dc'],
		series: [{
			name: 'Unit',
			colorByPoint: true,
			data: [{
				name: 'Normal',
				y: 75
			}, {
				name: 'Abnormal',
				y: 20
			}, {
				name: 'Fault',
				y: 5
			}]
		}],
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					plotOptions: {
						pie: {
							innerSize: 140,
							dataLabels: {
								enabled: false
							}
						}
					},
				}
			}]
		}
	});
	Highcharts.chart('chart3', {
		chart: {
			height: 350,
			plotBackgroundColor: null,
			plotBorderWidth: null,
			plotShadow: false,
			type: 'pie',
			styledMode: true
		},
		credits: {
			enabled: false
		},
		title: {
			text: 'Engine Hall Block 3'
		},
		subtitle: {
			text: 'Ratio of systems monitored'
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		accessibility: {
			point: {
				valueSuffix: '%'
			}
		},
		plotOptions: {
			pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				innerSize: 120,
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.percentage:.1f} %'
				},
				showInLegend: true
			}
		},
		//colors: ['#ff9ad5', '#50b5ff', '#5a65dc'],
		series: [{
			name: 'Unit',
			colorByPoint: true,
			data: [{
				name: 'Normal',
				y: 95
			}, {
				name: 'Abnormal',
				y: 5
			}, {
				name: 'Fault',
				y: 0
			}]
		}],
		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
				chartOptions: {
					plotOptions: {
						pie: {
							innerSize: 140,
							dataLabels: {
								enabled: false
							}
						}
					},
				}
			}]
		}
	});

	// chart 2
	var options = {
		series: [{
			name: 'Normal',
			data: [94, 55, 57, 56, 61, 58, 63, 60, 66]
		}, {
			name: 'Abnormal',
			data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
		}, {
			name: 'Fault',
			data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
		}],
		chart: {
			foreColor: '#9a9797',
			type: 'bar',
			height: 320,
			stacked: true,
			toolbar: {
				show: false
			},
		},
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '18%',
				//endingShape: 'rounded'
			},
		},
		legend: {
			show: false,
			position: 'top',
			horizontalAlign: 'left',
			offsetX: -20
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		colors: ["#198754", "#ffc107", "#dc3545"],
		xaxis: {
			categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
		},
		fill: {
			opacity: 1
		},
		grid: {
			show: true,
			borderColor: 'rgba(0, 0, 0, 0.15)',
			strokeDashArray: 4,
		},
		responsive: [{
			breakpoint: 480,
			options: {
				chart: {
					height: 310,
				},
				plotOptions: {
					bar: {
						columnWidth: '30%'
					}
				}
			}
		}]
	};
	var chart = new ApexCharts(document.querySelector("#chart4"), options);
	chart.render();
	var options = {
		series: [{
			name: 'Normal',
			data: [94, 55, 57, 56, 61, 58, 63, 60, 66]
		}, {
			name: 'Abnormal',
			data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
		}, {
			name: 'Fault',
			data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
		}],
		chart: {
			foreColor: '#9a9797',
			type: 'bar',
			height: 320,
			stacked: true,
			toolbar: {
				show: false
			},
		},
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '18%',
				//endingShape: 'rounded'
			},
		},
		legend: {
			show: false,
			position: 'top',
			horizontalAlign: 'left',
			offsetX: -20
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		colors: ["#198754", "#ffc107", "#dc3545"],
		xaxis: {
			categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
		},
		fill: {
			opacity: 1
		},
		grid: {
			show: true,
			borderColor: 'rgba(0, 0, 0, 0.15)',
			strokeDashArray: 4,
		},
		responsive: [{
			breakpoint: 480,
			options: {
				chart: {
					height: 310,
				},
				plotOptions: {
					bar: {
						columnWidth: '30%'
					}
				}
			}
		}]
	};
	var chart = new ApexCharts(document.querySelector("#chart5"), options);
	chart.render();
	var options = {
		series: [{
			name: 'Normal',
			data: [94, 55, 57, 56, 61, 58, 63, 60, 66]
		}, {
			name: 'Abnormal',
			data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
		}, {
			name: 'Fault',
			data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
		}],
		chart: {
			foreColor: '#9a9797',
			type: 'bar',
			height: 320,
			stacked: true,
			toolbar: {
				show: false
			},
		},
		plotOptions: {
			bar: {
				horizontal: false,
				columnWidth: '18%',
				//endingShape: 'rounded'
			},
		},
		legend: {
			show: false,
			position: 'top',
			horizontalAlign: 'left',
			offsetX: -20
		},
		dataLabels: {
			enabled: false
		},
		stroke: {
			show: true,
			width: 2,
			colors: ['transparent']
		},
		colors: ["#198754", "#ffc107", "#dc3545"],
		xaxis: {
			categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
		},
		fill: {
			opacity: 1
		},
		grid: {
			show: true,
			borderColor: 'rgba(0, 0, 0, 0.15)',
			strokeDashArray: 4,
		},
		responsive: [{
			breakpoint: 480,
			options: {
				chart: {
					height: 310,
				},
				plotOptions: {
					bar: {
						columnWidth: '30%'
					}
				}
			}
		}]
	};
	var chart = new ApexCharts(document.querySelector("#chart6"), options);
	chart.render();
});