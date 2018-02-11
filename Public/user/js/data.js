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
    
    condition.room[0] = $.trim( $(".user-search-form-choose-option-room-start").val() ) == '' ? 0 : $(".user-search-form-choose-option-room-start").val();
    condition.room[1] = $.trim( $(".user-search-form-choose-option-room-end").val() ) == '' ? 0 : $(".user-search-form-choose-option-room-end").val();

    condition.hx = [];
    $(".user-search-form-choose-option-a-select").each(function () {
        condition.hx.push($.trim(this.innerText));
    });
    var $isxz= $('#checkbox_a1').is(':checked');
    if($isxz)
        condition.ds=1;
    else
        condition.ds=0;
    
    if (condition.ds==0 && condition.hx.length==0  && condition.level[0]==0 && condition.level[1]==0 && condition.area[0]==0 && condition.area[1]==0 && condition.total[0]==0 && condition.total[1]==0)
    {
       $(".roomseach").removeClass("roomseach_selected")
    }
    else
    {
        $(".roomseach").addClass("roomseach_selected")
    }
        var $url = orderHouse.room;
        var $data = {
            condition:condition
        };
        
         ajax_post_callback($url, $data, function (data, status) {
            if (data.status==1) { 
               renderRoom(data.info[1]);
            }else {
                layer_alert('提交连接失败！');
            }
        })
}


$(document).on('click','.common-header-unit-info-new',function () {

    if (!$.trim($(this).data('build'))) return false;
	if (!$.trim($(this).data('unit'))) return false;
	var h=window.location.host;
    var bid = $(this).data('build');
    var uid = $(this).data('unit');
	window.location.href="http://"+h+"/User/index/index/info/p"+condition.event_id+"b"+bid+"u"+uid+".html";

});

$(document).on('click','.js-common-header-unit-info',function () {

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
    window.location.hash="b"+$(this).data('build')+"u"+$(this).data('unit');

    get_user_room_list();
     $(".user-project-view-content-selected-num").text(0);
        if ( $(".js-user-project-view-content-search-compare-btn").hasClass("user-project-view-content-search-compare-btn-click"))
        {
            $(".js-user-project-view-content-search-compare-btn").click();
        }
    $(this).addClass('common-header-unit-info-selected').siblings().removeClass('common-header-unit-info-selected');
});

