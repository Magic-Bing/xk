//通用
$(function() {
	"use strict";
	/*2017-12-15 修改优化*/
		$(document).on("click","#getNotBuy",function () {
			$(".bt").css("background-color","#FFF").css("color","#6b6a6a");
			$(this).css("background-color","#09BB07").css("color","#FFF");
			var pid=$(this).attr("pid");
				$.post(saler_url.getNotBuy,{pid:pid},function (data) {
					$("#tab2 tbody").html(data);
                })
        });
	/*        END       */
	//导航显示
	$(".js-saler-project-view-header-content").click(function() {
		var $unit = $(".js-saler-project-view-header-unit-wrapper");
		
		if ($unit.css("display") == "none") {
			$unit.slideDown("fast");
		} else {
			$unit.slideUp("fast");
		}
	});
	
	//刷新
	/*
	$('body').on('click', ".saler-project-header-reload-btn", function() {
		$(this).find('i.saler-project-qh').addClass("saler-project-header-reload-btn-rotate")
	});
        */

	//房源对比
	$(".js-saler-project-view-content-search-compare-btn").click(function() {
		var $thiz = $(this);
		if ($thiz.hasClass("saler-project-view-content-search-compare-btn-click")) {
			$(".js-saler-project-view-content-selected-wrapper")
				.animate({"right": "-66px"}, function() {
					$(this).hide();
				});
				
			$(".js-saler-project-view-content-rooms-room-box-shadow").fadeOut("fast");
			
			$thiz.removeClass("saler-project-view-content-search-compare-btn-click");
			
			$(".room-bottom-block").hide();
		} else {
			$(".room-bottom-block").show();
			$(".js-saler-project-view-content-selected-wrapper")
				.css({"right": "-66px"})
				.show()
				.animate({"right": "5px"});
			$(".js-saler-project-view-content-rooms-room-box-shadow").fadeIn("fast");

			var $room_checked_num = $(".saler-project-view-content-rooms-room-select:checked").length;
			$(".saler-project-view-content-selected-num").text($room_checked_num);
			
			$thiz.addClass("saler-project-view-content-search-compare-btn-click");
		}
		
	});
	
	//选中
	$("body").on("click", ".js-saler-project-view-content-rooms-room-box-shadow", function() {
		var $room_id = $(this).attr("data-room-id");
                
                 var $room_checked_num = $(".saler-project-view-content-rooms-room-select:checked").length;
		
		var $room_checked = $(".saler-project-view-content-rooms-room-select-" + $room_id);
		if (!$room_checked.is(":checked")) {  
                    if($room_checked_num>=5)
                    {
                        layer_alert("每次最多只能对比5个");
                        return false;
                    }
                    $room_checked.prop("checked", true);  
                } else {
                    $room_checked.removeAttr("checked"); 
                } 
		
		var $room_checked_num = $(".saler-project-view-content-rooms-room-select:checked").length;
		$(".saler-project-view-content-selected-num").text($room_checked_num);
	});

	//比对
	$(".js-saler-project-view-content-selected-compare").click(function() {
		var $select_room_list = $(".saler-project-view-content-rooms-room-select:checked");
                if( $select_room_list.length<2)
                {
                     layer_alert("至少选择两个房源！");
                    return false;
                }
		var pid=$(this).attr("pid");
		var $room_ids = [];
		for (var $i = 0; $i < $select_room_list.length; $i ++) {
			$room_ids.push($($select_room_list[$i]).attr("data-room-id"));
		}
		
		var $room_ids_str = $room_ids.join(",");
		if ($room_ids_str == '') {
			layer_alert("请选择要对比的房源！");
			return false;
		}
		
		window.location.href = saler_url.project_room_compare + '?ids=' + $room_ids_str+"&pid="+pid;
	});
	
	//查看户型
	$(".js-saler-project-view-content-right-nav-btn").click(function() {
		var $house_type = $(".js-saler-project-view-content-right-nav-house-type");
		
		if ($house_type.css("display") == 'none') {
			$house_type.slideDown("150");
		} else {
			$house_type.slideUp("150");
		}
	});
	
	//查看户型 - 选择
	$(".js-saler-project-view-content-right-nav-house-type-one").on("click", 'a', function() {
		var $thiz = $(this).parent();
		if ($thiz.hasClass("saler-project-view-content-right-nav-house-type-all")) {
			$(".js-saler-project-view-content-right-nav-house-type-one").removeClass("saler-project-view-content-right-nav-house-type-one-select");
			$thiz.addClass("saler-project-view-content-right-nav-house-type-one-select");
		} else {
			$(".saler-project-view-content-right-nav-house-type-all").removeClass("saler-project-view-content-right-nav-house-type-one-select");
			if ($thiz.hasClass("saler-project-view-content-right-nav-house-type-one-select")) {
				$thiz.removeClass("saler-project-view-content-right-nav-house-type-one-select");
			} else {
				$thiz.addClass("saler-project-view-content-right-nav-house-type-one-select");
			}
		}
		if ($(".saler-project-view-content-right-nav-house-type-one-select").length < 1) {
			$(".js-saler-project-view-content-right-nav-house-type-one").removeClass("saler-project-view-content-right-nav-house-type-one-select");
			$(".saler-project-view-content-right-nav-house-type-all").addClass("saler-project-view-content-right-nav-house-type-one-select");
		}
		
		var $type = $(".saler-project-footer-tabs-btn-select").attr("data-type");
		var $hxs = [];
		
		var $hx_select = $(".saler-project-view-content-right-nav-house-type-one-select");
		for (var $i = 0; $i < $hx_select.length; $i ++) {
			if (!$($hx_select[$i]).hasClass("saler-project-view-content-right-nav-house-type-all")) {
				$hxs.push($($hx_select[$i]).find('a').attr("data-hx"));
			}
		}
		var $project_id = $(".saler-project-view-base").attr("data-project-id");
		var $info = 'p' + $project_id;
		var $hx = $hxs.join(",");
		
		var $data = {
			type: $type,
			hx: $hx,
			info: $info,
		}
		get_hot_sale($data, saler_url.hot_sale);
		
		return false;
	});
	
	
	//类型切换
	$(".js-saler-project-footer-tabs-btn").click(function() {
		// console.log(1);
		$(".js-saler-project-footer-tabs-btn").removeClass("saler-project-footer-tabs-btn-select");
		$(this).addClass("saler-project-footer-tabs-btn-select");
		
		var $type = $(this).attr("data-type");
		var $title = $(this).text().trim();
		var $hxs = [];
		
		$(".saler-project-view-content-sort-title-info").text($title);
		
		var $hx_select = $(".saler-project-view-content-right-nav-house-type-one-select");
		for (var $i = 0; $i < $hx_select.length; $i ++) {
			if (!$($hx_select[$i]).hasClass("saler-project-view-content-right-nav-house-type-all")) {
				$hxs.push($($hx_select[$i]).find('a').attr("data-hx"));
			}
		}
		
		var $project_id = $(".saler-project-view-base").attr("data-project-id");
		var $info = 'p' + $project_id;
		var $hx = $hxs.join(",");
		
		var $data = {
			type: $type,
			hx: $hx,
			info: $info,
		}
		get_hot_sale($data, saler_url.hot_sale);
		
		return false;
	});
	//清空搜索框
	$(".rs").on("click",function () {
		$(".saler-search-form-choose-option input").val('');
		$(".saler-search-form-choose-option a").removeClass('saler-search-form-choose-option-a-select');
    });
	//搜索
	$(".saler-project-view-content-search-input").focus(function() {
		var $project_id = $(".saler-project-id").attr("data-project-id");
		var $url = saler_url.search + "?info=p" + $project_id;
		
		window.location.href = $url;
	});
	
	//搜索 - 多条件筛选
	$(".js-saler-search-form-choose-btn").click(function() {
		$(".js-saler-search-form-input-box-input").val("");
		var $thiz = $(this);
		var $choose_option = $(".js-saler-search-form-choose-option");
		var $choose_option_shadow = $(".js-saler-search-form-choose-option-shadow");
		$("#shadow").show();
		if ($thiz.hasClass("saler-search-form-choose-btn-click")) {
			$choose_option
				.animate({"right": "-350px"}, function() {
					$(this).hide();
				});
				
			$choose_option_shadow.hide();
			$thiz.removeClass("saler-search-form-choose-btn-click");
		} else {
			$choose_option
				.css({"right": "-350px"})
				.show()
				.animate({"right": "0"});
				
			$choose_option_shadow.show();			
			$thiz.addClass("saler-search-form-choose-btn-click");
		}
	});
	
	//隐藏
	$("#shadow").click(function() {
		$(this).hide();
		$(".js-saler-search-form-choose-option")
			.animate({"right": "-350px"}, function() {
				$(this).hide();
			});		
		$(".js-saler-search-form-choose-btn").removeClass("saler-search-form-choose-btn-click");
	});
	
	//搜索 - 楼栋选择
	$(".js-saler-search-form-choose-option-a").click(function() {
		if ($(this).hasClass("saler-search-form-choose-option-a-select")) {
			$(this).removeClass("saler-search-form-choose-option-a-select");
		} else {
			$(this).addClass("saler-search-form-choose-option-a-select");
		}
		
	});
	
	//搜索 - 查询
	$(".js-saler-search-form-input-box-input").bind('input propertychange', function() {
		get_search_room_list(search_url.room,"ptss");
		return false;
	});
        
        //搜索 - 查询(获取焦点是查询)
	$(".js-saler-search-form-input-box-input").focus(function()  {
                    get_search_room_list(search_url.room,"ptss");
		return false;
	});
	
	//搜索 - 销售情况切换
	$(".saler-search-filter-sale").change(function() {
		get_search_room_list(search_url.room,"dtj");
		
		return false;
	});
	
	//搜索 - 确认
	$(".js-saler-search-form-choose-option-footer-btn").click(function() {
		$("#shadow").hide();
		$(".js-saler-search-form-choose-option")
			.animate({"right": "-350px"}, function() {
				$(this).hide();
			});		
		$(".js-saler-search-form-choose-btn").removeClass("saler-search-form-choose-btn-click");
		get_search_room_list(search_url.room,"dtj1");
		
		return false;
	});
	
	//搜索 - 查看房间详情
	$(".saler-search-filter-table").on('click', '.js-saler-search-filter-table-tr', function() {
		var $room_id = $(this).attr("data-id");
        var hid = $(".saler-search-project-id").attr("data-hd");
		var $url = saler_url.room_index + '?id=' + $room_id+"&hid="+hid;
		window.location.href = $url;
	});	
	
	
	//已售占比排名 - 排序
	$(".js-saler-saled-content-price-sort").on('click', function() {
		var $url = $(this).attr("data-href");
		window.location.href = $url;
	});
	show_price_sort_active();
	
	
	/*********************************************/
        
	//登录
	$(".js-saler-login-box-btn").click(function() {
            
		var $name = $(".saler-login-box-user-input").val();
		var $password = $(".saler-login-box-password-input").val();
		if ($name=="")
		{
			//showerror("请录入手机或用户代码！");
                        layer_alert("请录入手机或用户代码！");
			return false;
		}
		var $url = saler_url.login;
		var $data = {
			name: $name,
			pwd: $password,
		};
		$(".form").hide();
		$("#dlk").removeClass("container");
		$("#dlk").addClass("container1");
		$(".authent").show();
		ajax_post_callback($url, $data, function(data) {
			// console.log(data);
			// return false;
			if (data.status === 0) {
				layer_alert(data['info']);
				$(".authent").hide();
				$("#dlk").addClass("container");
				$("#dlk").removeClass("container1");
				$(".form").show();
			} else {
				location.href = data['info'];
			}
		});
	});
        //登录
	// $(".js-saler-login-box-btn1").click(function() {
	// 	var $name = $(".saler-login-box-user-input").val();
	// 	var $password = $(".saler-login-box-password-input").val();
	// 	if ($name=="")
	// 	{
	// 		//showerror("请录入手机或用户代码！");
     //                    layer_alert("请录入手机或用户代码！");
	// 		return false;
	// 	}
	// 	var $url = saler_url.login1;
	// 	var $data = {
	// 		name: $name,
	// 		pwd: $password,
	// 	};
	// 	$(".form").hide();
	// 	$("#dlk").removeClass("container");
	// 	$("#dlk").addClass("container1");
	// 	$(".authent").show();
	// 	ajax_post_callback($url, $data, function(data) {
	// 		if (data.status == 0) {
     //                            //showerror(data['info']);
	// 			layer_alert(data['info']);
	// 			$(".authent").hide();
	// 			$("#dlk").addClass("container");
	// 			$("#dlk").removeClass("container1");
	// 			$(".form").show();
	// 		} else {
	// 			//layer_alert("登录成功！");
	// 			//setTimeout(function() {
	// 				//location.href = saler_url.index;
     //                                    location.href = data['info'];
	// 			//}, 300);
	// 		}
	// 	});
	// });

	//退出登录
	$(".js-a-logout").click(function(){
		var $url = saler_url.logout;
		var $data = {
			type: "logout",
		};
		
		ajax_post_callback($url, $data, function(data) {
			if (data.status == 0) {
				layer_alert(data['info']);
			} else {
                console.log(1);
					location.href = "../logging/index.html";
			}
		});
	});

    $(".js-order-house-logout").click(function () {
        var $url = saler_event_house.logout;
        var $data = {
            type: "logout",
        };

        ajax_post_callback($url, $data, function(data) {
            if (data.status == 0) {
                layer_alert(data['info']);
            } else {
                console.log(2);
                location.href = "../EventOrderHouse/login.html";
            }
        });
    });

        //退出登录
	// $(".a-logout1").click(function(){
	// 	var $url = saler_url.logout;
	// 	var $data = {
	// 		type: "logout",
	// 	};
	//
	// 	ajax_post_callback($url, $data, function(data) {
	// 		if (data.status == 0) {
	// 			layer_alert(data['info']);
	// 		} else {
	// 				location.href = "../logging1/index.html";
	// 		}
	// 	});
	// });
        
        
	$(".js_xzproj_radio").click(function() {  
		var $a=$(this).parent();
		$a[0].click();
	});

    //event order house
    $(".js-order_house-project-footer-tabs-btn").click(function() {
        $(".js-order_house-project-footer-tabs-btn").removeClass("saler-project-footer-tabs-btn-select");
        $(this).addClass("saler-project-footer-tabs-btn-select");

        var $type = $(this).attr("data-type");
        var $title = $(this).text().trim();
        var $hxs = [];

        $(".saler-project-view-content-sort-title-info").text($title);

        var $hx_select = $(".saler-project-view-content-right-nav-house-type-one-select");
        for (var $i = 0; $i < $hx_select.length; $i ++) {
            if (!$($hx_select[$i]).hasClass("saler-project-view-content-right-nav-house-type-all")) {
                $hxs.push($($hx_select[$i]).find('a').attr("data-hx"));
            }
        }

        var $project_id = $(".saler-project-view-base").attr("data-project-id");
        var $info = 'p' + $project_id;
        var $hx = $hxs.join(",");

        var $data = {
            type: $type,
            hx: $hx,
            eventId : eventId,
        }
        get_hot_sale($data, saler_event_house.room);

        return false;
    });

    $(".js-order_house-login-box-btn").click(function() {

        var $name = $(".saler-login-box-user-input").val();
        var $password = $(".saler-login-box-password-input").val();
        if ($name=="")
        {
            //showerror("请录入手机或用户代码！");
            layer_alert("请录入手机或用户代码！");
            return false;
        }
        var $url = saler_event_house.login;
        var $data = {
            name: $name,
            pwd: $password,
        };
        $(".form").hide();
        $("#dlk").removeClass("container");
        $("#dlk").addClass("container1");
        $(".authent").show();
        ajax_post_callback($url, $data, function(data) {
            if (data.status == 0) {
                //showerror(data['info']);
                layer_alert(data['info']);
                $(".authent").hide();
                $("#dlk").addClass("container");
                $("#dlk").removeClass("container1");
                $(".form").show();
            } else {
                //layer_alert("登录成功！");
                //setTimeout(function() {
                //location.href = saler_url.index;
                location.href = data['info'];
                //}, 300);
            }
        });
    });

});

function showerror($info)
{
	$("#div-error-info").text($info);
	$("#div-error").show();
	return false;
}

function hiderror()
{
	$("#div-error-info").text("");
	$("#div-error").hide();
}

/**
 * 显示占比排序列
 *
 * @create 2016-10-11
 * @author zlw
 */
function show_price_sort_active() {
	var $index = $(".saler-saled-content-price-sort-active").index(".saler-saled-content-price-tr-title .saler-saled-content-price-td")

	var $sort_list = $(".saler-saled-content-price-tr");
	
	$sort_list.each(function() {
		$(this).find(".saler-saled-content-price-td")
			.eq($index)
			.addClass("saler-saled-content-price-td-sort-active");
	});
}


