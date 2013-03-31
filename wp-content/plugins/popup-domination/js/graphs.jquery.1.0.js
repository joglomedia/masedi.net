/*!
 * jQuery Graphs v 1.0
 * http://deerdigital.com/
 *
 * Copyright 2011-, Deer Digital
 *
 * Date: Thu Oct 6 10:39:00 2011 -0000
 */


(function($){

	$.fn.graphs = function(options) {
	
		var defaults = {  
			type: 'bar',  
			data: "empty",  
			container: "empty"
		};
		
		var options = $.extend(defaults, options);
		
		return this.each(function() {
			if(options.data == 'empty' || options.container == 'empty'){
				alert('You have not selected a table or a container, please make sure you have defined these when calling the plugin');
			}else{
				createGraph(options.data, options.container, options.type);
			}
			
			
		});
	
	}
	
	function createGraph(data, container, type){
		var bars = [];
		var lines = [];
		var figureContainer = $('<div id="figure"></div>');
		var graphContainer = $('<div class="graph" id="graph"></div>');
		var barContainer = $('<div class="bars"></div>');
		var lineContainer = $('<div class="hold"><canvas id="canvas"></canvas></div>');
		var data = $(data);
		var container = $(container);
		var chartData;		
		var chartYMax;
		var columnGroups;
		var barTimer;
		var graphTimer;
		
		var tableData = {
			chartData: function() {
				var chartData = [];
				data.find('tbody td').each(function() {
					chartData.push($(this).text());
				});
				return chartData;
			},
			chartHeading: function() {
				var chartHeading = data.find('caption').text();
				return chartHeading;
			},
			chartLegend: function() {
				var chartLegend = [];
				data.find('tbody th').each(function() {
					chartLegend.push($(this).text());
				});
				return chartLegend;
			},
			chartYMax: function() {
				var chartData = this.chartData();
				var chartYMax = Math.ceil(Math.max.apply(Math, chartData) / 1) * 1;
				return chartYMax;
			},
			yLegend: function() {
				var chartYMax = this.chartYMax();
				var yLegend = [];
				var yAxisMarkings = 5;						
				for (var i = 0; i < yAxisMarkings; i++) {
					yLegend.unshift(((chartYMax * i) / (yAxisMarkings - 1)) / 1);
				}
				return yLegend;
			},
			xLegend: function() {
				var xLegend = [];
				data.find('thead th').each(function() {
					xLegend.push($(this).text());
				});
				return xLegend;
			},
			columnGroups: function() {
				var columnGroups = [];
				var columns = data.find('tbody tr:eq(0) td').length;
				for (var i = 0; i < columns; i++) {
					columnGroups[i] = [];
					data.find('tbody tr').each(function() {
						columnGroups[i].push($(this).find('td').eq(i).text());
					});
				}
				return columnGroups;
			}
		}
		chartData = tableData.chartData();		
		chartYMax = tableData.chartYMax();
		columnGroups = tableData.columnGroups();
		if(type == 'line'){
			lineContainer.appendTo(container);
		}
		$.each(columnGroups, function(i) {
			var barGroup = $('<div class="bar-group"></div>');
			for (var j = 0, k = columnGroups[i].length; j < k; j++) {
				var barObj = {};
				barObj.label = this[j];
				if(type == 'line'){
					barObj.height = Math.floor((barObj.label / chartYMax * 100)-2) + '%';
				}else{
					barObj.height = Math.floor(barObj.label / chartYMax * 100) + '%';
				}	
				barObj.bar = $('<div class="bar fig' + j + '"><span>' + barObj.label + '</span></div>')
					.appendTo(barGroup);
				bars.push(barObj);
			}
			barGroup.appendTo(barContainer);			
		});
		var chartHeading = tableData.chartHeading();
		var heading = $('<h4>' + chartHeading + '</h4>');
		heading.appendTo(figureContainer);
		var chartLegend	= tableData.chartLegend();
		var legendList	= $('<ul class="legend"></ul>');
		$.each(chartLegend, function(i) {		
			var listItem = $('<li><span class="icon fig' + i + '"></span>' + this + '</li>')
				.appendTo(legendList);
		});
		legendList.appendTo(figureContainer);
		
		var xLegend	= tableData.xLegend();		
		var xAxisList	= $('<ul class="x-axis"></ul>');
		$.each(xLegend, function(i) {
			
			if(this.length >= 2){
			var listItem = $('<li><span>' + this + '</span></li>')
				.appendTo(xAxisList);
			}
		});
		xAxisList.appendTo(graphContainer);
		
		var yLegend	= tableData.yLegend();
		var yAxisList	= $('<ul class="y-axis"></ul>');
		$.each(yLegend, function(i) {			
			var listItem = $('<li><span>' + this + '</span></li>')
				.appendTo(yAxisList);
		});
		yAxisList.appendTo(graphContainer);		
		
		barContainer.appendTo(graphContainer);		
		
		graphContainer.appendTo(figureContainer);
		
		figureContainer.appendTo(container);
		
		function displayGraph(bars, i) {
			if(type == 'line'){	
				if (i < bars.length) {
					$(bars[i].bar).animate({
						bottom: bars[i].height
					}, 800);
					barTimer = setTimeout(function() {
						i++;				
						displayGraph(bars, i);
					}, 100);
				}else{
					setTimeout(function() {		
						updateCanvas($("#canvas"), $(".blk"));
					}, 1000);
				}
			}else{
				if (i < bars.length) {
					$(bars[i].bar).animate({
						height: bars[i].height
					}, 800);
					barTimer = setTimeout(function() {
						i++;				
						displayGraph(bars, i);
					}, 100);
				}
			}
		}
		
		function resetGraph() {
			if(type == 'line'){
				$.each(bars, function(i) {
					$(bars[i].bar).stop().css('height', 10);
				});
				$.each(lines, function(i) {
					$(lines[i].bar).stop().css('height', 10);
				});
			}else{
				$.each(bars, function(i) {
					$(bars[i].bar).stop().css('height', 0);
				});
			}
			
			clearTimeout(barTimer);
			clearTimeout(graphTimer);

			graphTimer = setTimeout(function() {		
				displayGraph(bars, 0);
			}, 200);
		}
		resetGraph();
		
		resetGraph();
	
	}
	
	function updateCanvas(canvasJq, blkEls)
		{
		var nodes = $('.legend li').length;
		var i = 0;
		var c = 0;
		var k = 0;
		while(i < nodes){
			$('.bar-group .fig'+i).each(function(index) {
				var now = index + k;
				var next = now +1;
				var css = $(this).css('bottom');
				$(this).append('<div id="blk-'+ now + '" class="blk"><div id="'+now+'" rel="'+next+'"></div></div>');
				c = now;
			});
			k = c + 2;
			i++;
		}
		var canvasEl = canvasJq[0];
		canvasEl.width=canvasJq.width();
		canvasEl.height=canvasJq.height();
		var cOffset = canvasJq.offset();
		var ctx = canvasEl.getContext("2d");
		ctx.clearRect(0, 0, canvasEl.width, canvasEl.height);
		i = 0;
		while(i < nodes){
			var color = $('.fig'+i).css('background-color');
			ctx.beginPath();
			$('.fig'+i).each(function(){
				$("div", this).each(function(){
					var li=$(this);
					if(li.attr("rel")){
						var srcOffset=li.offset();
						var srcMidHeight=li.height()/2;
						var targetLi=$("#"+li.attr("rel"));
						if(targetLi.length){
							var trgOffset=targetLi.offset();
							var trgMidHeight=li.height()/2;
							ctx.moveTo(srcOffset.left - cOffset.left, srcOffset.top - cOffset.top + srcMidHeight);
							ctx.lineTo(trgOffset.left - cOffset.left, trgOffset.top - cOffset.top + trgMidHeight);
						}
					}
				});
			});
			ctx.strokeStyle = color;
			ctx.stroke();
			ctx.closePath();
			i++;
		}

		$(document).ready(function(){	
			$('#canvas').css('z-index', '1').hide().fadeIn();
		});
	
	}

})(jQuery);

