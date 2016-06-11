<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start(); 
	
class Docs_construct extends CI_Controller {
	
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


	public function index(){
		
		if (empty($_REQUEST['phpAllPoleOtcheta'])){
			$viewData ['withoutcontent'] = 1;
			$viewData ['content'] = 0;
			$this->load->view('docs/main_view',$viewData);
		}
			
		$sortirovka = 0;

		if (!empty($_REQUEST['phpAllPoleOtcheta'])){          
			$nabor = $_REQUEST['phpAllPoleOtcheta'];
		}
		else if(!empty($_SESSION['nabor'])){
			 $nabor = $_SESSION['nabor'];      
		}
		
		if (!empty($_REQUEST['phpAllPoleUslovie'])){   
			$uslovie = $_REQUEST['phpAllPoleUslovie'];
		}
		else if(!empty($_SESSION['uslovie'])){
			$uslovie = $_SESSION['uslovie'];       
		}
			   
		if (!empty($_REQUEST['phpAllZnakUslovie'])){   
			$znak_u = $_REQUEST['phpAllZnakUslovie'];
		}
		else if(!empty($_SESSION['znak_u'])){
			$znak_u = $_SESSION['znak_u'];       
		}      
								
		if (!empty($_REQUEST['phpAllTextUslovie'])){   
			$text_u = $_REQUEST['phpAllTextUslovie'];
		}
		else if(!empty($_SESSION['text_u'])){
			$text_u = $_SESSION['text_u'];       
		}
			   
		if (!empty($_REQUEST['phpAllTypeVichPole'])){   
			$type_v = $_REQUEST['phpAllTypeVichPole'];
		}
		else if(!empty($_SESSION['type_v'])){
			$type_v = $_SESSION['type_v'];       
		}
								
		if (!empty($_REQUEST['phpAllVichPole'])){   
			$pole_v = $_REQUEST['phpAllVichPole'];
		}
		else if(!empty($_SESSION['pole_v'])){
			$pole_v = $_SESSION['pole_v'];       
		}
			  
		if (!empty($_REQUEST['phpAllZnakVichPole'])){   
			$znak_v = $_REQUEST['phpAllZnakVichPole'];
		}
		else if(!empty($_SESSION['znak_v'])){
			$znak_v = $_SESSION['znak_v'];       
		}
			
		if (!empty($_REQUEST['phpAllTextVichPole'])){   
			$text_v = $_REQUEST['phpAllTextVichPole'];
		}
		else if(!empty($_SESSION['text_v'])){
			$text_v = $_SESSION['text_v'];       
		}    
	 
	  /*    if (!empty($_REQUEST['phpAllTypeDiagramm'])){   
		$type_d = $_REQUEST['phpAllTypeDiagramm'];}//$vpolat 
		else if(!empty($_SESSION['type_d'])){
				$type_d = $_SESSION['type_d'];       
		}  */
	 
		if (!empty($_REQUEST['phpAllPoleDiagramm'])){   
			$pole_d = $_REQUEST['phpAllPoleDiagramm'];
		}
		else if(!empty($_SESSION['pole_d'])){
			$pole_d = $_SESSION['pole_d'];       
		}     
			
		if (!empty($_REQUEST['phpAllTypeRaschetDiagramm'])){   
			$type_raschet_d = $_REQUEST['phpAllTypeRaschetDiagramm'];
		}
		else if(!empty($_SESSION['type_raschet_d'])){
			$type_raschet_d = $_SESSION['type_raschet_d'];       
		}  
			   
		if (isset($_REQUEST['annul'])){            
			$annul = $_REQUEST['annul'];
		}        
		else if (!empty($_SESSION['annul'])){ 
			$annul = $_SESSION['annul'];
		}     
		else{
			$annul = 0;
		}
					   
		if (isset($_REQUEST['deleted'])){   
			$deleted = $_REQUEST['deleted'];
		}
		else if (!empty($_SESSION['deleted'])){
			$deleted = $_SESSION['deleted']; 
		}
		else{
			$deleted = 0;
		}

		if (!empty($_REQUEST['sortirovka'])){             
			$sortirovka = $_REQUEST['sortirovka'];     
		}
		else if(!empty($_SESSION['sortirovka'])){
			if (empty($_REQUEST['phpAllPoleOtcheta'])){
				$sortirovka = $_SESSION['sortirovka'];
			}      
		} 

		$this->load->model('docs_model','Db');

		if ($annul == 1 AND $deleted == 1){
			if (isset($nabor)){
				$result = $this->Db->select($nabor, $uslovie, $znak_u, $text_u,$sortirovka,1,1);    
			}
		}
		else if($annul == 1){
			if (isset($nabor)){
				$result = $this->Db->select($nabor, $uslovie, $znak_u, $text_u,$sortirovka,1,1); 
			}
		}
		else if($deleted == 1){
			if (isset($nabor)){
				$result = $this->Db->select($nabor, $uslovie, $znak_u, $text_u,$sortirovka,0,1);  
			}
		}
		else{ 
			if(isset($nabor)){
				$result = $this->Db->select($nabor, $uslovie, $znak_u, $text_u,$sortirovka);
			}
		}
	 
		if (isset($result)){
			if (is_string($result)){ 
				echo "<script>alert('$result')</script>";; 
			}
			else{
				if (isset($nabor)){
				  
					$_SESSION['nabor'] = $nabor;
					$_SESSION['result'] = $result;
				 
					$_SESSION['uslovie'] = $uslovie;
					$_SESSION['znak_u'] = $znak_u;
					$_SESSION['text_u'] = $text_u;
								 
					$_SESSION['type_v'] = $type_v;
					$_SESSION['pole_v'] = $pole_v;
					$_SESSION['znak_v'] = $znak_v;
					$_SESSION['text_v'] = $text_v;
				  
					$_SESSION['pole_d'] = $pole_d;
					$_SESSION['type_raschet_d']  = $type_raschet_d;
					$_SESSION['deleted'] = $deleted;
					$_SESSION['annul'] = $annul;  
					$_SESSION['sortirovka'] = $sortirovka;
			  //   $_SESSION['type_d'] = $type_d;
					
			   /*  if(isset($_REQUEST['phpAllPoleDiagrammO'])){
				  $_SESSION['pole_do'] = $_REQUEST['phpAllPoleDiagrammO'];
				  
				  }
				  else{$_SESSION['pole_do']= 0;
				   
				  }
				  if(isset($_REQUEST['phpAllPoleDiagrammO2'])){
				  $_SESSION['pole_do2'] = $_REQUEST['phpAllPoleDiagrammO2'];
				   }
				   else{$_SESSION['pole_do2']=0;}*/

					$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
					$limitedResult = $this->Db->limitedSelect($start,30);
					$pageNav = new SimPageNav();
					$_SESSION['limitedResult'] = $limitedResult;
					$page = $pageNav->getLinks( count($result), 30, $start, 9, 'start' );  
					$_SESSION['page'] = $page;                    
					$nabor = array_unique($nabor);
	   
					$viewData ['withoutcontent'] = 0;
					$viewData ['content'] = 1;
					$viewData ['page'] = $page;
					$this->load->view('docs/main_view',$viewData);
				  
				}
			}
		}
	}  
}

