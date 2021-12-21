<?php
include_once 'vtlib/Vtiger/Module.php';
include_once 'includes/main/WebUI.php';

class BaWhatsApp {
        public function vtlib_handler($moduleName, $eventType) {
                if ($eventType == 'module.postinstall') {
                        $this->_registerLinks($moduleName);
                } else if ($eventType == 'module.enabled') {
                        $this->_registerLinks($moduleName);
                } else if ($eventType == 'module.disabled') {
                        $this->_deregisterLinks($moduleName);
                }
        }

        protected function _registerLinks($moduleName) {
        	global $adb;
		$nextNum = $adb->pquery('select id from vtiger_settings_field_seq');
		$fieldId = $adb->query_result($nextNum, 0 , 'id');
		$fieldId ++;

		// Setting page script 
		$adb->pquery("insert into vtiger_settings_field (fieldid,blockid,name,linkto)values($fieldId ,4 ,'Whatsapp Configuration' ,'index.php?parent=Settings&module=BaWhatsApp&view=WhatsappConfigSetting')");
		$adb->pquery("update vtiger_settings_field_seq set id = ?",array($fieldId));

                $thisModuleInstance = Vtiger_Module::getInstance($moduleName);
                if ($thisModuleInstance) {
                        $thisModuleInstance->addLink('HEADERSCRIPT', 'BA WhatsApp Messager Script', 'modules/BaWhatsApp/Js/BaWhatsAppScript.js');
                }

                // Create Tables
                $adb->pquery("CREATE TABLE `vtiger_ba_templates` ( `id` int(11) NOT NULL AUTO_INCREMENT, `template` mediumtext, PRIMARY KEY (`id`) )");
                $adb->pquery("CREATE TABLE `vtiger_ba_whatsapp_config` ( `id` int(11) NOT NULL AUTO_INCREMENT, `url` varchar(255) DEFAULT NULL, `token` varchar(255) DEFAULT NULL, `phone_number` varchar(225) DEFAULT NULL, PRIMARY KEY (`id`) )");

                // Add Workflow 
                $nextNum = $adb->pquery('select id from com_vtiger_workflow_tasktypes_seq');
		$fieldId = $adb->query_result($nextNum, 0 , 'id');
		$fieldId ++;
		$modules = '{"include":[],"exclude":[]}';

		$adb->pquery("insert into com_vtiger_workflow_tasktypes VALUES ({$fieldId}, 'BaWhatsApp' , 'Send message on WhatsApp' , 'VTBaWhatsApp' , 'modules/com_vtiger_workflow/tasks/VTBaWhatsApp.inc' , 'modules/Settings/Workflows/Tasks/BaWhatsApp.tpl' , '{$modules}' , '' )");
		$adb->pquery("update com_vtiger_workflow_tasktypes_seq set id = ?",array($fieldId));
                
                copy("modules/BaWhatsApp/Workflow/BaWhatsApp.tpl" , 'layouts/v7/modules/Settings/Workflows/Tasks/BaWhatsApp.tpl');
                copy("modules/BaWhatsApp/Workflow/VTBaWhatsApp.inc" , 'modules/com_vtiger_workflow/tasks/VTBaWhatsApp.inc');


        }

        protected function _deregisterLinks($moduleName) {
                global $adb;
                $thisModuleInstance = Vtiger_Module::getInstance($moduleName);
                if ($thisModuleInstance) {
                        $thisModuleInstance->deleteLink("HEADERSCRIPT", "BA WhatsApp Messager Script", "modules/BaWhatsApp/Js/BaWhatsAppScript.js");
                }

                $adb->pquery("delete from com_vtiger_workflow_tasktypes where module='BaWhatsApp' and tasktypename='BaWhatsApp' ");
                $adb->pquery("delete from vtiger_settings_field where name='Whatsapp Configuration' and blockid=4 ");
        }
}
