<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
include_once 'modules/BaWhatsApp/actions/SendMessage.php';
class VTBaWhatsApp extends VTTask{
    public $executeImmediately = true;


    public function getFieldNames(){
        return array('recepients' , 'phone' , 'template' , 'general_field' , 'add_field' , 'message');
    }

    public function doTask($entity) {

        $data['destination'] =  $this->recepients ;
        $data['content'] = $this->message;
        $recordId = explode( 'x' , $entity->id )[1];
        $data['content'] = getMergedDescription($data['content'], $recordId ,'Contacts');
        $data['template'] = $this->template;

        // Send Message to WhatsApp via url
        $sendMessage = new BaWhatsApp_SendMessage_Action();
        $result = $sendMessage->sendMessage($data);
    }

    /*
     * Return contact list
     */
    public function getContacts(){
        global $adb;
        $getContacts = $adb->pquery( 'select firstname , lastname , mobile from vtiger_contactdetails' );
        $html = '<option value=""> Select </option>';
        while($row = $adb->fetch_array($getContacts)){
            $selected = ($row['mobile'] == $this->recepients) ? 'selected' : '';
            $html .= "<option value='{$row['mobile']}' {$selected}> {$row['firstname']} {$row['lastname']} ({$row['mobile']}) </option>";
        }
        echo $html;
    }

    /**
     * Return Template list
     */
    public function getTemplates(){
        global $adb;
        $getTemplates = $adb->pquery('select * from vtiger_ba_templates');
        $html = '<option value=""> Select </option>';
        while( $row = $adb->fetch_array($getTemplates) ){
            $templates = $row['template'];
            $decodeTemplate = unserialize( base64_decode( $templates ) );
            $selected = ($decodeTemplate->id == $this->template) ? 'selected' : '';
            $html .= "<option value='{$decodeTemplate->id}' {$selected}> {$decodeTemplate->name } </option>";
        }
        echo $html; 
    }

    /**
     * Return Fields list
     */
    public function getFields() {
        global $adb;
        $workflowModel = Settings_Workflows_Record_Model::getCleanInstance('Contacts');
            
            $recordStrucure = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($workflowModel,
             Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_DETAIL);
              $structuredValues = $recordStrucure->getStructure();
            $html = '<option value=""> Select </option>';
              foreach($structuredValues as $key=>$value){
            
                  foreach($value as $lbkey=>$lbvalue){
                    $html .= "<option value='{$lbkey}'> {$lbvalue->label} </option>";
                    }
             }
             echo $html;
    } 
}
