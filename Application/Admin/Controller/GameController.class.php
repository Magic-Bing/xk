<?php

namespace Admin\Controller;


/**
 * 抢房管理
 *
 * @create 2016-10-20
 * @author zlw
 */
class GameController extends BaseController 
{
	
	/*#--------------- 抢房 -----------#*/
	
	/**
	 * 抢房列表
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
    public function index()
	{
		$id = I("id", 0, 'intval');
		$title = I("title", '', 'trim');
		$room_id = I("room_id", 0, 'intval');
		$start_time = I("start_time", '', 'trim');
                
		//活动
		$Game = D('Common/GameView');
		
		$where = array();
		if ($id != 0) {
			$where['id'] = $id;
		}
		$this->assign('id', $id); 
		if (!empty($title)) {
			$where['title'] = array('like', '%'.$title.'%');
			$this->assign('title', $title); 
		}
		if ($room_id != 0) {
			$where['room_name'] = array('like', '%'.$room_id.'%');
			$this->assign('room_id', $room_id); 
		}
		if (!empty($start_time)) {
			$where['start_time'] = array('gt', strtotime($start_time));
		}
		if (!empty($start_time)) {
			$start_time = strtotime(str_replace('+', ' ', $start_time));
			$format_start_time = date('Y-m-d H:i:s', $start_time);
		} else {
			$format_start_time = '';
		}
		$this->assign('start_time', $format_start_time); 
		
		//活动总数
		$count = $Game->where($where)->count();
	
		//分页
		$Page 		= $this->page($count, 20);
		$page_show  = $Page->show();	
		$this->assign('page_show', $page_show); 
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
		
		$game_list = $Game->getList($where, 'start_time DESC, create_time DESC', $limit);
		$this->assign('game_list', $game_list);	

		$this->set_seo_title("抢房列表");
        $this->display();
    } 
	
	
	/**
	 * 添加
	 *
	 * @create 2016-10-20
	 * @author zlw
	 */
    public function add()
	{
		if (IS_POST) {
			$title = I('title', '', 'trim');
			$room_id = I('room_id', 0, 'intval');
			$start_time = I('start_time', 0, 'trim');
			$end_time = I('end_time', 0, 'trim');
			$allow_num = I('allow_num', 0, 'intval');
			$use_num = I('use_num', 0, 'intval');
			$time_length = I('time_length', 0, 'intval');
			$content = I('content', '', 'trim');
			$is_open = I('is_open', 0, 'intval');
			
			if (empty($title)) {
				$this->error("标题不能为空，请确认后重试！", '');
			}
			if (empty($room_id)) {
				$this->error("房间ID不能为空，请确认后重试！", '');
			}
			if (empty($start_time)) {
				$this->error("开始不能为空，请确认后重试！", '');
			}
			if (empty($allow_num)) {
				$this->error("允许次数不能为空，请确认后重试！", '');
			}
			if (empty($time_length)) {
				$this->error("时间长度不能为空，请确认后重试！", '');
			}
			if (empty($is_open) && $is_open != 0) {
				$this->error("是否开启不能为空，请确认后重试！", '');
			}
			
			$Game = D('Common/Game');
			
			$info = $Game->getOneByRoomId($room_id);
			if (!empty($info)) {
				$this->error("该房间已经有活动，请选择其他房间！", U('game/index'));
			}
			
			$data['title'] = $title;
			$data['room_id'] = $room_id;
			$data['start_time'] = strtotime($start_time);
			$data['next_start_time'] = strtotime($start_time);
			if ($end_time != 0) {
				$data['end_time'] = strtotime($end_time);
			}
			$data['allow_num'] = $allow_num;
			$data['use_num'] = $use_num;
			$data['time_length'] = $time_length;
			$data['content'] = $content;
			$data['is_open'] = $is_open;
			
			$user_id = $this->get_user_id();
			$data['create_user_id'] = $user_id;
			
			//添加
			$check_has_add = $Game->addOne($data);
			if (false === $check_has_add) {
				$this->error("添加活动失败，请重试！", U('game/index'));
			}
			
			$this->success("添加活动成功！", U('game/index'));
		} else {
                    
                         //项目ID
			$project_id = I('project_id', 0, 'intval');
			$this->assign('project_id', $project_id);
		
			//获取项目列表
			$project_where = array();
                        $project_where['status']=1;
			$project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '50');
			if (!empty($project_old_list)) {
				foreach ($project_old_list as $project_list_key => $project_list_value) {
					$project_list[$project_list_value['id']] = $project_list_value;
				}
			} else {
				$project_list = array();
			}
			$this->assign('project_list', $project_list);
                    
			$room_id = I('id', '', 'intval');
			$this->assign('room_id', $room_id);	

			$room = array();
			if (!empty($room_id)) {
				$room = D('Common/Roomview')->getOneById($room_id);
			}
			$this->assign('room', $room);	
			
			$this->set_seo_title("添加活动");
			$this->display();
		}
    } 
	
	
	/**
	 * 删除
	 *
	 * @create 2016-10-21
	 * @author zlw
	 */
    public function delete()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("活动不存在，请确认后重试！");
		}
		
		$game = D('Common/Game')->getOneById($id);
		if (empty($game)) {
			$this->success("删除活动成功！");
		}
		
		$check_has_delete = D('Common/Game')->deleteOneById($id);
		if (false === $check_has_delete) {
			$this->error("删除活动失败，请确认后重试！");
		}
		
		$this->success("删除活动成功！");
	}
	
	
	/**
	 * 更改
	 *
	 * @create 2016-10-21
	 * @author zlw
	 */
    public function edit()
	{
		if (IS_POST) {
			$id = I('id', 0, 'trim');
			if ($id == 0) {
				$this->error("活动ID错误，请选择其他房间！");
			}
			
			$title = I('title', '', 'trim');
			$room_id = I('room_id', 0, 'intval');
			$start_time = I('start_time', 0, 'trim');
			$next_start_time = I('next_start_time', 0, 'trim');
			$end_time = I('end_time', 0, 'trim');
			$allow_num = I('allow_num', 0, 'intval');
			$use_num = I('use_num', 0, 'intval');
			$time_length = I('time_length', 0, 'intval');
			$content = I('content', '', 'trim');
			$is_open = I('is_open', 0, 'intval');
			$is_end = I('is_end', 0, 'intval');
			
			if (empty($title)) {
				$this->error("标题不能为空，请确认后重试！", '');
			}
			if (empty($room_id)) {
				$this->error("房间ID不能为空，请确认后重试！", '');
			}
			if (empty($start_time)) {
				$this->error("开始时间不能为空，请确认后重试！", '');
			}
			if (empty($allow_num)) {
				$this->error("允许次数不能为空，请确认后重试！", '');
			}
			if (empty($time_length)) {
				$this->error("时间长度不能为空，请确认后重试！", '');
			}
			if (empty($is_open) && $is_open != 0) {
				$this->error("状态不能为空，请确认后重试！", '');
			}
			
			$Game = D('Common/Game');
			
			$info = $Game->getOneById($id);
			if (empty($info)) {
				$this->error("活动不存在，请选择其他活动！", U('game/index'));
			}
			
			$data['title'] = $title;
			$data['room_id'] = $room_id;
			$data['start_time'] = strtotime($start_time);
			$data['next_start_time'] = strtotime($next_start_time);
			if ($data['start_time'] > $data['next_start_time']) {
				$data['next_start_time'] = strtotime($start_time);
			}
			if ($end_time != 0) {
				$data['end_time'] = strtotime($end_time);
			}
			$data['allow_num'] = $allow_num;
			$data['use_num'] = $use_num;
			$data['time_length'] = $time_length;
			$data['content'] = $content;
			$data['is_open'] = $is_open;
			$data['is_end'] = $is_end;
			
			$user_id = $this->get_user_id();
			$data['create_user_id'] = $user_id;
			
			//更改
			$check_has_edit = $Game->editOneById($id, $data);
			if (false === $check_has_edit) {
				$this->error("更改活动失败，请重试！", U('game/index'));
			}
			
			$this->success("更改活动成功！", U('game/index'));
		} else {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error("活动ID错误，请选择其他房间！");
			}
			$this->assign('id', $id);
		
			//获取项目列表
			$project_where = array();
                        $project_where['status']=1;
			$project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '50');
			if (!empty($project_old_list)) {
				foreach ($project_old_list as $project_list_key => $project_list_value) {
					$project_list[$project_list_value['id']] = $project_list_value;
				}
			} else {
				$project_list = array();
			}
			$this->assign('project_list', $project_list);
                        
                        
                        
			//活动信息
			$game = D('Common/Game')->getOneById($id);
			if (empty($game)) {
				$this->error("活动不能存在，请选择其他房间！");
			}
			$this->assign('game', $game);	
			
			//获取房间信息
			$room_id = $game['room_id'];
			$room = D('Common/Roomview')->getOneById($room_id);
			$this->assign('room', $room);	
                        
                         //项目ID
			$project_id = $room['proj_id'];
			$this->assign('project_id', $project_id);
			
			$this->set_seo_title("编辑活动");
			$this->display();
		}
    } 

	/*#--------------- 抢购 -----------#*/
	
	/**
	 * 抢购
	 *
	 * @create 2016-10-31
	 * @author zlw
	 */
    public function click()
	{
		$GameclickView = D("GameclickView");
		
		$name = I('get.name', '', 'trim');
		$this->assign('name', $name);	
		$user = I('get.user', '', 'trim');
		$this->assign('user', $user);
		
		$start_time = I('get.start_time', '', 'trim');
		if (!empty($start_time)) {
			$start_time = strtotime(str_replace('+', ' ', $start_time));
			$format_start_time = date('Y-m-d H:i:s', $start_time);
		} else {
			$format_start_time = '';
		}
		$this->assign('start_time', $format_start_time); 
		
		$end_time = I('get.end_time', '', 'trim');
		if (!empty($end_time)) {
			$end_time = strtotime(str_replace('+', ' ', $end_time));
			$format_end_time = date('Y-m-d H:i:s', $end_time);
		} else {
			$format_end_time = '';
		}
		$this->assign('end_time', $format_end_time);	
		
		$where = array();
		if (!empty($name)) {
			$where['game_title'] = array('like', '%'.$name.'%');
		}
		if (!empty($user)) {
			$where['customer_name'] = array('like', '%'.$user.'%');
		}
		if (!empty($start_time)) {
			$where['create_time'][] = array('egt', strtotime($start_time));
		}
		if (!empty($end_time)) {
			$where['create_time'][] = array('elt', strtotime($end_time));
		}
		
		//活动总数
		$count = $GameclickView->where($where)->count();
	
		//分页
		$Page 		= $this->page($count, 20);
		$page_show  = $Page->show();	
		$this->assign('page_show', $page_show); 
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
		
		$click_list = $GameclickView->getList($where, 'id DESC', $limit);
		$this->assign('click_list', $click_list);	
		
		$this->set_seo_title("抢购列表");
		$this->display();
	}	

	
	/**
	 * 抢购 - 删除
	 *
	 * @create 2016-10-31
	 * @author zlw
	 */
    public function click_delete()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("ID不能为空，请确认后重试！");
		}
		
		$where['id'] = $id;
		$status = D('Game')->deleteStatistics($where);
		if ($status === false) {
			$this->error("删除失败，请确认后重试！");
		}
		
		$this->success("删除成功！");
	}
	
	/*#--------------- 中奖 -----------#*/
	
	/**
	 * 中奖
	 *
	 * @create 2016-10-31
	 * @author zlw
	 */
    public function prize()
	{
		$GameprizeView = D("GameprizeView");
		
		$user = I('get.user', '', 'trim');
		$this->assign('user', $user);	
		$phone = I('get.phone', '', 'trim');
		$this->assign('phone', $phone);	
		$code = I('get.code', '', 'trim');
		$this->assign('code', $code);

		$start_time = I('get.start_time', '', 'trim');
		if (!empty($start_time)) {
			$start_time = strtotime(str_replace('+', ' ', $start_time));
			$format_start_time = date('Y-m-d H:i:s', $start_time);
		} else {
			$format_start_time = '';
		}
		$this->assign('start_time', $format_start_time); 
		
		$end_time = I('get.end_time', '', 'trim');
		if (!empty($end_time)) {
			$end_time = strtotime(str_replace('+', ' ', $end_time));
			$format_end_time = date('Y-m-d H:i:s', $end_time);
		} else {
			$format_end_time = '';
		}
		$this->assign('end_time', $format_end_time);	
		
		$where = array();
		if (!empty($user)) {
			$where['customer_name'] = array('like', '%'.$user.'%');
		}
		if (!empty($phone)) {
			$where['phone'] = array('like', '%'.$phone.'%');
		}
		if (!empty($code)) {
			$where['code'] = array('like', '%'.$code.'%');
		}
		if (!empty($start_time)) {
			$where['time'][] = array('egt', strtotime($start_time));
		}
		if (!empty($end_time)) {
			$where['time'][] = array('elt', strtotime($end_time));
		}
		
		//活动总数
		$count = $GameprizeView->where($where)->count();
	
		//分页
		$Page 		= $this->page($count, 20);
		$page_show  = $Page->show();	
		$this->assign('page_show', $page_show); 
		
		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
		
		//中奖列表
		$prize_list = $GameprizeView->getList($where, 'buy_time DESC, time DESC, id DESC', $limit);
		$this->assign('prize_list', $prize_list); 
		
		$this->set_seo_title("中奖列表");
		$this->display();
	}	

	
	/**
	 * 抢购 - 删除
	 *
	 * @create 2016-10-31
	 * @author zlw
	 */
    public function prize_delete()
	{
		if (!IS_POST) {
			$this->error("访问错误，请确认后重试！");
		}
		
		$id = I('post.id', 0, 'intval');
		if ($id == 0) {
			$this->error("ID不能为空，请确认后重试！");
		}
		
		$where['id'] = $id;
		$status = D('GamePrize')->deleteOne($where);
		if ($status === false) {
			$this->error("删除失败，请确认后重试！");
		}
		
		$this->success("删除成功！");
	}
	
	
	/**
	 * 抢购 - 更改
	 *
	 * @create 2016-10-31
	 * @author zlw
	 */
    public function prize_edit()
	{
		if (IS_POST) {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error("ID错误，请确认后重试！");
			}
			
			$time = I('post.time', '', 'trim');
			$is_buy = I('post.is_buy', 0, 'intval');
			$phone = I('post.phone', '', 'trim');
			$buy_time = I('post.buy_time', '', 'trim');
			$code = I('post.code', '', 'trim');
			$is_delete = I('post.is_delete', 0, 'intval');
			$remark = I('post.remark', '', 'trim');
			
			$GamePrize = D('Common/GamePrize');
			
			if (!empty($time)) {
				$data['time'] = strtotime($time);
			}
			$data['is_buy'] = $is_buy;
			if (!empty($phone)) {
				$data['phone'] = $phone;
			}
			if (!empty($buy_time)) {
				$data['buy_time'] = strtotime($buy_time);
			}
			if (!empty($code)) {
				$data['code'] = $code;
			}
			$data['is_delete'] = intval($is_delete);
			$data['remark'] = trim($remark);
			
			//更改
			$check_has_edit = $GamePrize->editOneById($id, $data);
			if (false === $check_has_edit) {
				$this->error("更改失败，请重试！", U('index'));
			}
			
			$this->success("更改成功！", U('index'));
		} else {
			$id = I('id', 0, 'intval');
			if ($id == 0) {
				$this->error("中奖信息ID错误，请确认后重试！");
			}
			$this->assign('id', $id);
			
			//活动信息
			$prize = D('GameprizeView')->getOneById($id);
			if (empty($prize)) {
				$this->error("中奖信息不能存在，请确认后重试！");
			}
			$this->assign('prize', $prize);				
			
			//获取房间信息
			$room_id = $prize['room_id'];
			$room = D('Common/Roomview')->getOneById($room_id);
			$this->assign('room', $room);	
			
			$this->set_seo_title("中奖编辑");
			$this->display();
		}
    } 
    
    public function search_room()
    {
            if (!IS_AJAX) {
                    $this->error('请求错误，请确认后重试！', U('room/index'));
            }

            //条件
            $search_info = I('info', '', 'trim');
            $proj_id = I('proj_id', '', 'trim');
            
            if (empty($proj_id)) {
                    $this->error('项目不能为空','');
            }
            
            if (empty($search_info)) {
                    $this->error('搜索条件为空，请确认后重试！','');
            }
            
            //当前房间
            $where['proj_id'] = $proj_id;
            $where['room'] = array('like', '%' . $search_info . '%');
            $where[] ="991=991";
            $rooms = D("Roomview")->getRoomList($where, "cast(buildcode as SIGNED) ASC, cast(unit as SIGNED) ASC, cast(floor as SIGNED) DESC, cast(room as SIGNED) ASC");

            $this->success($rooms,'');
    }
	
}









