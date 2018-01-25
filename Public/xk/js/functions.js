/** 销控JS ***/

/**
 * 提示
 *
 * @create 2016-9-30
 * @author zlw
 */
function layer_alert(content, callBack) {
	layer.alert(content, {
		skin: 'layui-layer-molv', //样式类名
		closeBtn: 0,
		shade: false,
	}, callBack);	
}

