/** 数据JS ***/

/**
 * 获取热销房间
 *
 * @create 2016-9-1
 * @author zlw
 */
function get_hot_sale_room($data, $url) {
	$.ajax({
		url: $url || user_url.hot_sale,
		data: $data,
		type: 'POST',
		dataType: 'HTML',
		success: function (data, status) {
			if (data.length <= 0) {
				return false;
			}
	
			$(".user-project-sort-content-box").html(data);
		},
		error: function (data, status, e) {
			layer_alert('提交连接失败！');
			return false;
		}
	}); 
}


/**
 * 房间列表
 *
 * @create 2016-9-6
 * @author zlw
 */
function get_user_room_list() {

    // level : [0,0],
    //     area : [0,0],
    //     total : [0,0],
    //     hx : ''
    condition.level[0] = $.trim( $(".user-search-form-choose-option-floor-start").val() ) == '' ? 0 : $(".user-search-form-choose-option-floor-start").val();
    condition.level[1] = $.trim( $(".user-search-form-choose-option-floor-end").val() ) == '' ? 0 : $(".user-search-form-choose-option-floor-end").val();

    condition.area[0] = $.trim( $(".user-search-form-choose-option-area-start").val() ) == '' ? 0 : $(".user-search-form-choose-option-area-start").val();
    condition.area[1] = $.trim( $(".user-search-form-choose-option-area-end").val() ) == '' ? 0 : $(".user-search-form-choose-option-area-end").val();

    condition.total[0] = $.trim( $(".user-search-form-choose-option-price-start").val() ) == '' ? 0 : $(".user-search-form-choose-option-price-start").val();
    condition.total[1] = $.trim( $(".user-search-form-choose-option-price-end").val() ) == '' ? 0 : $(".user-search-form-choose-option-price-end").val();

    condition.hx = [];
    $(".user-search-form-choose-option-a-select").each(function () {
        condition.hx.push($.trim(this.innerText));
    });
    var $isxz= $('#checkbox_a1').is(':checked');
    if($isxz)
        condition.ds=1;
    else
        condition.ds=0;
    
    var isselected=false;
    if(condition.level[0]>0 || condition.level[1]>0){ isselected=true;} 
    if(condition.area[0]>0 || condition.area[1]>0){ isselected=true;} 
    if(condition.total[0]>0 || condition.total[1]>0){isselected=true;} 
    if(condition.hx.length>0){isselected=true;} 
    if(condition.ds>0){ isselected=true;} 
    if(isselected){$(".user-search-form-choose-btn-click").addClass("roomseach_selected");}
    else{$(".user-search-form-choose-btn-click").removeClass("roomseach_selected");}
    
	$.ajax({
		url: orderHouse.room,
		data: {
            condition
		},
		type: 'POST',
		dataType: 'JSON',
		success: (data, status) => {
			renderRoom(data);
		},
		error: (data, status, e) => {
			layer_alert('提交连接失败！');
		}
	}); 
}

$(document).on('click','.common-header-unit-info',function () {

    if (!$.trim($(this).data('build'))) return false;
	if (!$.trim($(this).data('unit'))) return false;

    $(".user-project-view-content-rooms-table").show();
    $(".speedbuy-content").hide();
    $(".user-project-footer").show();
    $(".user-project-view-content-gwc-wrapper") .show();
    $(".user-header-zw").show();
    $(".user-header-return").hide();

    condition.build_id = $(this).data('build');
	condition.unit_id = $(this).data('unit');

    get_user_room_list();

    $(this).addClass('common-header-unit-info-selected').siblings().removeClass('common-header-unit-info-selected');

});
