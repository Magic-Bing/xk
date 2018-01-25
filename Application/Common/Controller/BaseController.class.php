<?php
namespace Common\Controller;

use Think\Controller;
use Think\Page;
use Lookey\Web\Page as LookeyPage;
use Lookey\Web\BootstrapPage as BootstrapPage;

/**
 * 基础控制器
 *
 * @create 2016-8-25
 * @author zlw
 */
class BaseController extends Controller 
{
        /**
	 * 构造方法
	 *
	 * @create 2016-9-6
	 * @author zlw
	*/ 
	public function _initialize()
	{ 
	}
  
	/**
	 * 空方法
	 *
	 * @create 2016-8-25
	 * @author zlw
	 */
	public function _empty()
	{
		$this->error('方法不存在！', U('/index/'));
        }

	
	/**
	 * 设置标题
	 *
	 * @create 2016-8-25
	 * @author zlw
	 */
    public function set_seo_title($seo_title = '') 
	{
        $this->assign('seo_title', $seo_title);
    }

	
	/**
	 * 设置关键字
	 *
	 * @create 2016-8-25
	 * @author zlw
	 */
    public function set_seo_keywords($seo_keywords = '') 
	{
        $this->assign('seo_keywords', $seo_keywords);
    }

	
	/**
	 * 设置描述
	 *
	 * @create 2016-8-25
	 * @author zlw
	 */
    public function set_seo_description($seo_description = '') 
	{
        $this->assign('seo_description', $seo_description);
    }

	
	/**
	 * 通用分页
	 *
	 * @create 2016-9-30
	 * @author zlw
	 */
    public function page($totalRows, $listRows = 20) 
	{
        $Page = new Page($totalRows, $listRows);
		$Page->lastSuffix = true;
		$Page->setConfig('header', '<span class="rows">共 %TOTAL_PAGE% 页</span>');
		$Page->setConfig('prev', '上一页');
		$Page->setConfig('next', '下一页');
		$Page->setConfig('first', '1');
		$Page->setConfig('last', '...%TOTAL_PAGE%');
		$Page->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		return $Page;
    }
    
	/**
	 * 通用分页 - 手机端
	 *
	 * @create 2016-10-31
	 * @author zlw
	 */
    public function mpage($totalRows, $listRows = 20) 
	{
        $Page = new LookeyPage($totalRows, $listRows);
		$Page->lastSuffix = true;
		$Page->setConfig('header', '<span class="rows">共 %TOTAL_PAGE% 页</span>');
		$Page->setConfig('prev', '←');
		$Page->setConfig('next', '→');
		$Page->setConfig('empty_prev', '<span class="prev">←</span>');
		$Page->setConfig('empty_next', '<span class="next">→</span>');
		$Page->setConfig('first', '1...');
		$Page->setConfig('last', '...%TOTAL_PAGE%');
		$Page->setConfig('theme', '%UP_PAGE% <span class="now"><span class="now_page">%NOW_PAGE%</span> / %TOTAL_PAGE%</span> %DOWN_PAGE%');
		return $Page;
    }

	/**
	 * 通用分页 - 适用于bootstrap分页
	 *
	 * @create 2016-12-26
	 * @author zlw
	 */
    public function bootstrapPage($totalRows, $listRows = 20) 
	{
        $Page = new BootstrapPage($totalRows, $listRows);
		$Page->lastSuffix = true;
		$Page->setConfig('header', '<li class="rows disabled"><a href="javascript:void(0);">共 %TOTAL_ROW% 条记录</a></li>');
		$Page->setConfig('prev', '<i class="icon-double-angle-left"></i>');
		$Page->setConfig('next', '<i class="icon-double-angle-right"></i>');
		$Page->setConfig('empty_prev', '<li class="disabled"><a href="javascript:void(0);"><i class="icon-double-angle-left"></i></a></li>');
		$Page->setConfig('empty_next', '<li class="disabled"><a href="javascript:void(0);"><i class="icon-double-angle-right"></i></a></li>');
		$Page->setConfig('first', '1');
		$Page->setConfig('last', '.%TOTAL_PAGE%');
		$Page->setConfig('theme', '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%');
		return $Page;
    }

    //判断是否手机打开
    public function is_mobile() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $mobile_agents = Array("240x320", "acer", "acoon", "acs-", "abacho", "ahong", "airness", "alcatel", "amoi", "android", "anywhereyougo.com", "applewebkit/525", "applewebkit/532", "asus", "audio", "au-mic", "avantogo", "becker", "benq", "bilbo", "bird", "blackberry", "blazer", "bleu", "cdm-", "compal", "coolpad", "danger", "dbtel", "dopod", "elaine", "eric", "etouch", "fly ", "fly_", "fly-", "go.web", "goodaccess", "gradiente", "grundig", "haier", "hedy", "hitachi", "htc", "huawei", "hutchison", "inno", "ipad", "ipaq", "ipod", "jbrowser", "kddi", "kgt", "kwc", "lenovo", "lg ", "lg2", "lg3", "lg4", "lg5", "lg7", "lg8", "lg9", "lg-", "lge-", "lge9", "longcos", "maemo", "mercator", "meridian", "micromax", "midp", "mini", "mitsu", "mmm", "mmp", "mobi", "mot-", "moto", "nec-", "netfront", "newgen", "nexian", "nf-browser", "nintendo", "nitro", "nokia", "nook", "novarra", "obigo", "palm", "panasonic", "pantech", "philips", "phone", "pg-", "playstation", "pocket", "pt-", "qc-", "qtek", "rover", "sagem", "sama", "samu", "sanyo", "samsung", "sch-", "scooter", "sec-", "sendo", "sgh-", "sharp", "siemens", "sie-", "softbank", "sony", "spice", "sprint", "spv", "symbian", "tablet", "talkabout", "tcl-", "teleca", "telit", "tianyu", "tim-", "toshiba", "tsm", "up.browser", "utec", "utstar", "verykool", "virgin", "vk-", "voda", "voxtel", "vx", "wap", "wellco", "wig browser", "wii", "windows ce", "wireless", "xda", "xde", "zte");
        $is_mobile = false;
        foreach ($mobile_agents as $device) {
            if (stristr($user_agent, $device)) {
                $is_mobile = true;
                break;
            }
        }
        return $is_mobile;
    }   
}
