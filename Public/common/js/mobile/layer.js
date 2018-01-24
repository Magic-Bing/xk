/** 销控JS ***/

/**
 * 提示
 *
 * @create 2016-8-30
 * @author zlw
 */
function layer_tip(content, time) {
	layer.open({
		content: content,
		skin: 'msg',
		time: time || 2 
	});
}


/**
 * 弹出信息
 *
 * @create 2016-8-30
 * @author zlw
 */
function layer_alert(content, callBack) {
	layer.open({
		content: content,
		btn: '确认',
		yes: callBack
	});	
}


/**
 * 询问
 *
 * @create 2016-8-30
 * @author zlw
 */
function layer_confirm(content, yesCallBack, noCallBack) {
	layer.open({
		content: content,
		btn: ['取消', '确认'],
		yes: yesCallBack,
		no: noCallBack
	});	
}


/**
 * 底部对话框
 *
 * @create 2016-8-31
 * @author zlw
 */
function layer_footer_confirm(content, yesCallBack, noCallBack) {
	layer.open({
		content: content,
		btn: ['确认', '取消'],
		skin: 'footer',
		yes: yesCallBack,
		no: noCallBack
	});	
}

function layer_footer_confirm1(content, yesCallBack, noCallBack) {
    layer.open({
        content: content,
        btn: ['是', '否'],
        skin: 'footer',
        yes: yesCallBack,
        no: noCallBack
    });
}


/**
 * 底部提示
 *
 * @create 2016-8-31
 * @author zlw
 */
function layer_footer_tip(content) {
	layer.open({
		content: content,
		skin: 'footer',
	});	
}


/**
 * loading层
 *
 * @create 2016-8-31
 * @author zlw
 */
function layer_loading(content) {
	if (content == undefined) {
		layer.open({
			type: 2,
		});	
	} else {
		layer.open({
			type: 2,
			content: content,
		});	
	}
}

/**
 * 打开页面
 *
 * @create 2016-10-26
 * @author zlw
 */
function layer_html(content, height) {
	var height = height || '85%';
	
	return layer.open({
		type: 1,
		content: content,
		anim: 'up',
		style: 'position:fixed; bottom:0; left:0; width: 100%; height: '+height+'; padding:10px 0; border:none;'
	});
}

/**
 * 打开页面 - 自定义
 *
 * @create 2016-12-12
 * @author zlw
 */
function layer_user_html(content, anim) {
	var anim = anim || 'scale';
	
	return layer.open({
		type: 1,
		content: content,
		anim: anim,
		style: 'width: 100%;border:none;'
	});
}

/**
 * 关闭全部
 *
 * @create 2016-10-26
 * @author zlw
 */
function layer_close_all() {
	layer.closeAll();
}
