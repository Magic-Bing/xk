/** 销控JS ***/

/**
 * 提示
 *
 * @create 2016-8-22
 * @author zlw
 */
function layer_alert(content, callBack,time) {
	layer.alert(content, {
		skin: 'layui-layer-molv', //样式类名
		closeBtn: 0,
		shade: false,
		time:time
	}, callBack);	
}
/*
* 提示框】
* 2017-10-11
* qzb*/
function layer_alert_two(content, callBack,time) {
    layer.alert(content, {
        skin: 'layui-layer-qz', //样式类名
        closeBtn: 0,
        shade: [0.5,"black"],
        time:time
    }, callBack);
}

//无按钮提示
function layer_msg(content) {
    layer.msg(content);
}

//提示
function layer_alert_one(content, title,callBack) {
    layer.alert(content, {
        skin: 'layui-layer-wz', //样式类名
        closeBtn: 0,
		title:title,
        shade: false,
        btnAlign:'c',
    }, callBack);
}

/**
 * 更改高度
 *
 * @create 2018-8-23
 * @author zlw
 */
function resize_layout($id, $no_height) {
	$no_height = $no_height || 0;
	
	var height = $(window).height() - $no_height;
	$($id).css("height", height)
}
