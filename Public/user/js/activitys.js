$(function() {
	//倒计时
	timer.run({
		//endTime: $(".js-user-activity-start-time").attr("data-start-time"),
		//runEndTime: $(".js-user-activity-run-start-time").attr("data-run-start-time"),
		
		endTime: $(".user-activity-qf-time").attr("data-start-time"),
		runEndTime: $(".user-activity-qf-time").attr("data-run-start-time"),
		callback: function() {
			/** $(".user-activity-room").show(); */
			/*$(".user-activity-btn")
				.text('点击抢购')
				.addClass("user-activity-btn-active")
				.addClass("js-user-activity-btn");	
			$(".js-user-activity-run-start-time").text("点击以抢购房间！");
			*/
			$is_fqgm=$(".js-user-activity-id").attr("is_fqgm");
			if ($is_fqgm==0)
			{
				$(".user-activity-qfwks").hide();
				$(".user-activity-qfbegin").show();
				$(".user-activity-qf-time").css("font-size","19px").text("活动进行中，点击进行抢购！");
			}
		},
		elements: {
			day: '',
			hour: $(".user-activity-time-hour"),
			minute: $(".user-activity-time-minute"),
			second: $(".user-activity-time-second"),
		},
	});

	//抽奖
	//run_game($(".js-user-activity-run-start-time").attr("data-run-start-time"), function(over) {
	run_game($(".user-activity-qf-time").attr("data-run-start-time"), function(over) {
		if (over == true) {
			/*$(".user-activity-btn")
				.text('活动已结束')
				.removeClass("user-activity-btn-active")
				.removeClass("js-user-activity-btn");
			*/	
			
			$(".user-activity-btn1").text("活动已结束");
			
			
			$jxgmdjs=$(".js-user-activity-id").attr("jxgmdjs");
			$is_fqgm=$(".js-user-activity-id").attr("is_fqgm");
			if ($jxgmdjs>0 && $is_fqgm>1)
			{
				var $html = $(".user-activity-room-all").html();
				$(".user-activity-room-all").empty();
				layer_html($html, 'auto');
				timer_djs($jxgmdjs-1);
				
				$(".layui-m-layershade").remove();
				$("#zz01").show();
				
				setTimeout(function(){
					window.location.reload();
				}, $jxgmdjs*1000);
			}

		} else {
			/*$(".user-activity-btn")
				.text('活动结束')
				.removeClass("user-activity-btn-active")
				.removeClass("js-user-activity-btn");
			
			$(".js-user-activity-run-start-time").text("活动结束");
			*/
			//$(".user-activity-btn1").text("活动已结束");

			var $url = activity_url.prize;
			var $activity_id = $(".js-user-activity-id").attr("data-activity-id");
			
			var $data = {
				id: $activity_id,
			};

			ajax_post_callback($url, $data, function(data) {
				if (data['status'] == 1) {
					var $html = $(".user-activity-room-all").html();
					$(".user-activity-room-all").empty();
					layer_html($html, 'auto');
					timer_djs(59);
					
					$(".layui-m-layershade").remove();
					$("#zz01").show();
					
					setTimeout(function(){
						window.location.reload();
					}, 60*1000);
					return false;
				} else {
					setTimeout(function() {
						//window.location.href="/user/activity/info/id/"+$activity_id;
						window.location.reload();
					}, 1000);
				}
				
				return false;
			});
			
			return false;
		}
	});
	
	//点击抢房
	$('.user-activity-btns').on('click', '.js-user-activity-btn', function() {
		var $url = activity_url.click;
		var $activity_id = $(".js-user-activity-id").attr("data-activity-id");
		
		var $data = {
			id: $activity_id,
		};

		$(".js-user-activity-btn").attr("src","../../Public/user/img/activity/003_1.png"); 

		ajax_post_callback($url, $data, function(data) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
			}
			setTimeout(function(){
				$(".js-user-activity-btn").attr("src","../../Public/user/img/activity/003.png"); 
			}, 10);
			return false;
		});
		
		return false;
	});
	
	//取消中奖
	$(document).on("click", ".js-user-activity-room-cancel-btn", function() {
		layer_footer_confirm("确认取消购买吗？", function() {
			layer_close_all();		
			
			$(".user-activity-qfbegin").hide();
			$(".user-activity-btn1").text("已放弃本次购买权");
			$(".user-activity-qfwks").show();
			$(".js-user-activity-id").attr("is_fqgm","1")
			$("#zz01").hide();
			
			//window.location.reload();
			//$(".user-activity-qf-time").css("font-size","19px").text("活动进行中，点击进行抢购！");
			
			var $url = activity_url.qx_buy;
			var $activity_id = $(".js-user-activity-id").attr("data-activity-id");
			var $data = {
				id: $activity_id,
			};
			ajax_post_callback($url, $data, function(data) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
				}
			});
			
		}, function() {
			return false;
		});
		
		return false;
	});
	
	//中奖后购买 - 确认
	$(document).on("click", ".js-user-activity-room-confirm-btn", function() {
		var $url = activity_url.buy_room;
		var $activity_id = $(".js-user-activity-id").attr("data-activity-id");
		var $phone = $(".js-user-activity-room-phone").val();
		
		if ($phone == '') {
			layer_alert('请输入手机号！');
		}
		if (!validate_mobile($phone)) {
			layer_alert('手机号有误，请重新输入！');
		}
		
		var $activity_id = $(".js-user-activity-id").attr("data-activity-id");
		
		var $data = {
			id: $activity_id,
			phone: $phone,
		};
		
		ajax_post_callback($url, $data, function(data) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			}
			
			layer_alert(data['info']);
			
			setTimeout(function(){
				layer_close_all();
				window.location.href="/user/activity/info/id/"+$activity_id;
			}, 20);
			return false;
		});
	
		return false;
	});
	
});



















