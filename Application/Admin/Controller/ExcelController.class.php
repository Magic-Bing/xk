<?php

namespace Admin\Controller;


/**
 * 表格管理
 *
 * @create 2016-10-9
 * @author zlw
 */
class ExcelController extends BaseController 
{
    

	/**
	 * 导出数据
	 *
	 * @create 2016-10-9
	 * @author zlw
	 */
	public function export()
    {
		$project_id = I("projid", '', 'intval');
		if (empty($project_id) || $project_id == 0) {
			$this->error('项目不存在，请重试！');
		}
		
		//房间信息
		$rooms_list = array(
			array(
				'buildname' => '10栋',
				'unit' => '55',
				'floor' => '12',
				'no' => (string) '01',
				'hx' => 'A2',
				'area' => '90',
				'tnarea' => '80',
				'price' => '8000',
				'tnprice' => '10500',
				'total' => '810000',
			),
			array(
				'buildname' => '6栋',
				'unit' => '55',
				'floor' => '11',
				'no' => '02',
				'hx' => 'A1',
				'area' => '90',
				'tnarea' => '80',
				'price' => '8100',
				'tnprice' => '11500',
				'total' => '910000',
			),
		);
		
		//格式化数据
        $data = array();
        foreach ($rooms_list as $k => $rooms_info) {
            $data[$k]['buildname'] 	= $rooms_info['buildname'];
            $data[$k]['unit'] 		= $rooms_info['unit'];
            $data[$k]['floor'] 		= $rooms_info['floor'];
            $data[$k]['no'] 		= $rooms_info['no']." ";
            $data[$k]['hx']  		= $rooms_info['hx'];
            $data[$k]['area']  		= $rooms_info['area'];
            $data[$k]['tnarea']  	= $rooms_info['tnarea'];
            $data[$k]['price'] 		= $rooms_info['price'];
            $data[$k]['tnprice'] 	= $rooms_info['tnprice'];
            $data[$k]['total'] 		= $rooms_info['total'];
        }
		
		//获取项目信息
		$project = D('Common/Project')->getOneById($project_id);

		$headArr = array(
			'title' => array(
				array('项目标识', '_type' => true),
				$project_id,
				'',
				array('项目名称', '_type' => true),
				$project['name']
			),
			'head'  => array(
				'楼栋',
				'单元',
				'楼层',
				'房号',
				'户型',
				'建筑面积',
				'套内面积',
				'建筑单价',
				'套内单价',
				'标准总价',
			),
		);
		
        $filename = $project['name']."房间列表";

        $this->exportExcel($filename, $headArr, $data);
    }
   
   
	/**
	 * 导出表格
	 *
	 * @create 2016-10-9
	 * @author zlw
	 */
    private function exportExcel(
		$fileName, 
		$headArr, 
		$data
	) {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        $date = date("YmdHis",time());
        $fileName .= "_{$date}.xls";

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
		$objProps = $objPHPExcel->getProperties();

		//激活表格
        $objActSheet = $objPHPExcel->getActiveSheet();

        //设置表头
        $headColumn = 1;
        foreach ($headArr as $headKey => $headRows) { //行写入
            $headSpan = ord("A");
            foreach ($headRows as $headKeyName => $headValue) {// 列写入
                $headJ = chr($headSpan);
				
				if (is_array($headValue)) {
					if (isset($headValue['_type'])) {
						$objActSheet->getStyle($headJ.$headColumn)
							->getFill()
							->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
							->getStartColor()
							->setRGB('EBE7DC');
					
						$objActSheet->getStyle($headJ.$headColumn)->applyFromArray(
							array(
								'font'    => array (
									'bold'      => true,
								),
								'borders' => array (
									'top'     => array (
										'style' => \PHPExcel_Style_Border::BORDER_THIN
									)
								),
							)
						);
						
						unset($headValue['_type']);
					} 
					
					$headValue = $headValue[0];
				}
				
				if ($headKey == 'head') {
					$objActSheet->getStyle($headJ.$headColumn)->applyFromArray(
						array(
							'font'    => array (
								'bold'      => true,
							),
							'borders' => array (
								'top'     => array (
									'style' => \PHPExcel_Style_Border::BORDER_THIN
								)
							),
							'fill' => array (
								'type'       => \PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR ,
								'rotation'   => 90,
								'startcolor' => array (
									'argb' => 'FFA0A0A0'
								),
								'endcolor'   => array (
									'argb' => 'FFFFFFFF'
								)
							)
						)
					);
					
					$objActSheet->getStyle($headJ.$headColumn)
						->getFill()
						->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setRGB('EBE7DC');
				}
				
                $objActSheet->setCellValue($headJ.$headColumn, $headValue);
                $headSpan++;
				
            }
            $headColumn++;
        }
		
		//重新赋值
        $column = $headColumn;

		//写入数据表格
        foreach ($data as $key => $rows) { //行写入
            $span = ord("A");
            foreach ($rows as $keyName => $value) {// 列写入
                $j = chr($span);
				
				if (is_string($value)) {
					$objActSheet->setCellValue($j.$column, $value, \PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle($j.$column)->getNumberFormat()->setFormatCode("@");
				} else {
					$objActSheet->setCellValue($j.$column, $value);
				}
                $span++;
            }
            $column++;
        }

        $fileName = iconv("utf-8", "gb2312", $fileName);
		
        //重命名表
        $objPHPExcel->getActiveSheet()->setTitle('项目填写模板');
		
        $objProps->setCreator("xk")  
            ->setLastModifiedBy("xk")  
            ->setTitle("googs_list")  
            ->setSubject("googs_list Subject")  
            ->setDescription("googs_list Description")  
            ->setKeywords("googs_list Keywords")  
            ->setCategory("googs_list Category");  
		
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
		
		//输出
		ob_clean();
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
    }
	
}

