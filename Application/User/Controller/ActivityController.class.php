<?php

namespace User\Controller;

use Lookey\Lottery\Rander as Lottery;
use Org\Util\String as Stringer;

/**
 * 活动
 *
 * @create 2016-10-21
 * @author zlw
 */
class ActivityController extends BaseController {

    /**
     * 间隔时间
     *
     * @create 2016-11-3
     * @author zlw
     */
    private $interval_time = 60;

    /**
     * 构造方法
     *
     * @create 2016-10-26
     * @author zlw
     */
    public function _initialize() {
        parent::_initialize();

        $this->assign('interval_time', $this->interval_time);
    }

    /**
     * 默认方法
     *
     * @create 2016-10-21
     * @author zlw
     */
    public function index() {
        $Game = D('Common/Game');
        //最近活动
        $where['is_open'] = 1;
        $where['is_end'] = 0;
        $where[] = 'start_time <= ' . time();
        $where[] = 'start_time + ((time_length + ' . $this->interval_time . ') * allow_num) >= ' . time();
        $where[] = 'allow_num > use_num';
        $where[] = '999=999';
        $game = $Game->getOne($where, '*, (start_time + ((time_length + ' . $this->interval_time . ') * allow_num)) as start_end_time', 'start_time ASC, id ASC');

        //是否已经结束
        $game_is_over = false;

        //是否为抢购
        $game_is_buy = true;

        //获取下次的抢购时间
        $next_game = array();
        if (empty($game)) {
            $next_where['is_open'] = 1;
            $next_where['is_end'] = 0;
            $next_where[] = 'start_time >= ' . time();
            $next_where[] = 'allow_num > use_num';
            $next_where[] = '888=888';
            $next_game = $Game->getOne($next_where, '*', 'start_time ASC, id ASC');

            $game_is_buy = false;
        }

        //没有活动后
        if (empty($next_game) && empty($game)) {
            unset($where);
            $where['is_open'] = 1;
            $where['start_time'][] = array('lt', time());
            $game = $Game->getOne($where, '*', 'start_time DESC, id ASC');

            $game_is_over = true;
        }

        if (empty($game)) {
            $game = $next_game;
        }

        if ($game_is_buy == true) {
            $buy = $this->get_start_time($game);
            $start_time = $buy['start_time'];
            $game['use_num'] = $buy['count'];
        } else {
            $start_time = $game['start_time'];
        }

        $this->assign('game', $game);

        //判断是否为中奖但未购买用户
        $is_fqgm = 0;
        $is_buy = 0;
        $sytime = 0;
        $customer_id = $this->get_customer_id();
        $Model = new \Think\Model();
        $game_prize = $Model->query("SELECT * FROM xk_game_prize WHERE game_id='" . $game['id'] . "' and  customer_id='" . $customer_id . "' and is_buy<=0  and 33=33 order by create_time limit 1");
        if (!empty($game_prize)) {
            if ($game_prize[0]['is_buy'] == -1) {
                $is_fqgm = 1;
                $sytime = 60;
            } else {
                $sytime = time() - $game_prize[0]['time'];
                if ($sytime >= 60)
                    $is_fqgm = 1;
                else
                    $is_fqgm = 2;
            }
        }
        $this->assign('is_fqgm', $is_fqgm);

        if ($game['use_num'] == $game['allow_num']) {
            if ($game_prize[0]['customer_id'] <> $customer_id) {
                $game_is_over = true;
            } else {
                if ($sytime >= 60 || $is_fqgm == 1) {
                    $game_is_over = true;
                    $this->assign('jxgmdjs', 0);
                } else {
                    $game_is_over = false;
                    $this->assign('jxgmdjs', 60 - $sytime);
                }
            }
        } else {
            if ($sytime >= 60 || $is_fqgm == 1) {
                $this->assign('jxgmdjs', 0);
            } else {
                $this->assign('jxgmdjs', 60 - $sytime);
            }
        }

        //抢房时间
        if ($game_is_over === true) {
            $start_time = time() - 60 * 60;
        } else {
            $start_time = $start_time;
        }
        $this->assign('start_time', $start_time);

        //显示的抢房时间
        $show_start_time = $start_time;
        $this->assign('show_start_time', $show_start_time);

        //抢房截止时间
        if ($game_is_over === true) {
            $run_start_time = time() - 60 * 60;
        } else {
            $run_start_time = $start_time + $game['time_length'];
        }
        $this->assign('run_start_time', $run_start_time);

        //抢房须知
        $tip = $game['content'];
        $this->assign('tip', $tip);

        //获取房间信息
        $room_id = $game['room_id'];
        $room = D('Common/Roomview')->getOneById($room_id);
        $this->assign('room', $room);

        $this->set_seo_title('抢购活动');
        $this->display();
    }

