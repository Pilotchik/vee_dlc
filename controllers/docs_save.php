<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Docs_save extends CI_Controller {

	function _remap($method)
	{
		$guest = $this->session->userdata('guest');
		if (($guest == '') || ($guest < 2))
		{
			redirect('/', 'refresh');
		} 
		else
		{
			$this->load->helper('functions');
			$this->$method();
		}
	}
	
	public function save_function(){

        $nabor2 = $_SESSION['nabor2'];
	  	$result = $_SESSION['result'];
		$naborV = $_SESSION['naborV'];
		$poleV = $_SESSION['poleV'];  
         
		$alf = array ('A', 'E', 'I', 'O', 'U', 'B', 'C', 'D', 'F', 
		'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'V', 'W', 'X', 'Y', 'Z');

		
		////////////////////////////////////////////////////////////////
		$styleZ = array(
			'borders' => array(
			  'outline' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				
			  ),
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb'=>'B0C4DE'),
			),
			'font' => array(
			  'bold' => true,
			  'size' => 12,
			),
			'alignment' => array(
			  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		  );
		$styleT = array( 'borders' => array(
			  'outline' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN,
				
			  ),),
			  
			 'alignment' => array(
			  'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			  'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
		  );
		////////////////Стили форматирования////////////////////////////////////

		$phpExcel = new PHPExcel();

		$phpExcel->getProperties()->setCreator("user")
			->setLastModifiedBy("username")
			->setTitle("Title")
			->setSubject("Название.")
			->setDescription("Описание")
			->setKeywords("php, all results")
			->setCategory("some category");

		$page = $phpExcel->setActiveSheetIndex(0);
    if (!empty($naborV[0])){$i = 0;$j = 5; 
	foreach ($naborV as $key){
		$phpExcel->getActiveSheet()->setCellValueByColumnAndRow($i, 1, $key);
		$phpExcel->getActiveSheet()->getStyleByColumnAndRow($i, 1)->applyFromArray($styleZ);
		$i++;
	} 
	$i = 0; 
	foreach ($poleV as $key){
		$phpExcel->getActiveSheet()->setCellValueByColumnAndRow($i, 2, $key);
		$phpExcel->getActiveSheet()->getStyleByColumnAndRow($i, 2)->applyFromArray($styleT);
		$i++;
	} 
	$i = 0; 
	foreach ($nabor2 as $key){
		$phpExcel->getActiveSheet()->setCellValueByColumnAndRow($i, 4, $key);
		$phpExcel->getActiveSheet()->getStyleByColumnAndRow($i, 4)->applyFromArray($styleZ);
		$i++;
	} 
	foreach ($result as $item){
	$i = 0; 
		foreach($item as $it){
			$phpExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $j, $it);
			$phpExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->applyFromArray($styleT);
			$i++;
		}
	$j++;
	} 
    }
    else{
        	$i = 0; $j = 2;
	foreach ($nabor2 as $key){
		$phpExcel->getActiveSheet()->setCellValueByColumnAndRow($i, 1, $key);
		$phpExcel->getActiveSheet()->getStyleByColumnAndRow($i, 1)->applyFromArray($styleZ);
		$i++;
	} 
	foreach ($result as $item){
	$i = 0; 
		foreach($item as $it){
			$phpExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $j, $it);
			$phpExcel->getActiveSheet()->getStyleByColumnAndRow($i, $j)->applyFromArray($styleT);
			$i++;
		}
	$j++;
	} 
    }
	//ВСТАВКА СОДЕРЖИМОГО ТАБЛИЦЫ
	foreach($alf as $A){
	$phpExcel->getActiveSheet()->getColumnDimension($A)->setAutoSize(true);
	}
	////////////////////////////////////////
	$phpExcel->getActiveSheet()->setTitle('Otchet'.time());
	$phpExcel->setActiveSheetIndex(0);
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="01simple.xls"');
        header('Cache-Control: max-age=0');
        
        header('Cache-Control: max-age=1');
        
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); 
        header ('Cache-Control: cache, must-revalidate'); 
        header ('Pragma: public');
		
    $filename= 'myresults-'.time().'.xlsx';
  
	$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
	
	$objWriter->save('php://output'); 
	echo "Отчет сохранен";
	header('Location: otchetska.ru/Construct');
    }      
}