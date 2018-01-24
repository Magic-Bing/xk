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

/**
 * 提示
 *
 * @create 2016-9-30
 * @author zlw
 */
function layer_msg(content) {
	layer.msg(content);
}


/**
 * 询问框
 *
 * @create 2016-10-21
 * @author zlw
 */
function layer_confirm(content, callBack) {
	//询问框
	layer.confirm(content, {
		btn: ['取消', '确认'], //按钮
		skin: 'layui-layer-molv', //样式类名
	}, function(index) {
		layer.close(index);
	}, callBack);	
}


/**
 * Tip框
 *
 * @create 2016-12-02
 * @author zlw
 */
function layer_tip(content, elements, postion) {
	var pos = postion || 'left';
	var postion = '';
	switch (pos.toLowerCase()) {
		case 'left': 
			postion = 4;
			break;
			
		case 'right': 
			postion = 2;
			break;
			
		case 'top': 
			postion = 1;
			break;
			
		case 'bottom': 
			postion = 3;
			break;
			
		default:
			postion = 4;
	}
	
	layer.tips(content, elements, {
		tips: [postion, '#0FA6D8'] //还可配置颜色
	});	
}


/**
 * 页面层
 *
 * @create 2016-12-02
 * @author zlw
 */
function layer_html(content, skin, closeBtn) {
	var skin = skin || 'layer-html';
	var closeBtn = closeBtn || false;
	
	return layer.open({
		type: 1,
		title: false,
		closeBtn: closeBtn,
		shadeClose: true,
		skin: skin,
		content: content
	});
}

/**
 * 关闭全部
 *
 * @create 2016-12-20
 * @author zlw
 */
function layer_close_all() {
	layer.closeAll();
}