    /**
     * 更改循环次数
     *
     * @create 2016-11-1
     * @author zlw
     */
    protected function get_start_time($time_game = '') {
        if (empty($time_game)) {
            return array(
                'id' => 0,
                'start_time' => time(),
                'count' => 0,
            );
        }

        $time_now_time = time();

        $time_start_time = $time_game['start_time'];
        $time_use_count = floor(($time_now_time - $time_start_time) / ($time_game['time_length'] + $this->interval_time));

        $time_will_time = $time_game['start_time'] + ($time_game['time_length'] + $this->interval_time) * $time_use_count;
        $time_will_count = $time_use_count;
        $time_will_id = 0;

        $time_remainder = ($time_now_time - $time_start_time) % ($time_game['time_length'] + $this->interval_time);

        if (time() > $time_will_time + $time_game['time_length'] && time() < $time_will_time + $time_game['time_length'] + $this->interval_time
        ) {
            $time_will_time = $time_will_time + $time_game['time_length'] + $this->interval_time;
        }

        if ($time_game['start_time'] <= time() && (($time_game['start_time'] + ($time_game['time_length'] + $this->interval_time) * $time_game['allow_num']) >= time())
        ) {
            $time_will_id = $time_game['id'];

            $time_will_data['use_num'] = $time_will_count + 1;
            $time_will_count = $time_will_count + 1;
            $time_will_data['next_start_time'] = $time_will_time;

            D('Common/Game')->editOneById($time_will_id, $time_will_data);
        }

        return array(
            'id' => $time_will_id,
            'start_time' => $time_will_time,
            'count' => $time_will_count,
        );
    }

    /**
     * 点击抢购
     *
     * @create 2016-10-25
     * @author zlw
     */
    public function click() {
        if (!IS_AJAX) {
            $this->error('提交失败，请重试！', U('index'));
        }

        $game_id = I("id", 0, 'intval');
        if ($game_id == 0) {
            $this->error('活动ID不能为空，请确认后重试！', U('index'));
        }

        $Game = D('Common/Game');

        $where['id'] = $game_id;
        $where['is_open'] = 1;
        $where['is_end'] = 0;
        $where[] = 'start_time <= ' . time();
        $where[] = 'start_time + ((time_length + ' . $this->interval_time . ') * allow_num) >= ' . time();
        $where[] = 'allow_num > use_num';
        $game = $Game->getOne($where, '*', 'start_time ASC, id ASC');
        if (empty($game)) {
            $this->error('活动已经结束！', U('index'));
        }

        $customer_id = $this->get_customer_id();

        $data['game_id'] = $game_id;
        $data['customer_id'] = $customer_id;

        $status = $Game->addStatistics($data);
        if ($status === false) {
            $this->error('抢购失败，请确认后重试！', U('index'));
        }

        $this->success('抢购成功！', U('index'));
    }

