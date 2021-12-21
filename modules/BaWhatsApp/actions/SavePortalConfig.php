<?php

class BaWhatsApp_SavePortalConfig_Action extends Vtiger_BasicAjax_Action {

    public function process(Vtiger_Request $request) {
        global $adb;
        $url = $_POST['portal_url'];
        $token = $_POST['token'];
        $number = $_POST['number'];

        $getExistCheck = $adb->pquery('select id from vtiger_ba_whatsapp_config');
        $existRecordId = $adb->query_result($getExistCheck , 0 ,'id');
        if($existRecordId){
            $adb->pquery('update vtiger_ba_whatsapp_config set url = ? , token = ? , phone_number = ? where id = 1', array($url , $token , $number ));
        } else {
            $adb->pquery('insert into vtiger_ba_whatsapp_config (url , token , phone_number ) values(?,?,?)', array($url , $token , $number));
        }
        echo json_encode( ['result' => true] ); 
        die;
    }    
}
