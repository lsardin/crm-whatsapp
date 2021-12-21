<?php
include_once 'vtlib/Vtiger/Module.php';
include_once 'includes/main/WebUI.php';

public function wf_suite_whatsapp_send_with_template_0( $apiKey,"",$sender,$telephone,$namespace, $elementName ){
    
    global $adb;
    $postData['destination'] = $telephone;
    $postData['account_number'] =  $sender;
    if(empty($elementName)){
        return false;
    }

    $getExistCheck = $adb->pquery('select * from vtiger_ba_whatsapp_config');
    $existRecordId = $adb->query_result($getExistCheck , 0 ,'id');
    if($existRecordId){
        $url = $adb->query_result($getExistCheck , 0 ,'url');
        $token = $adb->query_result($getExistCheck , 0 ,'token');
        $number = $adb->query_result($getExistCheck , 0 ,'phone_number');
    }
    $laravelPath = $url.'/api/vtSendMessage';
    
    $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $laravelPath,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $postData,
          CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$token ,
            'Cookie: laravel_session=eyJpdiI6InJJQjhPRE9sak1CRjhvd0EyRHdmcXc9PSIsInZhbHVlIjoidHdoRjBjWkdlTHZhc0Z5Q1BVKzBWbTAvS1FTTzdETDk1anFqUEtqanFWcGpOekl3NTRaUmJWOHpwYk84T1VYc1puS1NGc1BNODR6V2g0ME9Xei9yZldQZk5HQ0JpT3UwekFlRkpuZVhTSEIrcGZraEVNbWxBYUZCVzk4SVk4YXoiLCJtYWMiOiI1YTNiNDMyODZmZDYyZGE3YmMxYmI3OGE0MjgxMDllOTMxYTYxYTk3YTZlZmMwMmE5ZTkyODNiYjcwZDNhZjg5IiwidGFnIjoiIn0%3D'
          ),
        ));

        $response = curl_exec($curl);
    
        curl_close($curl);
        $return = false;
        $result = json_decode($response);
        if( isset($result->resultCode) ){
            $return = true;
        }
        
}