    /**
     * 获取中奖信息
     *
     * @create 2016-10-26
     * @author zlw
     */
    public function get_prize() {
        //$datauuu['ttt']=1;
        //$model = M("test");  
        //$model->add($datauuu);

        if (!IS_AJAX) {
            $this->error('提交失败，请重试！', U('index'));
        }

        $game_id = I("id", 0, 'intval');
        if ($game_id == 0) {
            $this->error('活动ID不能为空，请确认后重试！', U('index'));
        }

        $Game = D('Common/Game');

        //活动信息
        $where['id'] = $game_id;
        $where['is_open'] = 1;
        $game = $Game->getOne($where, '*', 'start_time ASC, id ASC');
        if (empty($game)) {
            $this->error('活动信息不存在，请确认后重试！', U('index'));
        }

        if ($game['allow_num'] <= $game['use_num']) {
            $this->error('活动已结束！', U('index'));
        }

        //当前用户
        $customer_id = $this->get_customer_id();

        $game_prize_where['game_id'] = $game_id;
        $game_prize_where['is_buy'] = 1;
        $game_prize = D('Common/GamePrize')->getOne($game_prize_where);

        /** 没有购买信息 */
        if (empty($game_prize)) {
            /*
              $user_game_prize_where['game_id'] = $game_id;
              $user_game_prize_where['customer_id'] = $customer_id;
              $user_game_prize_where['is_buy'] = 0;
              $user_game_prize = D('Common/GamePrize')->getOne($user_game_prize_where);
             */

            $Model = new \Think\Model();
            $user_game_prize = $Model->query("SELECT * FROM xk_game_prize WHERE game_id='" . $game_id . "'  and is_buy<=0  and 55=55 order by create_time desc");

            $cstidlist = array();
            //排除用户已放弃本次购买权(已中奖且取消购买)
            if (!empty($user_game_prize)) {
                //$statistics_where['customer_id'] = array('not in', array($customer_id));

                foreach ($user_game_prize as $user_game_prizes_value) {
                    $cstidlist[] = $user_game_prizes_value['customer_id'];
                }
                $statistics_where['customer_id'] = array('not in', $cstidlist);

                /* if ($user_game_prize[0]['create_time'] + $this->interval_time < time()) {
                  $this->error('抢购还没开始，请稍后！', U('index'));
                  } */
            }
            //抢房信息
            $statistics_where['game_id'] = $game_id;
            $statistics_where[] = '444=444';
            //$statistics = $Game->getStatisticsList($statistics_where, '*', 'rand()'); 
            $statistics = $Game->getStatisticsList($statistics_where, '*', 'click desc', 1);

            $statistics_arr = array();
            if (empty($statistics)) {
                $statistics = array();
            }
            foreach ($statistics as $statistics_value) {
                $statistics_arr[] = array(
                    'customer_id' => $statistics_value['customer_id'],
                    'v' => $statistics_value['click'],
                );
            }
            if (empty($statistics)) {
                $this->error('很遗憾，你没有抢购成功！', U('index'));
            }
            $prize = Lottery::roll($statistics_arr);

            //当前奖项
            $now_prize = $prize['yes'];

            //没有数据
            if (empty($now_prize)) {
                $this->error('很遗憾，你没有抢购成功！', U('index'));
            }

            $Customer = D('Common/Customer');
            $user_info = $Customer->getOneById($now_prize['customer_id']);

            //添加中奖信息
            $data['game_id'] = $game_id;
            $data['customer_id'] = $user_info['id'];
            $data['wx_openid'] = $user_info['openid'];
            $data['room_id'] = $game['room_id'];
            $data['time'] = time();
            $data['code'] = Stringer::randString(6);
            $data['is_buy'] = 0;
            $data['is_delete'] = 0;
            $check_has_add = D('Common/GamePrize')->addOne($data);
            if ($check_has_add === false) {
                $this->error('很遗憾，你没有抢购成功！', U('index'));
            }

            //更改下次的抢购时间
            $next_where['id'] = $game_id;
            $next_data['next_start_time'] = $game['start_time'] + ($game['time_length'] + $this->interval_time) * $game['use_num'];
            $next_data['use_num'] = $game['use_num'] + 1;
            $next_check_edit = $Game->editOne($next_where, $next_data);

            $prize_customer_id = $now_prize['customer_id'];
        } else {
            $prize_customer_id = $game_prize['customer_id'];
        }

        if ($customer_id == $prize_customer_id) {
            $this->success('恭喜你，抢购成功！', U('index'));
        }

        $this->error('很遗憾，你没有抢购成功！', U('index'));
    }

