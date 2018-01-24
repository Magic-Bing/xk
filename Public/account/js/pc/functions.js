/** 销控JS ***/

/**
 * 提示
 *
 * @create 2016-12-27
 * @author zlw
 */
function gritter_alert(content, elements) {
	var elements = elements || 'gritter-error';
	$.gritter.add({
		title: '提示信息!',
		text: content,
		class_name: elements,
	});		
}

/**
 * 提示
 *
 * @create 2016-12-27
 * @author zlw
 */
function gritter_alert_success(content, elements) {
	var elements = elements || 'gritter-success';
	$.gritter.add({
		title: '提示信息!',
		text: content,
		class_name: elements,
	});		
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


