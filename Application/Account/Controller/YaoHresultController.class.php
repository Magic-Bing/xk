<?php

namespace Account\Controller;

/**
 * 摇号结果记录
 *
 */
class YaoHresultController extends BaseController {

    /**
     * 系统构造函数
     *
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '选房摇号');

        //设置当前方法
        $this->set_current_action('yaoh_result', 'yaoh');
    }

    

    public function index(){

        //项目ID
        if(isset($_POST['project_id'])){
            $search_project_id = I('project_id', 0, 'intval');
            session("selected_project",$search_project_id);
        }else{
            $search_project_id = session("selected_project");
        }
        $search_batch_id = I('batch_id', 0, 'intval');
        $search_word = I('word', '', 'trim');
        $search_status = I('status', 0, 'intval');

        //设置当前搜索
        $search = array(
            'search_project_id' => $search_project_id,
            'search_batch_id' => $search_batch_id,
            'search_word' => $search_word,
            'search_status' => $search_status,
        );
        $this->assign($search);

        //项目
        $Project = D('Common/Project');

        //获取当前项目
        $project_info = $Project->getProjectById($search_project_id);
        $this->assign('project', $project_info);

        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();
        if ($search_project_id != 0) {
            if (!in_array($search_project_id, $user_project_ids)) {
                $this->error("你没有权限访问该项目的信息！");
            }
        }

        //获取项目列表
        $project_where = array();
        //$project_where['status'] = 1;
        if (!empty($user_project_ids)) {
            $project_where['id'] = array('in', $user_project_ids);
        } else {
            $project_where['id'] = '-99999';
        }
        $project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id DESC, id DESC', '50');
        if (!empty($project_old_list)) {
            foreach ($project_old_list as $project_list_key => $project_list_value) {
                $project_list[$project_list_value['id']] = $project_list_value;
            }
        } else {
            $project_list = array();
        }
        $this->assign('project_list', $project_list);

        //批次
        if (!empty($user_batch_ids)) {
            $user_batch_where['id'] = array('in', $user_batch_ids);
        } else {
            $user_batch_where['id'] = '-99999';
        }
        $user_batch_where['proj_id'] = $search_project_id;
        $batch_list = D('Batch')->getList($user_batch_where, '*');
        $this->assign('batch_list', $batch_list);
        $yaohresult = D('Common/YaoHresult');

        //条件
        $where = array();
        if (!empty($search_project_id)) {
            $where['project_id'][] = $search_project_id;
        }else{
            //项目条件
            if (!empty($user_project_ids)) {
                $where['project_id'][] = array('in', $user_project_ids);
            } else {
                $where['project_id'][] = '-99999';
            }
        }


        if (!empty($search_batch_id)) {
            $where['batch_id'][] = $search_batch_id;
        }else {
            //批次条件
            if (!empty($user_batch_ids)) {
                $where['batch_id'][] = array('in', $user_batch_ids);
            } else {
                $where['batch_id'][] = '-99999';
            }
        }
        //状态条件
        if (!empty($search_status)) {
            $where['status'][] = $search_status;
        }
        //搜索查询
        if (!empty($search_word)) {
            $like['customer_name'] = array('like', '%' . $search_word . '%');
            $like['cyjno'] = array('like', '%' . $search_word . '%');
            $like['like_p'] = array('like', '%' . strencode($search_word) . '%');
            $like['like_c'] = array('like', '%' . strencode($search_word) . '%');
            $like['_logic'] = 'or';
            $where['_complex'] = $like;
        }

        //总数
        $count = $yaohresult->join("left join (select id as cid,customer_name,customer_phone,cardno,like_p,like_c,cyjno from xk_choose) ch ON xk_yaohresult.cstid=ch.cid")->where($where)->count();

        //分页
        $Page = $this->bootstrapPage($count, 15);
        $page_show = $Page->show();
        $total_pages = $Page->totalPages;

        //取范围
        $limit = $Page->firstRow . ',' . $Page->listRows;

        $list = $yaohresult->getList(
            $where, '*', 'id asc', $limit
        );
        $p = I('p', '1', 'intval');
        $this->assign('p', $p);
        $this->assign('total_pages', $total_pages);
        $this->assign('count', $count);
        $this->assign('page_show', $page_show);
        $this->assign('list', $list);
       
        $this->set_seo_title("摇号结果");
        $this->display();
    }
    
    
    public function zf()
    {
        if (!IS_AJAX){
            $this->error("提交错误，请稍后重试！");
        }

        $ids = I("ids",0,'intval');

        if(empty($ids))
            $this->error("记录不存在，请确认后重试！");

        $yaohset = D('YaoHresult');
        $data['is_yx']=0;
        $where = [
            'where'=>['id'=>['in',$ids]]
        ];
        $yaohset->save($data,$where);

        $this->success('作废成功');
    }
    
    
    
    /**
     * 数据导出
     *
     */
    public function check_jl(){
        $search_project_id = I('project_id', '0', 'intval');
        $search_batch_id = I('batch_id', '0', 'intval');
        $search_word = I('word', '', 'trim');

        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

         $yaohresult = D('Common/YaoHresult');

        //条件
        $where = array();
        if (!empty($search_project_id)) {
            $where['project_id'][] = $search_project_id;
        }

        //项目条件
        if (!empty($user_project_ids)) {
            $where['project_id'][] = array('in', $user_project_ids);
        } else {
            $where['project_id'][] = '-99999';
        }

        //批次条件
        if (!empty($user_batch_ids)) {
            $where['batch_id'][] = array('in', $user_batch_ids);
        } else {
            $where['batch_id'][] = '-99999';
        }

        //搜索查询
        //搜索查询
        if (!empty($search_word)) {
            $like['customer_name'] = array('like', '%' . $search_word . '%');
            $like['cyjno'] = array('like', '%' . $search_word . '%');
            $like['like_p'] = array('like', '%' . strencode($search_word) . '%');
            $like['like_c'] = array('like', '%' . strencode($search_word) . '%');
            $like['_logic'] = 'or';
            $where['_complex'] = $like;
        }

        $list = $yaohresult->getList(
            $where, "*,case when status=0 then '未入场' else '已入场' end as status1,case when is_yx=1 then '正常' else '已作废' end as is_yx1,FROM_UNIXTIME( createdtime,'%Y-%m-%d  %H:%i') as createdtime1", 'id asc'
        );
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $filename = '摇号记录-'.time().".xls";
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("K")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '序号');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '项目');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '客户姓名');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'VIP编号');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '手机');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '身份证号码');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '分组');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '入场序号');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '入场情况');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '状态');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '生成时间');

        for ($k =0; $k < count($list); $k++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($k+2),$k+1);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($k+2),$list[$k]['project_name']."-".$list[$k]['batch_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($k+2),$list[$k]['customer_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($k+2),$list[$k]['cyjno']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($k+2),rsa_decode($list[$k]['customer_phone'],  getChoosekey()),\PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.($k+2),rsa_decode($list[$k]['cardno'],  getChoosekey()),\PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.($k+2),'第'.$list[$k]['group'].'组');
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.($k+2),$list[$k]['no']);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.($k+2),$list[$k]['status1']);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.($k+2),$list[$k]['is_yx1']);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.($k+2),$list[$k]['createdtime1'],\PHPExcel_Cell_DataType::TYPE_STRING);
              
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//        $objWriter->save($filename);
// 输出Excel表格到浏览器下载
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter->save('php://output');
        exit;

    }

}
