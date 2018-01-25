<?php

namespace Common\Logic;


/**
 * Excel操作
 *
 * @edit 2016-12-19
 * @author zlw
 */
class ExcelLogic
{
	
	/**
	 * 错误信息
	 *
	 * @edit 2016-12-19
	 * @author zlw
	 */
	public $error = '';

	
	/**
	 * 获取Excel数据
	 *
	 * @edit 2016-12-19
	 * @author zlw
	 */
    public function import($filename, $exts = 'xls')
    {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel = new \PHPExcel();
        //如果excel文件后缀名为.xls，导入这个类
        if ($exts == 'xls') {
            import("Org.Util.PHPExcel.Reader.Excel5");
            $PHPReader = new \PHPExcel_Reader_Excel5();
        } elseif ($exts == 'xlsx') {
            import("Org.Util.PHPExcel.Reader.Excel2007");
            $PHPReader = new \PHPExcel_Reader_Excel2007();
        }

        //载入文件
        $PHPExcel = $PHPReader->load($filename);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet = $PHPExcel->getSheet(0);
        //获取总列数
        $allColumn = $currentSheet->getHighestColumn();
        //获取总行数
        $allRow = $currentSheet->getHighestRow();
        
        if (empty($allRow)) {
			$this->error = '文件内容为空';
			return false;
        }
		
        // 循环获取表中的数据，
		// $currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        $data = array();
        for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
            //从哪列开始，A表示第一列
            for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                //数据坐标
                $address = $currentColumn.$currentRow;
				
                //读取到的数据，保存到数组$arr中
                $data[$currentRow][$currentColumn] = $currentSheet->getCell($address)->getValue();
            }
        }
		
		return $data;
	}
	
   
	/**
	 * 导出表格
	 *
	 * @create 2016-12-19
	 * @author zlw
	 */
    public function export(
		$fileName, 
		$headArr, 
		$data = array(),
		$excelInfo = array(),
		$excelType = 'Excel5'
	) {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
		$objProps = $objPHPExcel->getProperties();

		//激活表格
        $objActSheet = $objPHPExcel->getActiveSheet();
       
        //设置表头
        $headColumn = 1;
//        $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
        $objActSheet->getStyle('A1:I1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00dc93d5');
        $objActSheet->mergeCells("H1:I1");
        foreach ($headArr as $headKey => $headRows) { //行写入
            $headSpan = ord("A");
            foreach ($headRows as $headKeyName => $headValue) {// 列写入
                $headJ = chr($headSpan);
				
				$styleArray = array();
                $objActSheet->getStyle($headJ)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				if (is_array($headValue)) {
					if (isset($headValue['_bg'])) {
						if (true !== $headValue['_bg']) {
							$bgColor = $headValue['_bg'];
						} else {
							$bgColor = '00dc93d5';
						}
						
						$objActSheet->getStyle($headJ.$headColumn)
							->getFill()
							->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
							->getStartColor()
							->setARGB($bgColor);
						
						unset($headValue['_bg']);
					}
                    if (isset($headValue['_wd'])) {
                        $objActSheet->getColumnDimension($headJ)->setWidth($headValue['_wd']);
                        unset($headValue['_wd']);
                    }
					
					if (isset($headValue['_bold'])) {
						$styleArray = array(
							'font'    => array (
								'bold'      => true,
							),
							'borders' => array (
								'top'     => array (
									'style' => \PHPExcel_Style_Border::BORDER_THIN
								)
							),
						);
						
						unset($headValue['_bold']);
					}
					
					if (isset($headValue['_fill'])) {
						$styleArray['fill'] = array (
							'type'       => \PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR ,
							'rotation'   => 90,
							'startcolor' => array (
								'argb' => 'FFA0A0A0'
							),
							'endcolor'   => array (
								'argb' => 'FFFFFFFF'
							),
						);
						
						unset($headValue['_fill']);
					}
					
					if (isset($headValue['_style'])) {
						$styleArray = array_merge($styleArray, $headValue['_style']);
						
						unset($headValue['_style']);
					}
					
					if (!empty($styleArray)) {
						$objActSheet->getStyle($headJ.$headColumn)->applyFromArray($styleArray);
					}
					
					$headValue = $headValue[0];
				}
				
                $objActSheet->setCellValue($headJ.$headColumn, $headValue);
                $headSpan++;
				
            }
            $headColumn++;
        }
		
		//重新赋值
        $column = $headColumn;

		//写入数据表格
		if (!empty($data)) {
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
		}

		//转换文字编码
		$fileNameEncode = mb_detect_encoding($fileName, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5')); 
		if (strtoupper($fileNameEncode) != 'UTF-8') {
			$fileNameTitle = mb_convert_encoding($fileName, $fileNameEncode, "utf-8");
			$fileName = iconv($fileNameEncode, "utf-8", $fileName);
		}

        //重命名表
        $objPHPExcel->getActiveSheet()->setTitle($fileName);
		
		if (isset($excelInfo['creator'])) {
			$creator = $excelInfo['creator'];
		} else {
			$creator = 'excel';
		}
		if (isset($excelInfo['lastModifiedBy'])) {
			$lastModifiedBy = $excelInfo['lastModifiedBy'];
		} else {
			$lastModifiedBy = 'excel';
		}
		if (isset($excelInfo['title'])) {
			$title = $excelInfo['title'];
		} else {
			$title = 'excel title';
		}
		if (isset($excelInfo['subject'])) {
			$subject = $excelInfo['subject'];
		} else {
			$subject = 'excel subject';
		}
		if (isset($excelInfo['description'])) {
			$description = $excelInfo['description'];
		} else {
			$description = 'excel description';
		}
		if (isset($excelInfo['keywords'])) {
			$keywords = $excelInfo['keywords'];
		} else {
			$keywords = 'excel keywords';
		}
		if (isset($excelInfo['category'])) {
			$category = $excelInfo['category'];
		} else {
			$category = 'excel category';
		}
		 
        $objProps->setCreator($creator)  
            ->setLastModifiedBy($lastModifiedBy)  
            ->setTitle($title)  
            ->setSubject($subject)  
            ->setDescription($description)  
            ->setKeywords($keywords)  
            ->setCategory($category);  
		
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
		
		if (strtolower($excelType) == 'excel2007') {
			$excelExt = '.xlsx';
		} else {
			$excelExt = '.xls';
		}
		
		//导出文件名
		if (!isset($excelInfo['outputFileName'])) {
			$date = date("YmdHis", time());
			$outputFileName = $fileName . "-{$date}";
			$outputFileName .= $excelExt;
		} else {
			$outputFileName = $excelInfo['outputFileName'];
		}

		//转换文字编码
        $outputFileName = iconv("utf-8", "gb2312", $outputFileName);
		
		$ua = $_SERVER['HTTP_USER_AGENT'];  
		if (preg_match('/MSIE/',$ua)) {  
			$outputFileName = str_replace('+', '%20', urlencode($outputFileName));
		}		
		
		//输出
		ob_clean();
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$outputFileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, $excelType);
        $objWriter->save('php://output'); //文件通过浏览器下载
    }
}
