/**
 * 中奖
 *
 * @create 2016-9-20
 * @author zlw
 *
*/
var $zcount = 1;
var $icount = 1;
var $num = 1;

$(function() {
	"use strict";
	
	//显示中奖信息
	var $isshow=$("#in_is_show").val();
	$zcount = $("#in_prize_count").val();
	if ($isshow == 1) {
		prizes_show();
	} else {
		prizes_hide();
	}

	// 点击查看
	$(".js-prizes-see-btn").click(function() {
		prizes_show();
	});

	// 关闭
	$(".js-prizes-show-close-btn, .js-prizes-show-shadow").click(function() {
		var $prizes_show = $(".js-prizes-show");
		var $prizes_show_box = $(".js-prizes-show-box");
		var $prizes_show_shadow = $(".js-prizes-show-shadow");
		var $prizes_see_btn = $(".js-prizes-see-btn");
		
		$prizes_see_btn.show();
		$prizes_show.fadeOut('slow', function() {
			$prizes_show_shadow.hide();
			$prizes_show.removeClass("prizes-show-transform")
		});
	});
	
	
	$(".js-prizes-show-next-btn").click(function() {
		shownext();
	});
	$(".js-prizes-show-last-btn").click(function() {
		showlast();
	});
	
});


/**
 * 显示中奖信息
 *
 * @create 2016-9-21
 * @author zlw
 *
*/
function prizes_show() {
	var $prizes_show = $(".js-prizes-show");
	var $prizes_show_box = $(".js-prizes-show-box");
	var $prizes_show_shadow = $(".js-prizes-show-shadow");
	
	$prizes_show_shadow.fadeIn('fast', function() {
		$prizes_show.addClass("prizes-show-transform");
		$(".js-prizes-see-btn").hide();
                $(".js-prizes-see-btn1").hide();
	});
	$prizes_show.fadeIn('slow');
	
	if ($zcount > 1 && $icount < 2) {
		$(".js-prizes-show-next-btn").css("margin-left","35%");
		$(".js-prizes-show-last-btn").css("margin-left","11%");
		$(".js-prizes-show-last-btn").hide();
		$(".js-prizes-show-next-btn").show();
	}
}

function prizes_hide() {
	var $prizes_show = $(".js-prizes-show");
	var $prizes_show_shadow = $(".js-prizes-show-shadow");
	var $prizes_see_btn = $(".js-prizes-see-btn");
	
	$prizes_see_btn.show();
	$prizes_show_shadow.hide();
	$prizes_show.removeClass("prizes-show-transform")
}

function shownext()
{
	var $count = $(".prize-grades-input").size();
	if ($num >= $count) {
		$num = 1;
	} else {
		$num = $num + 1;
	}
	
	$icount = $icount + 1;
	
	$(".prizes-show-img-grades-info").text($(".prize-grades-" + $num).val());
	$(".prizes-show-img-name-info").text($(".prize-name-" + $num).val());
	
	$(".js-prizes-show-next-btn").css("margin-left","11%");
	if ($icount<$zcount )
	{
		$(".js-prizes-show-next-btn").show();
	}
	else{
		$(".js-prizes-show-next-btn").hide();
		$(".js-prizes-show-last-btn").css("margin-left","35%");
	}
	$(".js-prizes-show-last-btn").show();
}

function showlast()
{
	var $count = $(".prize-grades-input").size();
	if ($num <= 1) {
		$num = $count;
	} else {
		$num = $num - 1;
	}
	
	$icount=$icount-1;
	$(".prizes-show-img-grades-info").text($(".prize-grades-" + $num).val());
	$(".prizes-show-img-name-info").text($(".prize-name-" + $num).val());
	
	$(".js-prizes-show-last-btn").css("margin-left","11%");
	if ($icount>1 )
	{
		$(".js-prizes-show-last-btn").show();
	}
	else{
		$(".js-prizes-show-last-btn").hide();
		$(".js-prizes-show-next-btn").css("margin-left","35%");
	}
	$(".js-prizes-show-next-btn").show();
}










