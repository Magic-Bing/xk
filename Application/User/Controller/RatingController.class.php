<?php

namespace User\Controller;


/**
 * 评价
 *
 * @create 2016-10-17
 * @author zlw
 */
class RatingController extends BaseController
{
	
	/**
	 * 默认方法
	 *
	 * @create 2016-10-17
	 * @author zlw
	 */
    public function index()
	{
		$project = '光华国际';
		$this->assign('project', $project);
		
		$this->set_seo_title("项目评价");
        $this->display();
    }
	

	/**
	 * 添加评价
	 *
	 * @create 2016-10-17
	 * @author zlw
	 */
    public function save()
	{
		if (!IS_AJAX) {
			$this->error("提交错误，请重试！", U("index"));
		}
		
		$total = I("total", '', 'trim');
		$rating1 = I("rating1", '', 'intval');
		$rating2 = I("rating2", '', 'intval');
		$rating3 = I("rating3", '', 'intval');
		$content = I("content", '', 'trim');
		
		$this->success('评价成功！', U('index'));		
	}
	
}
