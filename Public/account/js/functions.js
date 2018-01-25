/***================= 公共方法 =================***/

/**
 * 异步请求
 *
 * @create 2016-9-7
 * @author zlw
 */
function ajax_post_callback($url, $data, $callback) {	
	$.ajax({
		url: $url,
		data: $data,
		type: 'POST',
		dataType: 'JSON',
		success: $callback,
		error: function (data, status, e) {
			layer_alert('提交连接失败！');
		}
	}); 
}


/**
 * 异步get请求
 *
 * @create 2016-9-28
 * @author zlw
 */
function ajax_get_callback($url, $callback) {	
	$.ajax({
		url: $url,
		data: {},
		type: 'GET',
		dataType: 'JSON',
		success: $callback,
		error: function (data, status, e) {
			layer_alert('提交连接失败！');
		}
	}); 
}


/**
 * 数组去重
 *
 * @create 2016-9-7
 * @author zlw
 */
function array_unique($array) {
	var res = [];
	var json = {};
	
	for (var i = 0; i < $array.length; i++) {
		if (!json[$array[i]]) {
			res.push($array[i]);
			
			json[$array[i]] = 1;
		}
	}
	
	return res;
}


/**
 * 全选或者全不选
 *
 * @create 2016-9-12
 * @author zlw
 */
function is_checked_all($list_id, $all_id) { 
    var chknum = $($list_id).size();//选项总个数 
    var chk = 0; 
	
    $($list_id).each(function () {   
        if ($(this).prop("checked") == true) { 
            chk++; 
        } 
    }); 
	
    if (chknum == chk) {//全选 
        $($all_id).prop("checked", true); 
    } else {//不全选 
        $($all_id).prop("checked", false); 
    } 
}


/**
 * 品牌翻转
 *
 * @create 2016-9-20
 * @author zlw
 */
function turnner(target, time, opts) {
	target.find('a').hover(function(){
		$(this).find('img').stop().animate(opts[0],time,function(){
			$(this).hide().next().show();
			$(this).next().animate(opts[1],time);
		});
	},function(){
		$(this).find('.info').animate(opts[0],time,function(){
			$(this).hide().prev().show();
			$(this).prev().animate(opts[1],time);
		});
	});
}


/**
 * 获取根目录
 *
 * @create 2016-9-20
 * @author zlw
 */
function get_root_path() {
	var strFullPath	= window.document.location.href;
	var strPath		= window.document.location.pathname;
	var pos			= strFullPath.indexOf(strPath);
	var prePath		= strFullPath.substring(0,pos);
	var postPath	= strPath.substring(0, strPath.substr(1).indexOf('/') + 1);
	return (prePath + postPath);
}


/**
 * 获取随机颜色
 *
 * @create 2016-9-22
 * @author zlw
 */
function get_random_color() {    
	return  '#' +    
		(function(color) {    
			return (color +=  '0123456789abcdef'[Math.floor(Math.random()*16)])    
				&& (color.length == 6) ?  color : arguments.callee(color);    
		})('');    
} 


/**
 * 判断手机号码
 *
 * @create 2016-10-27
 * @author zlw
 */
function validate_mobile(mobile)  { 
	if (mobile.length == 0) { 
		return false; 
	}     
	if (mobile.length != 11) { 
		return false; 
	} 

	var check_reg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
	if (!check_reg.test(mobile)) { 
		return false; 
	} 
	
	return true;
} 


/**
 * 判断字符串是否为JSON格式
 *
 * @create 2016-12-14
 * @author zlw
 */
function is_json(json)  { 
	if (!json.match("^\{(.+:.+,*){1,}\}$")) {
		return false;
	} else {
		return true;
	}
}


/**
 * 判断是否为数组类型 
 *
 * @create 2016-12-14
 * @author zlw
 */
function is_array(obj) { 
	return (typeof obj == 'object') 
		&& (obj.constructor == Array); 
} 


/**
 * 判断字符串是否为字符串
 *
 * @create 2016-12-14
 * @author zlw
 */
function is_string(str) { 
	return (typeof str == 'string')
		&& (str.constructor == String); 
} 


/**
 * 判断是否为数值类型 
 *
 * @create 2016-12-14
 * @author zlw
 */
function is_number(obj) { 
	return (typeof obj == 'number')
		&& obj.constructor == Number; 
} 


/**
 * 判断是否为日期类型  
 *
 * @create 2016-12-14
 * @author zlw
 */
function is_date(obj) { 
	return (typeof obj == 'object')
		&& (obj.constructor == Date); 
} 


/**
 * 判断是否为函数   
 *
 * @create 2016-12-14
 * @author zlw
 */
function is_function(obj) { 
	return (typeof obj == 'function') 
		&& (obj.constructor == Function); 
} 	


/**
 * 判断是否为对象    
 *
 * @create 2016-12-14
 * @author zlw
 */
function is_object(obj) { 
	return (typeof obj == 'object') 
		&& (obj.constructor == Object); 
} 







