<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_BaWhatsApp_WhatsappConfigSetting_View extends Settings_Vtiger_Index_View {

    public function process(Vtiger_Request $request) {
        global $adb; 
        $url = $token = $number = '';
        $viewer = $this->getViewer($request);
        $qualifiedName = $request->getModule(false);
        $getExistCheck = $adb->pquery('select * from vtiger_ba_whatsapp_config');
        $existRecordId = $adb->query_result($getExistCheck , 0 ,'id');
        if($existRecordId){
            $url = $adb->query_result($getExistCheck , 0 ,'url');
            $token = $adb->query_result($getExistCheck , 0 ,'token');
            $number = $adb->query_result($getExistCheck , 0 ,'phone_number');
        }

        $viewer->assign('URL', $url);
        $viewer->assign('TOKEN', $token);
        $viewer->assign('NUMBER', $number);
        $viewer->assign('QUALIFIED_MODULE', $qualifiedName);
        $viewer->view('WhatsappConfigSetting.tpl',$qualifiedName);
    }

}
