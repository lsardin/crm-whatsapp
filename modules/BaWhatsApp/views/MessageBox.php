<?php
class BaWhatsApp_MessageBox_View extends Vtiger_Index_View{
    public function process( Vtiger_Request $request ){
        $viewer = $this->getViewer ($request);
        $moduleName = $request->getModule();
	
    	if(isset($_REQUEST['operation']) && $_REQUEST['operation'] == 'loadMessages') {
        	$getMessages = $this->getCurrentContactMessages($_GET['number'] , $_GET['page']); 
        	$viewer->assign('MESSAGES' , $getMessages);
        	$html = $viewer->view('messages.tpl', $moduleName , true);
        	echo json_encode([ 'html' => $html ]); die;
        } 
    		
        $recordId = $_GET['record_id'];
        $sourceModuleName = 'Contacts';
        $recordModel = Vtiger_Record_Model::getInstanceById($recordId, $sourceModuleName);
        $number = $recordModel->get('mobile');	
    	$getMessages = $this->getCurrentContactMessages($number ); 
    
        $viewer->assign('TARGET_NUMBER' , $number);
    	$viewer->assign('MESSAGES' , $getMessages);
        $html = $viewer->view('MessageBox.tpl', $moduleName , true);
        echo json_encode([ 'html' => $html , 'number' => $number ]); die;
    }
	
	/**
	 * Return conversation
	 */ 
	public function getCurrentContactMessages($number, $page = 0){
    	global $adb;
    	$page ++;
    	$limit = $page * 30;
    	$offset = $limit - 30;
    	$conversation = [];    	
   
    	$getMessages = $adb->pquery("select vtiger_messaggiwhatsappcf.from_number, vtiger_messaggiwhatsappcf.from_name, vtiger_messaggiwhatsappcf.testo_del_messaggio, vtiger_crmentity.createdtime from vtiger_messaggiwhatsapp  INNER JOIN vtiger_crmentity ON vtiger_messaggiwhatsapp.messaggiwhatsappid = vtiger_crmentity.crmid INNER JOIN vtiger_messaggiwhatsappcf ON vtiger_messaggiwhatsapp.messaggiwhatsappid = vtiger_messaggiwhatsappcf.messaggiwhatsappid where from_number = ? OR to_number = ? order by createdtime desc limit ?,? ", array($number , $number , $offset ,$limit) );
    	while($row = $adb->fetch_array($getMessages)){
        	$method = 'post';
        	if($number == $row['from_number']){
            	$method = 'get';
            }
            $conversation[] = [ 
            					'type' => $method, 
                               	'name' => $row['from_name'] , 
                               	'content' => $row['testo_del_messaggio'], 
                               	'time' => date_format( new DateTime($row['createdtime']), 'g:i A | M j, Y ')  
                              ];
        }
       return array_reverse($conversation);
    }
}
