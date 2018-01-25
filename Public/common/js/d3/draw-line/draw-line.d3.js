

/**
 * 画折线图
 *
 * @create 2016-9-27
 * @author zlw
 */
function draw_line($time, $svg_id) {
	var data = $time.map(function(item, i) {
		return {
			date: item.time, 
			quantity: item.quantity,
		}
	});

	// 定义circle的半径
	var r0 = 5,
		r1 = 8;

	// 定义动画持续时间
	var duration = 500;

	var margin = {top: 30, right: 20, bottom: 30, left: 25},
		width = document.body.clientWidth - margin.left - margin.right,
		height = 220 - margin.top - margin.bottom;

	var parseDate = d3.time.format('%H:%M').parse;

	var x = d3.time.scale()
		.range([10, width - 10]);

	var y = d3.scale.linear()
		.range([height, 15]);

	var xAxis = d3.svg.axis()
		.scale(x)
		.orient('bottom')
		.tickFormat(d3.time.format('%H:%M'))
		.ticks(6);

	var yAxis = d3.svg.axis()
		.scale(y)
		.orient('left')
		.ticks(5);

	var xGridAxis = d3.svg.axis()
		.scale(x)
		.orient('bottom');

	var yGridAxis = d3.svg.axis()
		.scale(y)
		.orient('left');

	var line = d3.svg.line()
		.x(function(d) { return x(d.date); })
		.y(function(d) { return y(d.quantity); })
		.interpolate('linear');
	// interpolate参数有
	// linear，step-before，step-after，
	// basis，basis-open，basis-closed，
	// bundle，cardinal，cardinal-open，
	// cardinal-closed，monotone

	var flagLine = d3.svg.line()
		.x(function(d) { return x(d.x); })
		.y(function(d) { return y(d.y); });

	var container = d3.select($svg_id)
		.append('svg')
		.attr('width', width + margin.left + margin.right)
		.attr('height', height + margin.top + margin.bottom);

	var svg;

	show();
	
	function show() {
		svg = container.append('g')
			.attr('class', 'content')
			.attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');

		draw();
	}
	
	function draw() {
		data.forEach(function(d) {
			d.dayText = d.date;
			d.date = parseDate(d.date);
			d.quantity = +d.quantity;
		});

		x.domain(d3.extent(data, function(d) { return d.date; }));
		y.domain([0, d3.max(data, function(d) { return d.quantity; })]);
	  
		//画X轴
		svg.append('g')
			.attr('class', 'x axis')
			.attr('transform', 'translate(0,' + height + ')')
			.call(xAxis);

		//画Y轴
		svg.append('g')
			.attr('class', 'y axis')
			.call(yAxis);

		// svg.append('g')
		//   .attr('class', 'grid')
		//   .attr('transform', 'translate(0,' + height + ')')
		//   .call(xGridAxis.tickSize(-height, 0, 0).tickFormat(''));

		//Y轴虚线
		svg.append('g')
			.attr('class', 'grid')
			.call(yGridAxis.tickSize(-width, 0, 0).tickFormat(''));

		//折线
		var path = svg.append('path')
			.attr('class', 'line')
			.attr('d', line(data))
			.style('stroke', '#FFF')
			.transition()
			.duration(duration)
			.ease("elastic")  
			.delay(function(d,i){  
				return 500;  
			})
			.style('stroke', 'steelblue');

		//描点
		var g = svg.selectAll('circle')
			.data(data)
			.enter()
			.append('g')
			.append('circle')
			.on('mouseover', function() {
				d3.select(this).transition().duration(duration).attr('r', r1);
			})
			.on('mouseout', function() {
				d3.select(this).transition().duration(duration).attr('r', r0);
			})
			.attr('class', 'linecircle')
			.attr('cx', line.x())
			.attr('cy', line.y())
			.transition()
			.duration(duration)
			.ease("elastic")  
			.delay(function(d,i){  
				return 200*i;  
			})
			.attr('r', r0);
		
		//标注文字
		var innerText = svg.append("text")
			.attr("transform", "translate(0, -8)")
			.attr("text-anchor", "middle")
			.attr("fill", "#333")
			.style("font-size", '14px');
		
		//添加文字
		innerText.selectAll("tspan")
			.data(data)
			.enter()
			.append("tspan")
			.attr("x", line.x())
			.transition()
			.duration(duration)
			.ease("elastic")  
			.delay(function(d, i) {  
				return 200*i;  
			})
			.attr("y", line.y())
			.attr("fill", function(data, i){//填充颜色
				return '#333';
			})
			.style("font-size", function(data, i){//字体
				return '10px';
			})
			.text(function(data){
				return data.quantity;
			});	

		//X添加下横线
		var xline = svg.append('line')
			.attr('class', 'x-line')
			.attr('x1', -6)
			.attr('y1', 0)
			.attr('x2', width)
			.attr('y2', 0)
			.attr('transform', 'translate(0,' + y(0) + ')');

		//Y添加左竖线
		svg.append('line')
		   .attr('class', 'flag')
		   .attr('x1', 0)
		   .attr('y1', 0)
		   .attr('x2', 0)
		   .attr('y2', y(0));
		
		/*			
		d3.selectAll("g.x text")  
			.attr("x", 15);  
		*/
  
	}
}
