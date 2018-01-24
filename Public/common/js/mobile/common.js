/** 公共JS ***/

$(function() {
	"use strict";

	//返回
	$(".return-btn").on('click', 'a', function() {
		window.history.go(-1);
	});
	
});