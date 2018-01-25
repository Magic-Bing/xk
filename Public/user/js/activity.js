/**
 * 倒计时
 *
 * @create 2016-10-24
 * @author zlw
 */
;(function(window) {
	"use strict";
	
	var timer = {
		config : {
			time: 1000,
			endTime: '2016/10/24 16:47:00',
			runEndTime: '2016/10/24 17:47:00',
			callback: function() {},
			simple: false,
			elements: {
				day: '',
				hour: '',
				minute: '',
				second: '',
			},
		},
		extend: function() {
			var _extend = function(dest, source) {
				for (var name in dest) {
					if (dest.hasOwnProperty(name)) {
						if (dest[name] instanceof Object && source[name] instanceof Object) {
							_extend(dest[name], source[name]);
						}
						if (source.hasOwnProperty(name)) {
							continue;
						} else {
							source[name] = dest[name];
						}
					}
				}
			};
			var _result = {}, arr = arguments;
			if (!arr.length) return {};
			for (var i = arr.length - 1; i >= 0; i--) {
				_extend(arr[i], _result);
			}
			arr[0] = _result;
			return _result;
		},
		useTime: null,
		runTime: function() {
			var config = this.config;
			
			var EndTime = new Date(config.endTime); //截止时间 
			var runEndTime = new Date(config.runEndTime); 
			var NowTime = new Date();
			var time = EndTime.getTime() - NowTime.getTime();
			
			var day = '00',
				hour = '00',
				minute = '00',
				second = '00';
			
			if (time >= 0) {
				day = Math.floor(time/1000/60/60/24).toString();
				hour = Math.floor(time/1000/60/60%24).toString();
				minute = Math.floor(time/1000/60%60).toString();
				second = Math.floor(time/1000%60).toString();
				
				if (config.simple != true) {
					if (hour < 10) {
						hour = '0' + hour;
					}
					if (minute < 10) {
						minute = '0' + minute;
					}
					if (second < 10) {
						second = '0' + second;
					}
				}
			} else {
				clearInterval(this.useTime);
				
				var checkTime = runEndTime.getTime() - NowTime.getTime();
				if (checkTime > 0) {
					config.callback.call(this);
				}
			}

			var elements = config.elements;
			
			//天
			if (elements.day != '' && elements.day != undefined) {
				elements.day.text(day);
			}
			//小时
			if (elements.hour != '' && elements.hour != undefined) {
				elements.hour.text(hour);
			}
			//分
			if (elements.minute != '' && elements.minute != undefined) {
				elements.minute.text(minute);
			}
			//秒
			if (elements.second != '' && elements.second != undefined) {
				elements.second.text(second);	
			}
		},
		run: function(config) {
			var that = this,
				config = config || {};
			that.config = that.extend(that.config, config);
			
			that.useTime = setInterval(function() {
				that.runTime();
			}, that.config.time)
		}
	};
	
	window.timer = timer;
})(window);


/**
 * 结束抽奖
 *
 * @create 2016-10-25
 * @author zlw
 */
function run_game(time, callback) { 
	var $run_end_time = time;
	var $end_time = new Date($run_end_time); 
	var $now_time = new Date();
	var $time = $end_time.getTime() - $now_time.getTime();
	var $over = false;
	if ($time > 0) {
		setTimeout(function() {
			callback.call(this, $over);
		}, $time);
		show_prize();
	} else {
		$over = true;
		callback.call(this, $over);
	}
}

function show_prize(){

	$jxgmdjs=$(".js-user-activity-id").attr("jxgmdjs");
	$is_fqgm=$(".js-user-activity-id").attr("is_fqgm");
	if ($jxgmdjs>0 && $is_fqgm>1)
	{
		var $html = $(".user-activity-room-all").html();
		$(".user-activity-room-all").empty();
		layer_html($html, 'auto');
		timer_djs($jxgmdjs-1);
		
		//$(".layui-m-layershade").removeAttr("onclick");
		//$('.layui-m-layershade').unbind("click")
		$(".layui-m-layershade").remove();
		
		setTimeout(function(){
			window.location.reload();
		}, $jxgmdjs*1000);
	}
}

$(".layui-m-layershade").click(function(event) { 	
	event.preventDefault();    //阻止 <span> 的 click 事件冒泡  
	 
});  