    /**
     * 取消购买
     *
     * @create 2016-11-28
     * @author jxw
     */
    public function qx_buy() {
        if (!IS_AJAX) {
            $this->error('提交失败，请重试！', U('index'));
        }
        $game_id = I("id", 0, 'intval');
        //当前用户
        $customer_id = $this->get_customer_id();
        $data['is_buy'] = -1;

        $model = M("game_prize");
        $model->where('customer_id=' . $customer_id . ' and game_id=' . $game_id)->save($data);
        $this->success('取消购买成功', U('index'));
    }

    /**
     * 选择抢购房间
     *
     * @create 2016-10-26
     * @author zlw
     */
    public function buy_room() {
        if (!IS_AJAX) {
            $this->error('提交失败，请重试！', U('index'));
        }

        $game_id = I("id", 0, 'intval');
        if ($game_id == 0) {
            $this->error('活动ID不能为空，请确认后重试！', U('index'));
        }

        $phone = I("phone", '', 'trim');
        if (empty($phone)) {
            $this->error('电话不能为空，请确认后重试！', U('index'));
        }

        if (!is_phone_number($phone)) {
            $this->error('电话号码错误，请确认后重试！', U('index'));
        }

        $Game = D('Common/Game');
        $GamePrize = D('Common/GamePrize');

        //活动信息
        $where['id'] = $game_id;
        $where['is_open'] = 1;
        $where['is_end'] = 0;
        $game = $Game->getOne($where, '*', 'start_time ASC, id ASC');
        if (empty($game)) {
            $this->error('活动信息不存在，请确认后重试！', U('index'));
        }

        /* if ($game['allow_num'] < $game['use_num'] + 1 && ) {
          $this->error('活动已结束！', U('index'));
          } */

        //抢购信息
        $game_prize_where['game_id'] = $game_id;
        $game_prize_where['is_buy'] = 1;
        $game_prize = $GamePrize->getOne($game_prize_where);
        if (!empty($game_prize)) {
            $this->error('房间已经售出，请选择其他房间！', U('index'));
        }

        //当前用户
        $customer_id = $this->get_customer_id();

        //获取最新的抢购数据
        $user_game_prize_where['game_id'] = $game_id;
        $user_game_prize_where['customer_id'] = $customer_id;
        $user_game_prize_where['is_buy'] = 0;

        $user_game_prize_count = $GamePrize->where($user_game_prize_where)->count();
        if ($user_game_prize_count > 1) {
            $this->error('你没有中奖记录，不能购买！', U('index'));
        }

        $user_game_prize = $GamePrize->getOne($user_game_prize_where, 'id', 'id DESC');
        if (empty($user_game_prize)) {
            $this->error('你没有中奖，不能购买！', U('index'));
        }

        //确认购买
        $edit_game_prize_where['id'] = $user_game_prize['id'];
        $edit_game_prize_where['game_id'] = $game_id;
        $edit_game_prize_where['customer_id'] = $customer_id;
        $edit_game_prize_data['is_buy'] = 1;
        $edit_game_prize_data['phone'] = $phone;
        $edit_game_prize_data['buy_time'] = time();
        $check_has_edit = $GamePrize->editOne($edit_game_prize_where, $edit_game_prize_data);

        //结束活动
        $end_where['id'] = $game_id;
        $end_data['is_end'] = 1;
        $Game->editOne($end_where, $end_data);

        if ($check_has_edit === false) {
            $this->error('确认购房失败，请联系线下客服！！', U('index'));
        }

        $this->success('抢购成功，请到销售处办理！验证码为：' . $user_game_prize['code'], U('index'));
    }

