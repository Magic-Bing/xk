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



$(function() {
	//竞价
	$(".js-Auction").click(function() {
		var $id=20;
		var $choose_id=22;
		var $amount=$(".Auction-input").val();
		var $yamount=$("#li_dqmoney").attr("data_dqmoney");
		if($amount==0)
		{
			layer_alert("当前出价不能为0");
			return false;
		}
		if($amount==$yamount)
		{
			layer_alert("当前出价未改变");
			return false;
		}
		var $data = {
			id: $id,
			choose_id:$choose_id,
			amount: $amount,
		};
		var $url = auction_url.click;
		ajax_post_callback($url, $data, function(data) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			}
			window.location.href="auction"
			return true;
		});
		
	});
	
})

//获取竞拍结果(暂时未使用)
function get_auctionjg()
{
	var $id=20;
	var $choose_id=22;
	var $data = {
		id: $id,
		choose_id:$choose_id,
	};
	var $url = auction_url.result;
	ajax_post_callback($url, $data, function(data) {
		if (data['status'] != 1) {
			layer_alert(data['info']);
			return false;
		}
		
		window.location.href="auction/result"
		return true;
	});
}

