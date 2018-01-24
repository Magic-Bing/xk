<?php

/**
 * 根据条件获取ID
 *
 * @create 2016-8-23
 * @author zlw
 */
function get_search_id_by($str, $patterner, $default = '0') {
	$pattern = '/'.$patterner.'([0-9\.]+)/i';

	if (preg_match_all($pattern, $str, $match)) {
		return $match[1][0];
	} else {
		return $default;
	}
}


/**
 * 设置搜索条件格式
 *
 * @create 2016-8-24
 * @author zlw
 */
function set_search_ids($search_ids) {
	if (empty($search_ids) || !is_array($search_ids)) {
		return null;
	}
	
	$search_str = '';
	foreach ($search_ids as $search_key => $search_id) {
		if (!is_numeric($search_key)) {
			$search_str .= $search_key . $search_id;
		}
	}
	
	return $search_str;
}


/**
 * 微信日志记录
 *
 * @create 2016-11-17
 * @author zlw
 */
function add_weixin_log($message, $level = 'Weixin', $destination = '')
{
	if (empty($destination)) {
		$destination = C("WX.LOG_PATH").date('y_m_d').'.log';
	}
	
	Think\Log::write($message, $level, '', $destination);
}