class SimPageNav
{
	protected $id;
	protected $startChar;
	protected $prevChar;
	protected $nextChar;
	protected $endChar;
   
	public function __construct( /*string*/ $id     = 'pagination', 
								 /*string*/ $startChar = '&laquo;', 
								 /*string*/ $prevChar  = '&lsaquo;', 
								 /*string*/ $nextChar  = '&rsaquo;', 
								 /*string*/ $endChar   = '&raquo;'  )
	{
	  $this->id = $id;
	  $this->startChar = $startChar;
	  $this->prevChar  = $prevChar;
	  $this->nextChar  = $nextChar;
	  $this->endChar   = $endChar;
	}   
	 

	public function getLinks( /*int*/ $all, /*int*/ $limit, /*int*/ $start, $linkLimit = 10, $varName = 'start' )
	{
  
	  if ( $limit >= $all || $limit == 0 ) {
		return NULL;
	  }     
		 
	  $pages     = 0;       // кол-во страниц в пагинации
	  $needChunk = 0;       // индекс нужного в данный момент чанка
	  $queryVars = array(); // ассоц. массив полученный из строки запроса
	  $pagesArr  = array(); // пременная для промежуточного хранения массива навигации
	  $htmlOut   = '';      // HTML - код постраничной навигации
	  $link      = NULL;    // формируемая ссылка
	   
	 
	  parse_str($_SERVER['QUERY_STRING'], $queryVars ); 
	   
  
	  if( isset($queryVars[$varName]) ) {
		unset( $queryVars[$varName] );
	  }
	   

	  $link  = $_SERVER['PHP_SELF'].'?'.http_build_query( $queryVars );
 
	  
	   
	  $pages = ceil( $all / $limit ); // кол-во страниц
	   
	 
	  for( $i = 0; $i < $pages; $i++) {
		  $pagesArr[$i+1] = $i * $limit;
	  }
	   
	
	  $allPages = array_chunk($pagesArr, $linkLimit, true);
	   
	  
	  $needChunk = $this->searchPage( $allPages, $start );
	   
	  
	   
	  if ( $start > 1 ) {
		$htmlOut .= '<li ><a href="'.$link.'&'.$varName.'=0">'.$this->startChar.'</a></li>'.
					'<li><a href="'.$link.'&'.$varName.'='.($start - $limit).'">'.$this->prevChar.'</a></li>';   
	  } else {
		$htmlOut .= '<li><span>'.$this->startChar.'</span></li>'.
					'<li><span>'.$this->prevChar.'</span></li>'; 
	  }
   
	  foreach( $allPages[$needChunk] AS $pageNum => $ofset )  {
	 
		if( $ofset == $start  ) {
			$htmlOut .= '<li class = active ><span>'. $pageNum .'</span></li>';            
			continue;
		}        
		$htmlOut .= '<li><a href="'.$link.'&'.$varName.'='. $ofset .'">'. $pageNum . '</a></li>';
	  }
		 
	 
		 
	  if ( ($all - $limit) >  $start) {
		$htmlOut .= '<li  ><a href="' . $link . '&' . $varName . '=' . ( $start + $limit) . '">' . $this->nextChar . '</a></li>'.
					'<li><a href="' . $link . '&' . $varName . '=' . array_pop( array_pop($allPages) ) . '">' . $this->endChar . '</a></li>';            
	  } else {
		$htmlOut .= '<li><span>' . $this->nextChar . '</span></li>'.
					'<li><span>' . $this->endChar . '</span></li>';         
	  }         
	  return '<ul id="'.$this->id.'">' . $htmlOut . '<ul>';
	}
 
  
	protected function searchPage( array $pagesList, /*int*/$needPage )
	{
		foreach( $pagesList AS $chunk => $pages  ){
			if( in_array($needPage, $pages) ){
				return $chunk;
			}
		}
		return 0;
	}    
}