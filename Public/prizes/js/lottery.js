/**
 * 例子
 * 
 * <script src="__COMMON__/js/probability.js"></script>
 * <script src="__PUBLIC__/prizes/js/lottery.js"></script>
 *
 * @create 2016-9-21
 * @author zlw
 */


/**
 * 中奖
 *
 * @create 2016-9-20
 * @author zlw
 *
*/
$(function() {
	"use strict";
	
	lottery(user_url.lottery);	
});


/**
 * 中奖
 *
 * @create 2016-9-20
 * @author zlw
 *
*/
function lottery($url, $data) {
	var $url = $url || user_url.lottery;
	
	if (typeof Probability === 'function') {
		var prob = [1, 5, 10, 15, 21, 50, 100];
		var lotIndex = new Probability(prob).get();
		if (prob[lotIndex] != 100) {
			return false;
		}
	}
	
	$.ajax({
		url: $url,
		data: $data || {},
		type: 'POST',
		dataType: 'JSON',
		success: function(data, status) {
			if (data['status'] != 1) {
				return false;
			} 
			
			var $info = data.info;
			$("body").append($info.trim());
			
			return false;
		},
		error: function (data, status, e) {
			layer_alert('提交连接失败！');
		}
	}); 
	
};

