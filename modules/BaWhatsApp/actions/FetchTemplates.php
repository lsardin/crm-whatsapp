<?php
include_once 'odules/BaWhatsApp/actions/SendMessage.php';
class BaWhatsApp_FetchTemplates_Action extends Vtiger_BasicAjax_Action {

    public function process(Vtiger_Request $request) {
        global $adb;
        $getExistCheck = $adb->pquery('select * from vtiger_ba_whatsapp_config');
        $existRecordId = $adb->query_result($getExistCheck , 0 ,'id');
        if($existRecordId){
            $url = $adb->query_result($getExistCheck , 0 ,'url');
            $token = $adb->query_result($getExistCheck , 0 ,'token');
        }        
        if( $token ) {
            $laravelPath = $url.'/api/vtFetchTemplate';      
            $curlObj = new BaWhatsApp_SendMessage_Action();
            $response = $curlObj->sendPost( $laravelPath , $token );
            $result = json_decode($response);

            foreach( $result as $template ){
                $serializeTemplate = base64_encode( serialize($template) );
                $getExist = $adb->pquery('select *from vtiger_ba_templates');
                if($adb->num_rows($getExist)){
                    $adb->pquery('update table vtiger_ba_templates set template = ? ' , array($serializeTemplate) );
                } else{
                    $adb->pquery('insert into vtiger_ba_templates (template) values(?)' , array($serializeTemplate));
                }
            }
           echo (count($result)); die;
        } else {
           echo false; die;
        }
    }    
}
