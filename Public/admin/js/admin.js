//通用
$(function() {
	"use strict";

	//房间附加属性保存
	$(".js-room-attr-rooms-save-btn").click(function() {
		var $url = room_url.attr_save;
		var $this = $(this);
		var $id = $this.attr('data-id');
		var $now_room = $(".room-attr-rooms-table-list-" + $id);
		
		var $collection = $now_room.find(".room-attr-rooms-collection").val();
		var $comparison = $now_room.find(".room-attr-rooms-comparison").val();
		var $follow = $now_room.find(".room-attr-rooms-follow").val();
		
		var $data = {
			room_id: $id,
			collection: $collection,
			comparison: $comparison,
			follow: $follow,
		}
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('修改成功！');
				
				setTimeout(function() {
					window.location.reload();
				}, 550);
			}			
		});
	});
	
	//项目切换
	$(".js-room-attr-search-select").change(function() {
		var $project_id = $(".js-room-attr-search-select").find("option:selected").val();

		window.location.href = room_url.index + '?project_id=' + $project_id;
		
		return false;
	});	
	
	//导出模板提示
	$('.js-room-export-btn').on('click', function() {
		layer_alert('项目不存在，请选择项目后重试！');
		
		return false;
	});
	
	//房间 - 提交修改
	$('.js-room-edit-btn-save').on('click', function() {
		var $id = $(".room-id").val();
		var $build = $(".room-edit-select").find("option:selected").val();
		var $unit = $(".room-edit-input-unit").val();
		var $floor = $(".room-edit-input-floor").val();
		var $no = $(".room-edit-input-no").val();
		var $area = $(".room-edit-input-area").val();
		var $tnarea = $(".room-edit-input-tnarea").val();
		var $price = $(".room-edit-input-price").val();
		var $tnprice = $(".room-edit-input-tnprice").val();
		var $total = $(".room-edit-input-total").val();
		
		var $empty = false;
		if ($id == '') {
			layer_alert('房间不存在，请确认后重试！');
			return false;
		}
		
		if ($unit == '') {
			$(".room-edit-input-unit").addClass("room-edit-input-empty");
			$empty = true;
		}
		if ($floor == '') {
			$(".room-edit-input-floor").addClass("room-edit-input-empty");
			$empty = true;
		}
		if ($no == '') {
			$(".room-edit-input-no").addClass("room-edit-input-empty");
			$empty = true;
		}
		if ($area == '') {
			$(".room-edit-input-area").addClass("room-edit-input-empty");
			$empty = true;
		}
		if ($tnarea == '') {
			$(".room-edit-input-tnarea").addClass("room-edit-input-empty");
			$empty = true;
		}
		if ($price == '') {
			$(".room-edit-input-price").addClass("room-edit-input-empty");
			$empty = true;
		}
		if ($tnprice == '') {
			$(".room-edit-input-tnprice").addClass("room-edit-input-empty");
			$empty = true;
		}
		if ($total == '') {
			$(".room-edit-input-total").addClass("room-edit-input-empty");
			$empty = true;
		}
		
		if ($empty == true) {
			layer_alert('必填项不能为空，请确认后重试！');
			return false;
		}
		
		var $hx = $(".room-edit-input-hx").val();
		
		var $data = {
			'id': $id,
			'hx': $hx,
			'build': $build,
			'unit': $unit,
			'floor': $floor,
			'no': $no,
			'area': $area,
			'tnarea': $tnarea,
			'price': $price,
			'tnprice': $tnprice,
			'total': $total,
		}
		
		var $url = room_url.edit;
		ajax_post_callback($url, $data, function($data) {
			if ($data['status'] != 1) {
				layer_alert($data['info']);
				return false;
			}
			
			layer_alert('更改房间信息成功！');
			
			setTimeout(function() {
				window.location.reload();
			}, 350);
		});
	
		return false;
	});

	//活动添加
	$(".js-room-game-save-btn").click(function() {
		var $url = game_url.add;
		
		var $title = $(".room-add-game-title").val();
		var $room_id = $("#room_id").attr("data-id");
		var $start_time = $(".room-add-game-start-time").val();
		var $end_time = $(".room-add-game-end-time").val();
		var $allow_num = $(".room-add-game-allow-num").val();
		var $use_num = $(".room-add-game-use-num").val();
		var $time_length = $(".room-add-game-time-length").val();
		var $content = $(".room-add-game-content").val();
		var $is_open = $(".room-add-game-is-open").find("option:selected").val();
		
		if ($start_time == '') {
			layer_alert('开始时间不能为空！');
			return false;
		}
		if ($end_time != '' ) {
			var $start_time_format = new Date($start_time.replace(/-/g,"/"));   
			var $end_time_format = new Date($end_time.replace(/-/g,"/")); 
			
			if ($start_time_format > $end_time_format) {			
				layer_alert('开始时间不能大于结束时间！');
				return false;
			}
		}
		
		var $data = {
			title: $title,
			room_id: $room_id,
			start_time: $start_time,
			end_time: $end_time,
			allow_num: $allow_num,
			use_num: $use_num,
			time_length: $time_length,
			content: $content,
			is_open: $is_open,
		}
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('添加活动成功！');
				
				setTimeout(function() {
					window.location.reload();
				}, 550);
			}			
		});
	});

	//活动删除
	$(".js-room-game-delete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = game_url.delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除活动成功！');
					
					setTimeout(function() {
						$(".room-game-table-list-" + $id).remove();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认删除吗，删除后将不能恢复？', callBack);
	});

	//活动更改
	$(".js-room-game-edit-btn").click(function() {
		var $url = game_url.edit;
		var $id = $(".room-edit-game-id").val();
		var $title = $(".room-edit-game-title").val();
		//var $room_id = $(".room-edit-game-room-id").val();
		var $room_id =$("#room_id").attr("data-id");
		var $start_time = $(".room-edit-game-start-time").val();
		var $next_start_time = $(".room-edit-game-next-start-time").val();
		var $end_time = $(".room-edit-game-end-time").val();
		var $allow_num = $(".room-edit-game-allow-num").val();
		var $use_num = $(".room-edit-game-use-num").val();
		var $time_length = $(".room-edit-game-time-length").val();
		var $content = $(".room-edit-game-content").val();
		var $is_open = $(".room-edit-game-is-open").find("option:selected").val();
		var $is_end = $(".room-edit-game-is-end").find("option:selected").val();
		
		if ($start_time == '') {
			layer_alert('开始时间不能为空！');
			return false;
		}
		if ($end_time != '' ) {
			var $start_time_format = new Date($start_time.replace(/-/g,"/"));   
			var $end_time_format = new Date($end_time.replace(/-/g,"/")); 
			
			if ($start_time_format > $end_time_format) {			
				layer_alert('开始时间不能大于结束时间！');
				return false;
			}
		}
		
		var $data = {
			id: $id,
			title: $title,
			room_id: $room_id,
			start_time: $start_time,
			next_start_time: $next_start_time,
			end_time: $end_time,
			allow_num: $allow_num,
			use_num: $use_num,
			time_length: $time_length,
			content: $content,
			is_open: $is_open,
			is_end: $is_end,
		}
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('更改活动成功！');
				
				setTimeout(function() {
					var $url = game_url.index + '?id=' + $id;
					window.location.href = $url;
				}, 200);
			}			
		});
	});

	//活动抢购 - 删除
	$(".js-room-game-click-delete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = game_url.click_delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {console.log($id);
						$(".room-game-table-list-click-" + $id).remove();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认删除吗，删除后将不能恢复？', callBack);
	});

	//活动中奖 - 删除
	$(".js-room-game-prize-delete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = game_url.prize_delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					$(".room-game-table-list-prize-" + $id).remove();
					
					setTimeout(function() {
						window.location.reload();
					}, 500);
				}			
			});
		}
		
		layer_confirm('确认删除吗，删除后将不能恢复？', callBack);
	});

	//活动中奖 - 更改
	$(".js-room-game-prize-edit-btn").click(function() {
		var $url = game_url.prize_edit;
		
		var $id = $(".room-edit-game-prize-id").val();
		var $time = $(".room-date-game-prize-time").val();
		var $is_buy = $(".room-edit-game-prize-is-buy").find("option:selected").val();
		var $phone = $(".room-edit-game-prize-phone").val();
		var $buy_time = $(".room-date-game-prize-buy-time").val();
		var $code = $(".room-edit-game-prize-code").val();
		var $is_delete = $(".room-edit-game-prize-is-delete").find("option:selected").val();
		var $remark = $(".room-edit-game-prize-remark").val();
		
		if ($time == '') {
			layer_alert('中奖时间不能为空！');
			return false;
		}
		if ($buy_time != '' ) {
			var $time_format = new Date($time.replace(/-/g,"/"));   
			var $buy_time_format = new Date($buy_time.replace(/-/g,"/")); 
			
			if ($time_format > $buy_time_format) {			
				layer_alert('中奖时间不能大于购买时间！');
				return false;
			}
		}
		
		var $data = {
			id: $id,
			time: $time,
			is_buy: $is_buy,
			phone: $phone,
			buy_time: $buy_time,
			code: $code,
			is_delete: $is_delete,
			remark: $remark,
		}
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('更改成功！');
				
				setTimeout(function() {
					var $url = game_url.prize + '?id=' + $id;
					window.location.href = $url;
				}, 500);
			}			
		});
	});
	
	//填写房间,进行搜索
	$(".search-roominfo").bind('input propertychange', function() {
		var $input_str = $(this).val();
		var $proj_id = $(".js-xz-project").find("option:selected").val();
		//var $pc_id="";
		if ($input_str == '' || $input_str.length<2) {
			$(".search-roomlist-ul").html("").hide();
			return false;
		}
		else{		
			$.ajax({
				url: game_url.search_room,
				data: {
					proj_id:$proj_id,
					//pc_id:$pc_id,
					info: $input_str,
				},
				type: 'POST',
				dataType: 'JSON',
				success: function (data, status) {
					if (typeof(data.status) == 'undefined') {
						layer_alert('请求失败，请重试！');
						return false;
					} 
					if (data.status == false) {
						layer_alert(data.info);
						return false;
					}
					
					var $rooms = data.info;
					var $html = [
						'<li class="search-roomlist-li" data-room-id="{ROOM_ID}" data-room-roominfo="{ROOMNAME}" >',
							'<label>',
								'{ROOM_INFO}',
							'</label>',
						'</li>',
					].join("");
					
					var $room_li = '';
					if ($rooms.length > 0) {
						for (var $i = 0; $i < $rooms.length; $i ++) {
							$room_li += $html
								.replace(/{ROOM_ID}/i, $rooms[$i].id)
								.replace(/{ROOMNAME}/i, $rooms[$i].buildname +"-"+ $rooms[$i].unit+"单元"+"-"+$rooms[$i].room)
								.replace(/{ROOM_INFO}/i, $rooms[$i].buildname +"-"+ $rooms[$i].unit+"单元"+"-"+$rooms[$i].room);
						}
						$(".search-roomlist-ul").html($room_li).show();
					} else {
						$(".search-roomlist-ul").html("").hide();
					}
				},
				error: function (data, status, e) {
					layer_alert('提交连接失败！');
				}
			}); 
			
		}
	});
	
	//离开元素
	$(".search-roomlist-div").mouseleave(function() {
		$(".search-roomlist-ul").html("").hide();
	});
	
	
	//选中房间
	$("body").on('click', '.search-roomlist-li', function() {
		var $room_id = $(this).attr('data-room-id');
		var $roominfo = $(this).attr('data-room-roominfo');
		$(".search-roominfo").val($roominfo);
		$(".search-roominfo").attr("data-id",$room_id);
		$(".search-roomlist-ul").hide();
	});
	
	/**===================== 推广奖励 =======================**/
	
	
	//推广奖励 - 项目切换
	$(".js-room-reward-search-select").change(function() {
		var $project_id = $(".js-room-reward-search-select").find("option:selected").val();

		window.location.href = reward_url.option + '?project_id=' + $project_id;
		
		return false;
	});	

	//推广奖励 - 添加
	$(".js-reward-add-btn-save").click(function() {
		var $url = reward_url.option_add;
		
		var $project_id = $(".js-reward-add-project-id").find("option:selected").val();
		var $one_reward = $(".js-reward-add-one-reward").val();
		var $two_reward = $(".js-reward-add-two-reward").val();
		var $three_reward = $(".js-reward-add-three-reward").val();
		var $lowest_cash = $(".js-reward-add-lowest-cash").val();
		var $end_time = $(".js-reward-add-end-time").val();
		var $status = $(".js-reward-add-status").find("option:selected").val();
		var $remark = $(".js-reward-add-remark").val();
		
		if ($one_reward == '' || $two_reward == '' || $three_reward == '') {
			layer_alert('奖励不能为空！');
			return false;
		}
		if ($lowest_cash == '') {
			layer_alert('提现金额不能为空！');
			return false;
		}
		if ($end_time == '') {
			layer_alert('结束时间不能为空！');
			return false;
		}
		
		var $data = {
			project_id: $project_id,
			one_reward: $one_reward,
			two_reward: $two_reward,
			three_reward: $three_reward,
			lowest_cash: $lowest_cash,
			end_time: $end_time,
			status: $status,
			remark: $remark,
		}
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('添加成功！');
				
				setTimeout(function() {
					var $url = reward_url.option + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
	});

	//推广奖励 - 更改
	$(".js-reward-edit-btn-save").click(function() {
		var $url = reward_url.option_edit;
		
		var $id = $(".js-reward-edit-id").val();
		var $project_id = $(".js-reward-edit-project-id").find("option:selected").val();
		var $one_reward = $(".js-reward-edit-one-reward").val();
		var $two_reward = $(".js-reward-edit-two-reward").val();
		var $three_reward = $(".js-reward-edit-three-reward").val();
		var $lowest_cash = $(".js-reward-edit-lowest-cash").val();
		var $end_time = $(".js-reward-edit-end-time").val();
		var $status = $(".js-reward-edit-status").find("option:selected").val();
		var $remark = $(".js-reward-edit-remark").val();
		
		if ($one_reward == '' || $two_reward == '' || $three_reward == '') {
			layer_alert('奖励不能为空！');
			return false;
		}
		if ($lowest_cash == '') {
			layer_alert('提现金额不能为空！');
			return false;
		}
		if ($end_time == '') {
			layer_alert('结束时间不能为空！');
			return false;
		}
		
		var $data = {
			id: $id,
			project_id: $project_id,
			one_reward: $one_reward,
			two_reward: $two_reward,
			three_reward: $three_reward,
			lowest_cash: $lowest_cash,
			end_time: $end_time,
			status: $status,
			remark: $remark,
		}
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('更改成功！');
				
				setTimeout(function() {
					var $url = reward_url.option + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
	});

	//推广奖励 - 删除
	$(".js-room-reward-delete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = reward_url.option_delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {
						$(".reward-table-list-" + $id).remove();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认删除吗，删除后将不能恢复？', callBack);
	});
	
	
	/**===================== 奖励日志 =======================**/
	
	
	//奖励日志 - 项目切换
	$(".js-room-reward-log-search-select").change(function() {
		var $project_id = $(".js-room-reward-log-search-select").find("option:selected").val();

		window.location.href = reward_url.logs + '?project_id=' + $project_id;
		
		return false;
	});	

	//奖励日志 - 移除
	$(".js-room-reward-log-redelete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = reward_url.logs_redelete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('移除成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认移除吗，移除不会删除原文件？', callBack);
	});

	//奖励日志 - 恢复
	$(".js-room-reward-log-resave-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = reward_url.logs_resave;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('恢复成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认恢复该日志吗？', callBack);
	});

	//奖励日志 - 删除
	$(".js-room-reward-log-delete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = reward_url.logs_delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {
						$(".reward-table-list-" + $id).remove();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认删除该日志吗，删除后将不能恢复？', callBack);
	});
	
	
	/**===================== 奖励 - 用户关系 =======================**/
	
	
	//用户关系 - 项目切换
	$(".js-room-reward-users-search-select").change(function() {
		var $project_id = $(".js-room-reward-users-search-select").find("option:selected").val();

		window.location.href = reward_url.users + '?project_id=' + $project_id;
		
		return false;
	});	

	//用户关系 - 删除
	$(".js-room-reward-users-delete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = reward_url.users_delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {
						$(".reward-table-list-" + $id).remove();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认删除吗，删除后将不能恢复？', callBack);
	});
	
	
	/**===================== 代金券 =======================**/
	
	
	//代金券 - 项目切换
	$(".js-voucher-project-search-select").change(function() {
		var $project_id = $(".js-voucher-project-search-select").find("option:selected").val();

		window.location.href = voucher_url.index + '?project_id=' + $project_id;
		
		return false;
	});	
	

	//代金券 - 添加
	$(".js-voucher-add-btn-save").click(function() {
		var $url = voucher_url.add;
		
		var $name = $(".js-voucher-add-name").val();
		var $project_id = $(".js-voucher-add-project-id").find("option:selected").val();
		var $batch_id = $(".js-voucher-add-batch-id").find("option:selected").val();
		var $type = $(".js-voucher-add-type").find("option:selected").val();
		var $money = $(".js-voucher-add-money").val();
		var $quantity = $(".js-voucher-add-quantity").val();
		var $open_quantity = $(".js-voucher-add-open-quantity").val();
		var $use_quantity = $(".js-voucher-add-use-quantity").val();
		var $end_time = $(".js-voucher-add-end-time").val();
		var $description = $(".js-voucher-add-description").val();
		var $min_money = $(".js-voucher-add-min-money").val();
		var $directional_type = $(".js-voucher-edit-directional-type:checked").val();
		var $house_type = $(".js-voucher-add-house-type").val();
		var $room_id = $(".js-voucher-add-room-id").val();
		var $status = $(".js-voucher-add-status").find("option:selected").val();
		var $remark = $(".js-voucher-add-remark").val();
		
		if ($name == '') {
			layer_alert('代金券名称不能为空！');
			return false;
		}
		if ($project_id == '' || $project_id == 0) {
			layer_alert('项目不能为空！');
			return false;
		}
		if ($type == '') {
			layer_alert('类型不能为空！');
			return false;
		}
		if ($money == '') {
			layer_alert('金额不能为空！');
			return false;
		}
		if ($quantity == '') {
			layer_alert('总数量不能为空！');
			return false;
		}
		if ($quantity <= $open_quantity) {
			layer_alert('开启数量不能大于总数量！');
			return false;
		}
		if ($end_time == '') {
			layer_alert('结束时间不能为空！');
			return false;
		}
		
		var $data = {
			name: $name,
			project_id: $project_id,
			batch_id: $batch_id,
			type: $type,
			money: $money,
			quantity: $quantity,
			open_quantity: $open_quantity,
			use_quantity: $use_quantity,
			end_time: $end_time,
			description: $description,
			min_money: $min_money,
			directional_type: $directional_type,
			house_type: $house_type,
			room_id: $room_id,
			status: $status,
			remark: $remark,
		}
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('添加成功！');
				
				setTimeout(function() {
					var $url = voucher_url.index + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
	});

	//代金券 - 更改
	$(".js-voucher-edit-btn-save").click(function() {
		var $url = voucher_url.edit;
		
		var $id = $(".js-voucher-edit-id").val();
		var $name = $(".js-voucher-edit-name").val();
		var $project_id = $(".js-voucher-edit-project-id").find("option:selected").val();
		var $batch_id = $(".js-voucher-edit-batch-id").find("option:selected").val();
		var $type = $(".js-voucher-edit-type").find("option:selected").val();
		var $money = $(".js-voucher-edit-money").val();
		var $quantity = $(".js-voucher-edit-quantity").val();
		var $open_quantity = $(".js-voucher-edit-open-quantity").val();
		var $use_quantity = $(".js-voucher-edit-use-quantity").val();
		var $end_time = $(".js-voucher-edit-end-time").val();
		var $description = $(".js-voucher-edit-description").val();
		var $min_money = $(".js-voucher-edit-min-money").val();
		var $directional_type = $(".js-voucher-edit-directional-type:checked").val();
		var $house_type = $(".js-voucher-edit-house-type").val();
		var $room_id = $(".js-voucher-edit-room-id").val();
		var $status = $(".js-voucher-edit-status").find("option:selected").val();
		var $remark = $(".js-voucher-edit-remark").val();
		
		if ($name == '') {
			layer_alert('代金券名称不能为空！');
			return false;
		}
		if ($project_id == '' || $project_id == 0) {
			layer_alert('项目不能为空！');
			return false;
		}
		if ($type == '') {
			layer_alert('类型不能为空！');
			return false;
		}
		if ($money == '') {
			layer_alert('金额不能为空！');
			return false;
		}
		if ($quantity == '') {
			layer_alert('总数量不能为空！');
			return false;
		}
		if ($end_time == '') {
			layer_alert('结束时间不能为空！');
			return false;
		}
		
		var $data = {
			id: $id,
			name: $name,
			project_id: $project_id,
			batch_id: $batch_id,
			type: $type,
			money: $money,
			quantity: $quantity,
			open_quantity: $open_quantity,
			use_quantity: $use_quantity,
			end_time: $end_time,
			description: $description,
			min_money: $min_money,
			directional_type: $directional_type,
			house_type: $house_type,
			room_id: $room_id,
			status: $status,
			remark: $remark,
		}
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('更改成功！');
				
				setTimeout(function() {
					var $url = voucher_url.index + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
	});

	//代金券 - 删除
	$(".js-voucher-delete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = voucher_url.delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {
						$(".voucher-table-list-" + $id).remove();
					}, 500);
				}			
			});
		}
		
		layer_confirm('确认删除该代金券吗，删除后将不能恢复？', callBack);
	});
	
	//*---------------------------

	//代金券 - 搜索房间 - 鼠标进入
	$(".js-voucher-search-room-id").focus(function() {
		var $room = $(this).val();
		var $room_name = $(this).attr("data-room-name").trim();
		var $room_id = $(this).attr("data-room-id");
		var $room_no = $(this).attr("data-room-no").trim();
		var $input_room_no = $(this).attr("data-input-room-no");
		
		//添加搜素列表
		var $room_list = $(".js-voucher-search-room-list").html().trim();
		if ($room_list.length <= 0 && $room_name.length > 0) {
			var $tpl = ['<li class="voucher-search-room-item voucher-search-room-item-{ROOM_ID} js-voucher-search-room-item" data-room-id="{ROOM_ID}" data-room-no="{ROOM_NO}">',
							'<span class="voucher-search-room-info">',
								'{ROOM_NAME}',
							'</span>',
						'</li>'].join("");
			var $html = $tpl
				.replace(/{ROOM_ID}/i, $room_id)
				.replace(/{ROOM_ID}/i, $room_id)
				.replace(/{ROOM_NAME}/i, $room_name)
				.replace(/{ROOM_NO}/i, $room_no);
			$(".js-voucher-search-room-list").html($html);
		}

		//显示搜素列表
		var $room_list = $(".js-voucher-search-room-list").html().trim();
		if ($room_list.length > 0) {
			$(".js-voucher-search-room-content").show();
			
			setTimeout(function() {
				$(".js-voucher-search-room-content").hide();
			}, 60*1000);
		}
		
		$(this).val($input_room_no);
	});
	
	//代金券 - 搜索房间 - 失去焦点
	$(".js-voucher-search-room-id").blur(function() {
		var $room_name = $(this).attr("data-room-name");
		if ($room_name.length > 0) {
			$(this).val($room_name);
		} else {
			var $input_num = $(".js-voucher-search-room-id").attr("data-input-room-no");
			$(this).val($input_num);
		}
	});
	
	//代金券 - 搜索房间 - 隐藏
	$(document).click(function(e) {
		var target = $(e.target); 
		if (target.closest(".js-voucher-search-room-tr").length == 0){ 
			$(".js-voucher-search-room-content").hide();
		} 
	});

	//代金券 - 搜索房间 - 切换
	$(".js-voucher-search-room-id").bind('input propertychange', function() {
		var $this = $(this);
		var $room = $(this).val();
		var $project_id = $(".js-voucher-search-project-id").find("option:selected").val();
		
		if ($room == '' || $room == undefined) {
			$(this).attr("data-room-name", '');
			$(".js-voucher-search-put-room-id").val('');
		}
		if ($project_id == '' || $project_id == undefined) {
			return false;
		}
		
		//保存搜索条件
		$(this).attr("data-input-room-no", $room);
		
		var $url = voucher_url.search_room + '?room='+$room+'&project_id=' + $project_id;
		ajax_get_callback($url, function($data) {
			if ($data['status'] != 1) {
				return false;
			}
			
			var $info = $data['info'];			
			var $tpl = ['<li class="voucher-search-room-item voucher-search-room-item-{ROOM_ID} js-voucher-search-room-item" data-room-id="{ROOM_ID}" data-room-no="{ROOM_NO}">',
							'<span class="voucher-search-room-info">',
								'{ROOM_NAME}',
							'</span>',
						'</li>'].join("");
			var $html = '';
			
			//显示原始房间
			var $old_room_name = $this.attr("data-old-room-name").trim();
			var $old_room_no = $this.attr("data-old-room-no");
			var $old_room_id = $this.attr("data-old-room-id");
			if ($old_room_name.length > 0) {
				var $old_html = $tpl
					.replace(/{ROOM_ID}/i, $old_room_id)
					.replace(/{ROOM_ID}/i, $old_room_id)
					.replace(/{ROOM_NAME}/i, $old_room_name)
					.replace(/{ROOM_NO}/i, $old_room_no);
				$old_html = $('<span>'+$old_html+'</span>')
					.find(".voucher-search-room-item")
					.addClass("old-voucher")
					.parent()
					.html();
				
				$html += $old_html;
			}
		
			if ($info.length > 0) {
				for (var $i = 0; $i < $info.length; $i ++) {
					$html += $tpl
						.replace(/{ROOM_ID}/i, $info[$i]['id'])
						.replace(/{ROOM_ID}/i, $info[$i]['id'])
						.replace(/{ROOM_NAME}/i, $info[$i]['room_name'])
						.replace(/{ROOM_NO}/i, $info[$i]['room_no']);
				}
			
				$(".js-voucher-search-room-list").html($html);
				$(".js-voucher-search-room-content").show();
			} else {
				$(".js-voucher-search-room-list").html('');
				$(".js-voucher-search-room-content").hide();
			}
	
			$('.js-voucher-search-room-perfect-scroll').perfectScrollbar('update');
		});
		
		return false;
	});
	
	//代金券 - 搜索房间 - 选中
	$(document).on('click', ".js-voucher-search-room-item", function() {
		var $room_name = $(this).find(".voucher-search-room-info").text().trim();
		var $room_no = $(this).attr("data-room-no").trim();
		var $room_id = $(this).attr("data-room-id").trim();
		
		$(".js-voucher-search-room-id").val($room_name);
		$(".js-voucher-search-room-id").attr('data-room-name', $room_name);
		$(".js-voucher-search-room-id").attr('data-room-no', $room_no);
		$(".js-voucher-search-room-id").attr('data-room-id', $room_id);
		$(".js-voucher-search-room-id").attr("data-input-room-no", $room_no);
		
		$(".js-voucher-search-put-room-id").val($room_id);

		$(".js-voucher-search-room-content").hide();
	});
	
	//代金券 - 类型切换控制
	$(".js-voucher-add-type").change(function() {
		var $vtype= $(".js-voucher-add-type").find("option:selected").val();
		if ($vtype=="gift")
		{
			$(".js-voucher-add-min-money").val("");
			$(".js-voucher-mjtj").show();
			
			$("input[name=directional_type]").attr("checked",false); 
			$(".js-voucher-dxlx").hide();
			
			$(".js-voucher-add-house-type").val("");
			$(".js-voucher-hx").hide();
			
			$(".js-voucher-search-room-id").val("");
			$(".js-voucher-add-room-id").val("");
			$(".js-voucher-search-room-tr").hide();
		}
		if ($vtype=="common")
		{
			$(".js-voucher-add-min-money").val("");
			$(".js-voucher-mjtj").hide();
			
			$("input[name=directional_type]").attr("checked",false); 
			$(".js-voucher-dxlx").hide();
			
			$(".js-voucher-add-house-type").val("");
			$(".js-voucher-hx").hide();
			
			$(".js-voucher-search-room-id").val("");
			$(".js-voucher-add-room-id").val("");
			$(".js-voucher-search-room-tr").hide();
		}
		if($vtype=="directional")
		{
			$(".js-voucher-add-min-money").val("");
			$(".js-voucher-mjtj").hide();
			
			$(".js-voucher-dxlx").show();
			
			$(".js-voucher-hx").show();
			$(".js-voucher-search-room-tr").show();
		}
		return false;
	});	
	
	/**===================== 代金券 活动 =======================**/
	
	
	//代金券 活动 - 项目切换
	$(".js-voucher-activity-project-search-select").change(function() {
		var $project_id = $(".js-voucher-activity-project-search-select").find("option:selected").val();

		window.location.href = voucher_activity_url.index + '?project_id=' + $project_id;
		
		return false;
	});	
	
	
	//代金券 活动 - 添加 - 项目切换
	$(".js-voucher-activity-add-project-id").change(function() {		
		var $project_id = $(this).find("option:selected").val();
		
		var $url = voucher_activity_url.get_vouchers + '?project_id=' + $project_id;
		ajax_get_callback($url, function($data) {
			if ($data['status'] != 1) {
				layer_alert($data['info']);
				return false;
			}
			
			var $info = $data['info'];
			$(".js-voucher-activity-add-list").html($info['vouchers']);
			$('.js-voucher-perfect-scroll').perfectScrollbar('update');
			
			$(".js-voucher-activity-select-num").text($info['count']);
		});
	});
	
	//代金券 活动 - 添加 - 数量
	$(".js-voucher-activity-add-list").on('click', '.js-voucher-activity-item-num', function() {
		var $key = $(this).attr("data-key");
		var $quantity = $(this).attr("data-quantity");
		var $open_quantity = $(this).attr("data-open-quantity");
		
		if ($quantity-$open_quantity >= 0) {
			var $msg = '共有'+$quantity+'张，剩余'+($quantity-$open_quantity)+'张';
		} else {
			var $msg = '数量错误:['+$open_quantity+'/'+$quantity+']张';
		}
		
		layer_tip($msg, '.js-voucher-activity-item-num-' + $key, 'right');
		
		return false;
	});
	
	//代金券 活动 - 添加 - 选择
	$(".js-voucher-activity-add-list").on('click', '.js-voucher-activity-item', function() {
		var $thiz = $(this);

		if ($thiz.hasClass('selected')) {
			$thiz.removeClass('selected');
		} else {
			$thiz.addClass('selected');
		}
		
		$(".js-voucher-activity-select-num")
			.text($(".js-voucher-activity-item.selected").size());
		
		return false;
	});		
	
	//代金券 活动 - 编辑 - 项目切换
	$(".js-voucher-activity-edit-project-id").change(function() {
		var $project_id = $(this).find("option:selected").val();
		var $activity_id = $(".js-voucher-activity-edit-id").val();
		
		var $url = voucher_activity_url.get_vouchers + '?activity_id='+$activity_id+'&project_id=' + $project_id;
		ajax_get_callback($url, function($data) {
			if ($data['status'] != 1) {
				layer_alert($data['info']);
				return false;
			}
			
			var $info = $data['info'];
			$(".js-voucher-activity-edit-list").html($info['vouchers']);
			$('.js-voucher-perfect-scroll').perfectScrollbar('update');
			
			//$(".js-voucher-activity-select-num").text($info['count']);
			var $cyfs = $("input[name='cyfs']:checked").val();
			var $voulist=$(".js-voucher-activity-edit-list").find("li");
			if ($cyfs == "1")
			{
				for(var i=0;i<$voulist.length;i++)
				{
					if($voulist.eq(i).attr('vtype') !='directional')
					{
						if ($voulist.eq(i).hasClass('selected')) {
							$voulist.eq(i).removeClass('selected');
						} 
						$voulist.eq(i).hide();
					}
				}
			}
			
			$(".js-voucher-activity-select-num")
			.text($(".js-voucher-activity-item.selected").size());
		});
	});
	
	//代金券 活动 - 编辑 - 数量
	$(".js-voucher-activity-edit-list").on('click', '.js-voucher-activity-item-num', function() {
		var $key = $(this).attr("data-key");
		var $quantity = $(this).attr("data-quantity");
		var $open_quantity = $(this).attr("data-open-quantity");
		var $msg = '共有'+$quantity+'张，剩余'+($quantity-$open_quantity)+'张';
		
		layer_tip($msg, '.js-voucher-activity-item-num-' + $key, 'right');
		
		return false;
	});
	
	//代金券 活动 - 编辑 - 选择
	$(".js-voucher-activity-edit-list").on('click', '.js-voucher-activity-item', function() {
		var $thiz = $(this);

		if ($thiz.hasClass('selected')) {
			$thiz.removeClass('selected');
		} else {
			$thiz.addClass('selected');
		}
		
		$(".js-voucher-activity-select-num")
			.text($(".js-voucher-activity-item.selected").size());
		
		return false;
	});	

	//代金券 活动 - 添加 - 提交
	$(".js-voucher-activity-add-btn-save").click(function() {
		var $url = voucher_activity_url.add;
		
		var $project_id = $(".js-voucher-activity-add-project-id").find("option:selected").val();
		var $batch_id = $(".js-voucher-activity-add-batch-id").find("option:selected").val();
		var $cyfs = $('input[name="cyfs"]:checked').val();
		var $name = $(".js-voucher-activity-add-name").val();
		var $description = $(".js-voucher-activity-add-description").val();
		var $start_time = $(".js-voucher-activity-add-start-time").val();
		var $end_time = $(".js-voucher-activity-add-end-time").val();
		var $status = $(".js-voucher-activity-add-status").find("option:selected").val();
		var $remark = $(".js-voucher-activity-add-remark").val();

		var $activity_vouchers = $(".js-voucher-activity-item.selected");
			
		if ($project_id == '' || $project_id ==0) {
			layer_alert('请选择项目！');
			return false;
		}
		if ($cyfs=='' || $cyfs==undefined)
		{
			layer_alert('请选择活动类型！');
			return false;
		}
		if ($name == '') {
			layer_alert('名称不能为空！');
			return false;
		}
		if ($start_time == '') {
			layer_alert('开始时间不能为空！');
			return false;
		}
		if ($end_time == '') {
			layer_alert('结束时间不能为空！');
			return false;
		}
		var $activity_vouchers = $(".js-voucher-activity-item.selected");
		if ($activity_vouchers.length == 0)
		{
			layer_alert('请选择参与活动的代金券');
			return false;
		}
		var $attrs = [];
		var $zgs=0;
		$activity_vouchers.each(function(i, value) {
			var $attr = {
				'voucher_id': $(this).attr("data-voucher-id"),
				'voucher_num': $(this).find(".js-voucher-activity-item-num").val()
			};
			$attrs.push($attr);
			$zgs=$zgs+$(this).find(".js-voucher-activity-item-num").val();
		});
		if ($zgs == 0)
		{
			layer_alert('请填写参与活动的代金券数量');
			return false;
		}
		
		var $data = {
			project_id: $project_id,
			batch_id: $batch_id,
			cyfs:$cyfs,
			name: $name,
			description: $description,
			start_time: $start_time,
			end_time: $end_time,
			attrs: $attrs,
			status: $status,
			remark: $remark,
		}
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('添加成功！');
				
				setTimeout(function() {
					var $url = voucher_activity_url.index + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
	});

	//代金券 活动- 更改
	$(".js-voucher-activity-edit-btn-save").click(function() {
		var $url = voucher_activity_url.edit;
		
		var $id = $(".js-voucher-activity-edit-id").val();
		var $project_id = $(".js-voucher-activity-edit-project-id").find("option:selected").val();
		var $batch_id = $(".js-voucher-activity-edit-batch-id").find("option:selected").val();
		var $name = $(".js-voucher-activity-edit-name").val();
		var $cyfs = $('input[name="cyfs"]:checked').val();
		var $description = $(".js-voucher-activity-edit-description").val();
		var $start_time = $(".js-voucher-activity-edit-start-time").val();
		var $end_time = $(".js-voucher-activity-edit-end-time").val();
		var $status = $(".js-voucher-activity-edit-status").find("option:selected").val();
		var $remark = $(".js-voucher-activity-edit-remark").val();

		if ($project_id == '' || $project_id ==0) {
			layer_alert('请选择项目！');
			return false;
		}
		if ($cyfs=='' || $cyfs==undefined)
		{
			layer_alert('请选择活动类型！');
			return false;
		}
		if ($name == '') {
			layer_alert('名称不能为空！');
			return false;
		}
		if ($start_time == '') {
			layer_alert('开始时间不能为空！');
			return false;
		}
		if ($end_time == '') {
			layer_alert('结束时间不能为空！');
			return false;
		}

		var $activity_vouchers = $(".js-voucher-activity-item.selected");
		if ($activity_vouchers.length == 0)
		{
			layer_alert('请选择参与活动的代金券');
			return false;
		}
		var $attrs = [];
		var $zgs=0;
		$activity_vouchers.each(function(i, value) {
			var $attr = {
				'voucher_id': $(this).attr("data-voucher-id"),
				'voucher_num': $(this).find(".js-voucher-activity-item-num").val()
			};
			$attrs.push($attr);
			$zgs=$zgs+$(this).find(".js-voucher-activity-item-num").val();
		});
		if ($zgs == 0)
		{
			layer_alert('请填写参与活动的代金券数量');
			return false;
		}
		
		var $data = {
			id: $id,
			project_id: $project_id,
			batch_id: $batch_id,
			name: $name,
			cyfs: $cyfs,
			description: $description,
			start_time: $start_time,
			end_time: $end_time,
			attrs: $attrs,
			status: $status,
			remark: $remark,
		}
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('更改成功！');
				
				setTimeout(function() {
					var $url = voucher_activity_url.index + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
	});

	//代金券 活动 - 删除
	$(".js-voucher-activity-delete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = voucher_activity_url.delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {
						$(".voucher-activity-table-list-" + $id).remove();
					}, 500);
				}			
			});
		}
		
		layer_confirm('确认删除该代金券活动吗，删除后将不能恢复？', callBack);
	});
	
	
	/**===================== 代金券记录 =======================**/
	
	
	//代金券记录 - 项目切换
	$(".js-voucher-log-project-search-select").change(function() {
		var $project_id = $(this).find("option:selected").val();

		window.location.href = voucher_log_url.index + '?project_id=' + $project_id;
		
		return false;
	});	

	//代金券记录 - 删除
	$(".js-voucher-log-delete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = voucher_log_url.delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {
						$(".voucher-log-table-list-" + $id).remove();
					}, 500);
				}			
			});
		}
		
		layer_confirm('确认删除该代金券记录吗，删除后将不能恢复？', callBack);
	});

	//代金券记录 - 移除
	$(".js-voucher-log-redelete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = voucher_log_url.redelete;
			
			var $data = {
				id: $id,
			}
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('移除成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认移除吗，移除不会删除原文件？', callBack);
	});

	//代金券记录 - 恢复
	$(".js-voucher-log-resave-btn").click(function() {
		var $id = $(this).attr("data-id");
		var callBack = function() {
			var $url = voucher_log_url.resave;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('恢复成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认恢复该记录吗？', callBack);
	});

	//代金券记录 - 使用
	$(".js-voucher-log-used").click(function() {
		var $id = $(this).attr("data-id");
		var callback = function() {
			var $url = voucher_log_url.used;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('操作成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 500);
				}			
			});
		}
		
		layer_confirm('确认执行该操作吗？', callback);
	});

	//代金券记录 - 取消使用
	$(".js-voucher-log-reused").click(function() {
		var $id = $(this).attr("data-id");
		var callback = function() {
			var $url = voucher_log_url.reused;
			var $data = {
				id: $id,
			}
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('操作成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 500);
				}			
			});
		}
		
		layer_confirm('确认执行该操作吗？', callback);
	});
	
	
	/**===================== 代金券提醒 =======================**/
	
	//代金券提醒 - 项目切换
	$(".js-voucher-tip-project-search-select").change(function() {
		var $project_id = $(this).find("option:selected").val();
		window.location.href = voucher_tip_url.index + '?project_id=' + $project_id;
		return false;
	});	

	//代金券提醒 - 删除
	$(".js-voucher-tip-delete-btn").click(function() {
		var $id = $(this).attr("data-id");
		var callback = function() {
			var $url = voucher_tip_url.delete;
			var $data = {
				id: $id,
			}
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					setTimeout(function() {
						$(".voucher-tip-table-list-" + $id).remove();
					}, 500);
				}			
			});
		}
		layer_confirm('确认删除该条提醒吗？', callback);
	});

	//代金券提醒 - 设置为提醒
	$(".js-voucher-tip-has-btn").click(function() {
		var $id = $(this).attr("data-id");
		var callback = function() {
			var $url = voucher_tip_url.tip;
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('设置为已提醒成功！');
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确定设置为已提醒吗？', callback);
	});

	//代金券提醒 - 恢复为未提醒
	$(".js-voucher-tip-retip-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callback = function() {
			var $url = voucher_tip_url.retip;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('恢复为未提醒成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认恢复为未提醒吗？', callback);
	});
	
	//代金卷活动类型更改（新增）
	$(".js-voucher-activity-cyfs-add").change(function() {
		var $cyfs = $("input[name='cyfs']:checked").val();
		var $voulist=$(".js-voucher-activity-add-list").find("li");
		if ($cyfs == "0")
		{
			$voulist.show();
		}
		else if ($cyfs == "1")
		{
			for(var i=0;i<$voulist.length;i++)
			{
				if($voulist.eq(i).attr('vtype') !='directional')
				{
					if ($voulist.eq(i).hasClass('selected')) {
						$voulist.eq(i).removeClass('selected');
					} 
					$voulist.eq(i).hide();
				}
			}
			$(".js-voucher-activity-select-num")
			.text($(".js-voucher-activity-item.selected").size());
		}
		else
		{
			$voulist.show();
		}
	});
	
	//代金卷活动类型更改（编辑）
	$(".js-voucher-activity-cyfs-edit").change(function() {
		var $cyfs = $("input[name='cyfs']:checked").val();
		var $voulist=$(".js-voucher-activity-edit-list").find("li");
		if ($cyfs == "0")
		{
			$voulist.show();
		}
		else if ($cyfs == "1")
		{
			for(var i=0;i<$voulist.length;i++)
			{
				if($voulist.eq(i).attr('vtype') !='directional')
				{
					if ($voulist.eq(i).hasClass('selected')) {
						$voulist.eq(i).removeClass('selected');
					} 
					$voulist.eq(i).hide();
				}
			}
			$(".js-voucher-activity-select-num")
			.text($(".js-voucher-activity-item.selected").size());
		}
		else
		{
			$voulist.show();
		}
	});
	
	/**===================== 竞价选房 =======================**/
	
	//竞价选房 - 项目切换
	$(".js-choose-project-search-select").change(function() {
		var $project_id = $(this).find("option:selected").val();

		window.location.href = choose_url.index + '?project_id=' + $project_id;
		
		return false;
	});	

	//竞价选房 - 提交
	$(".js-choose-add-btn-save").on('click', function() {		
		var $project_id = $(".js-choose-add-project-id").find("option:selected").val();
		var $batch_id = $(".js-choose-add-batch-id").find("option:selected").val();
		var $customer_name = $(".js-choose-add-customer-name").val();
		var $customer_phone = $(".js-choose-add-customer-phone").val();
		var $row_number = $(".js-choose-add-row-number").val();
		var $money = $(".js-choose-add-money").val();
		var $area = $(".js-choose-add-area").val();
		var $price = $(".js-choose-add-price").val();
		var $house_type = $(".js-choose-add-house-type").val();
		var $floor = $(".js-choose-add-floor").val();
		var $room = $(".js-choose-add-room").val();
		var $password = $(".js-choose-add-password").val();
		var $status = $(".js-choose-add-status").find("option:selected").val();
		var $remark = $(".js-choose-add-remark").val();
		
		if ($project_id == '') {
			layer_alert('项目不能为空！');
			return false;
		}
		if ($customer_name == '') {
			layer_alert('客户名称不能为空！');
			return false;
		}
		if ($customer_phone == '') {
			layer_alert('客户电话不能为空！');
			return false;
		}
		if ($money == '') {
			layer_alert('诚意金金额不能为空！');
			return false;
		}
		
		var $data = {
			project_id: $project_id,
			batch_id: $batch_id,
			customer_name: $customer_name,
			customer_phone: $customer_phone,
			row_number: $row_number,
			money: $money,
			area: $area,
			price: $price,
			house_type: $house_type,
			floor: $floor,
			room: $room,
			password: $password,
			status: $status,
			remark: $remark,
		}
		
		var $url = choose_url.add;
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('添加成功！');
				
				setTimeout(function() {
					var $url = choose_url.index + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
		
		return false;
	});

	//竞价选房 - 编辑
	$(".js-choose-edit-btn-save").on('click', function() {		
		var $id = $(".js-choose-edit-id").val();
		
		var $project_id = $(".js-choose-edit-project-id").find("option:selected").val();
		var $batch_id = $(".js-choose-edit-batch-id").find("option:selected").val();
		var $customer_name = $(".js-choose-edit-customer-name").val();
		var $customer_phone = $(".js-choose-edit-customer-phone").val();
		var $row_number = $(".js-choose-edit-row-number").val();
		var $money = $(".js-choose-edit-money").val();
		var $area = $(".js-choose-edit-area").val();
		var $price = $(".js-choose-edit-price").val();
		var $house_type = $(".js-choose-edit-house-type").val();
		var $floor = $(".js-choose-edit-floor").val();
		var $room = $(".js-choose-edit-room").val();
		var $password = $(".js-choose-edit-password").val();
		var $status = $(".js-choose-edit-status").find("option:selected").val();
		var $remark = $(".js-choose-edit-remark").val();
		
		if ($project_id == '') {
			layer_alert('项目不能为空！');
			return false;
		}
		if ($customer_name == '') {
			layer_alert('客户名称不能为空！');
			return false;
		}
		if ($customer_phone == '') {
			layer_alert('客户电话不能为空！');
			return false;
		}
		if (!validate_mobile($customer_phone)) {
			layer_alert('客户电话填写错误！');
			return false;
		}
		if ($money == '') {
			layer_alert('诚意金金额不能为空！');
			return false;
		}
		
		var $data = {
			id: $id,
			project_id: $project_id,
			batch_id: $batch_id,
			customer_name: $customer_name,
			customer_phone: $customer_phone,
			row_number: $row_number,
			money: $money,
			area: $area,
			price: $price,
			house_type: $house_type,
			floor: $floor,
			room: $room,
			password: $password,
			status: $status,
			remark: $remark,
		}
		
		var $url = choose_url.edit;
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('更改成功！');
				
				setTimeout(function() {
					var $url = choose_url.index + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
		
		return false;
	});

	//竞价选房 - 删除
	$(".js-choose-delete-btn").on('click', function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = choose_url.delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认删除吗，删除后将不能恢复？', callBack);
	});

	//竞价选房 - 导出excel - 提示
	$(".js-choose-excel-export").on('click', function() {
		var $html = $(".js-choose-excel-export-tpl").html();
		
		layer_html($html);
		
		return false;
	});

	//竞价选房 - 导出excel - 提交
	$(document).on('click', '.js-choose-excel-export-tpl-btn', function() {
		var $project_id = $(".js-choose-project-search-select").find("option:selected").val();
		var $batch_id = $(".js-choose-batch-search-select").find("option:selected").val();
		
		if ($project_id == 0) {
			layer_alert('请选择项目后重试！');
			return false;
		}
		
		if ($batch_id == 0) {
			layer_alert('请选择项目批次后重试！');
			return false;
		}
		
		layer_close_all();
		
		window.location.href = choose_url.export 
			+ '?project_id=' + $project_id 
			+ '&batch_id=' + $batch_id;
		
		return false;
	});

	//竞价选房 - 导入excel - 提示
	$(".js-choose-excel-import").on('click', function() {
		var $html = $(".js-choose-excel-import-tpl").html();
		
		layer_html($html);
		
		return false;
	});
	
	//竞价选房 - 导入excel - 提交
	$(document).on('click', ".js-choose-excel-import-tpl-btn", function() {
		var $form = $(this).parent().parent().parent();
		var $formData = new FormData($form[0]);
		
		var options = {
			url: $form.attr('action'),
			type: 'POST',
			dataType: 'JSON',
			async: false,  
			cache: false, 
			data: $formData,
			// 告诉jQuery不要去处理发送的数据
			processData : false, 
			// 告诉jQuery不要去设置Content-Type请求头
			contentType : false,
			success: function (data) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('导入成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}
			},
			error: function () {
				layer_alert("导出失败，请确认后重试！");
			}
		};
		
		$.ajax(options);
	
		return false;
	});
	
	/**===================== 竞价选房 - 活动 =======================**/
	
	//竞价选房 - 活动 - 项目切换
	$(".js-choose-activity-project-search-select").change(function() {
		var $project_id = $(this).find("option:selected").val();

		window.location.href = choose_activity_url.index + '?project_id=' + $project_id;
		
		return false;
	});	

	//竞价选房 - 活动 - 添加
	$(".js-choose-activity-add-btn-save").on('click', function() {		
		var $name = $(".js-choose-activity-add-name").val();
		var $description = $(".js-choose-activity-add-description").val();
		var $project_id = $(".js-choose-activity-add-project-id").find("option:selected").val();
		var $batch_id = $(".js-choose-activity-add-batch-id").find("option:selected").val();
		
		var $sort = $(".js-choose-activity-add-sort").val();
		var $person_count = $(".js-choose-activity-add-person-count").val();
		
		var $start_time = $(".js-choose-activity-add-start-time").val();
		var $end_time = $(".js-choose-activity-add-end-time").val();
		var $long_time = $(".js-choose-activity-add-long-time").val();
		var $type = $(".js-choose-activity-add-type:checked").val();

		var $status = $(".js-choose-activity-add-status").find("option:selected").val();
		var $remark = $(".js-choose-activity-add-remark").val();
		
		if ($project_id == '') {
			layer_alert('项目不能为空！');
			return false;
		}
		if ($batch_id == '') {
			layer_alert('项目批次不能为空！');
			return false;
		}
		if ($name == '') {
			layer_alert('活动名称不能为空！');
			return false;
		}
		if ($start_time == '') {
			layer_alert('开始时间不能为空！');
			return false;
		}
		if ($person_count == '') {
			layer_alert('预定人数不能为空！');
			return false;
		}
		
		var $data = {
			name: $name,
			description: $description,
			project_id: $project_id,
			batch_id: $batch_id,
			
			sort: $sort,
			person_count: $person_count,
			start_time: $start_time,
			end_time: $end_time,
			long_time: $long_time,
			type: $type,
			
			status: $status,
			remark: $remark,
		}
		
		var $url = choose_activity_url.add;
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('添加成功！');
				
				setTimeout(function() {
					var $url = choose_activity_url.index + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
		
		return false;
	});

	//竞价选房 - 活动 - 编辑
	$(".js-choose-activity-edit-btn-save").on('click', function() {		
		var $id = $(".js-choose-activity-edit-id").val();
		
		var $name = $(".js-choose-activity-edit-name").val();
		var $description = $(".js-choose-activity-edit-description").val();
		var $project_id = $(".js-choose-activity-edit-project-id").find("option:selected").val();
		var $batch_id = $(".js-choose-activity-edit-batch-id").find("option:selected").val();
		
		var $sort = $(".js-choose-activity-edit-sort").val();
		var $person_count = $(".js-choose-activity-edit-person-count").val();
		
		var $start_time = $(".js-choose-activity-edit-start-time").val();
		var $end_time = $(".js-choose-activity-edit-end-time").val();
		var $long_time = $(".js-choose-activity-edit-long-time").val();
		var $type = $(".js-choose-activity-edit-type:checked").val();

		var $status = $(".js-choose-activity-edit-status").find("option:selected").val();
		var $remark = $(".js-choose-activity-edit-remark").val();
		
		if ($project_id == '') {
			layer_alert('项目不能为空！');
			return false;
		}
		if ($batch_id == '') {
			layer_alert('项目批次不能为空！');
			return false;
		}
		if ($name == '') {
			layer_alert('活动名称不能为空！');
			return false;
		}
		if ($start_time == '') {
			layer_alert('开始时间不能为空！');
			return false;
		}
		if ($person_count == '') {
			layer_alert('预定人数不能为空！');
			return false;
		}
		
		var $data = {
			id: $id,
			
			name: $name,
			description: $description,
			project_id: $project_id,
			batch_id: $batch_id,
			
			sort: $sort,
			person_count: $person_count,
			start_time: $start_time,
			end_time: $end_time,
			long_time: $long_time,
			type: $type,
			
			status: $status,
			remark: $remark,
		}
		
		var $url = choose_activity_url.edit;
		
		ajax_post_callback($url, $data, function(data, status) {
			if (data['status'] != 1) {
				layer_alert(data['info']);
				return false;
			} else {
				layer_alert('编辑成功！');
				
				setTimeout(function() {
					var $url = choose_activity_url.index + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
		
		return false;
	});

	//竞价选房 - 活动 - 删除
	$(".js-choose-activity-delete-btn").on('click', function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = choose_activity_url.delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认删除吗，删除后将不能恢复？', callBack);
	});
	
	/**===================== 竞价选房 - 竞价记录 =======================**/
	
	//竞价选房 - 竞价记录 - 项目切换
	$(".js-choose-log-project-search-select").on('change', function() {
		var $project_id = $(this).find("option:selected").val();

		window.location.href = choose_log_url.index + '?project_id=' + $project_id;
		
		return false;
	});	

	//竞价选房 - 竞价记录 - 删除
	$(".js-choose-log-delete-btn").on('click', function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = choose_log_url.delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认删除吗，删除后将不能恢复？', callBack);
	});

	//竞价选房 - 竞价记录 - 移除
	$(".js-choose-log-redelete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = choose_log_url.redelete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('移除成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认移除吗，移除不会删除原文件？', callBack);
	});

	//竞价选房 - 竞价记录 - 恢复
	$(".js-choose-log-resave-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = choose_log_url.resave;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('恢复成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认恢复该记录吗？', callBack);
	});
	
	/**===================== 竞价选房 - 用户登录 =======================**/
	
	//竞价选房 - 用户登录 - 项目切换
	$(".js-choose-user-project-search-select").on('change', function() {
		var $project_id = $(this).find("option:selected").val();

		window.location.href = choose_user_url.index + '?project_id=' + $project_id;
		
		return false;
	});	

	//竞价选房 - 用户登录 - 删除
	$(".js-choose-user-delete-btn").on('click', function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = choose_user_url.delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认删除吗，删除后将不能恢复？', callBack);
	});
		

});

