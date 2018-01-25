/** 公共JS ***/

$(function() {
	"use strict";
	
	//返回添加选中
	var $select_room_list = $(".js-user-collection-room-checkbox:checked");
	if ($select_room_list.length > 0) {
		for (var $i = 0; $i < $select_room_list.length; $i ++) {
			var $room_id = $($select_room_list[$i]).attr("data-room-id");
			var $select_tr = $(".user-search-collection-table-tr-" + $room_id);
			$select_tr.addClass("user-search-collection-table-tr-selected");
		}
	}

	
	
});