    /**
     * 活动列表
     *
     * @create 2016-10-27
     * @author zlw
     */
    public function activities() {
        $Game = D('Common/Game');
        $GamePrize = D('Common/GamePrize');
        //当前用户
        $customer_id = $this->get_customer_id();
        //条件
        $where['is_open'] = 1;
        //活动总数
        $count = $Game->where($where)->count();
        //分页
        $Page = $this->mpage($count, 5);
        $page_show = $Page->show();
        $this->assign('page_show', $page_show);
        //取范围
        $limit = $Page->firstRow . ',' . $Page->listRows;
        //活动列表
        $games = $Game->getList($where, '*', 'start_time DESC, is_end DESC, id DESC', $limit);
        $this->assign('games', $games);

        //获取用户抢购数据
        $user_game_prize_where['customer_id'] = $customer_id;
        $user_game_prize_where['is_buy'] = 1;
        $user_game_prizes = $GamePrize->getListByGroup($user_game_prize_where, '*', 'game_id, is_buy', 'id DESC');

        //抢房信息
        $user_game_statistics_where['customer_id'] = $customer_id;
        $user_game_statistics = $Game->getStatisticsList($user_game_statistics_where, '*', 'id DESC');

        $user_new_game_prizes = array();
        $user_buy_rooms = array();
        foreach ($user_game_prizes as $user_game_prizes_value) {
            $user_new_game_prizes['buy'][$user_game_prizes_value['game_id']] = $user_game_prizes_value;
            $user_buy_rooms[$user_game_prizes_value['room_id']] = $user_game_prizes_value['room_id'];
        }
        foreach ($user_game_statistics as $user_game_statistics_value) {
            $user_new_game_prizes['no_buy'][$user_game_statistics_value['game_id']] = $user_game_statistics_value;
        }
        $this->assign('user_game_prizes', $user_new_game_prizes);

        //当前活动
        $now_where['is_open'] = 1;
        $now_where['is_end'] = 0;
        if (!empty($user_buy_rooms)) {
            $now_where['room_id'] = array('not in', $user_buy_rooms);
        }
        $now_where[] = 'start_time <= ' . time();
        $now_where[] = 'start_time + ((time_length + ' . $this->interval_time . ') * allow_num) >= ' . time();
        $now_where[] = 'allow_num > use_num';
        $now_game = $Game->getOne($now_where, '*', 'start_time ASC, id ASC');
        $this->assign('now_game', $now_game);

        //最近活动
        $will_where['is_open'] = 1;
        $will_where['start_time'][] = array('gt', time());
        if (!empty($user_buy_rooms)) {
            $will_where['room_id'] = array('not in', $user_buy_rooms);
        }
        $will_where[] = 'start_time <= start_time + time_length';
        $will_where[] = 'allow_num > use_num';
        $will_game = $Game->getOne($will_where, '*', 'start_time ASC, id ASC');
        $this->assign('will_game', $will_game);

        $this->set_seo_title('活动列表');
        $this->display();
    }

    /**
     * 活动详情
     *
     * @create 2016-10-28
     * @author zlw
     */
    public function info() {
        $game_id = I("id", 0, 'intval');
        if ($game_id == 0) {
            $this->error('活动ID不能为空，请确认后重试！', U('index'));
        }

        $Game = D('Common/Game');
        $GamePrize = D('Common/GamePrize');

        //最近活动
        $where['is_open'] = 1;
        $where['id'] = $game_id;
        $game = $Game->getOne($where, '*', 'next_start_time ASC, id ASC');
        $this->assign('game', $game);

        //抢房时间
        $start_time = $game['start_time'];
        $this->assign('start_time', $start_time);

        //显示的抢房时间
        $show_start_time = $game['start_time'];
        $this->assign('show_start_time', $show_start_time);

        //抢房结束时间
        $run_start_time = $time_game['start_time'] + ($time_game['time_length'] + $this->interval_time) * $time_game['use_num'];
        $this->assign('run_start_time', $run_start_time);

        //抢房须知
        $tip = $game['content'];
        $this->assign('tip', $tip);

        //获取房间信息
        $room_id = $game['room_id'];
        $room = D('Common/Roomview')->getOneById($room_id);
        $this->assign('room', $room);

        //当前用户
        $customer_id = $this->get_customer_id();
        $this->assign('customer_id', $customer_id);

        //获取用户抢购数据
        $user_game_prize_where['game_id'] = $game_id;
        $user_game_prize_where['is_buy'] = 1;
        $user_game_prizes = $GamePrize->getOneByGroup($user_game_prize_where, '*', 'game_id, is_buy', 'id DESC');
        $this->assign('user_game_prizes', $user_game_prizes);

        $this->set_seo_title('活动详情');
        $this->display();
    }

}
