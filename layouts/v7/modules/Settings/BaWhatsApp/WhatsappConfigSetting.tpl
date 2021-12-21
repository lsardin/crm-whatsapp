{strip}
    <div class="editViewPageDiv editViewContainer" id="EditViewOutgoing" style="padding-top:0px;">
        <div class="alert alert-success hide" role="alert" id="ba_config_alert">
            Configuration saved successfully.
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div>
                <h3 style="margin-top: 0px;"> WhatsApp Configuration </h3> 
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="block">
                <div>
                    <div class="btn-group pull-right">
                    </div>
                    <h4> WhatsApp Portal Configuration </h4>
                </div>
                <hr>
                <table class="table editview-table no-border">
                    <tbody>
                        <tr>
                            <td class="{$WIDTHTYPE} fieldLabel"><label> Phone Number </label>&nbsp;<span class="redColor">*</span></td>
                            <td class="{$WIDTHTYPE} fieldValue"><div class=" col-lg-6 col-md-6 col-sm-12"><input type="text" id="phone_number" class="inputElement" name="token" data-rule-required="true" value="{$NUMBER}" ></div></td>
                        </tr>
                        <tr>
                            <td class="{$WIDTHTYPE} fieldLabel"><label> Access Token </label>&nbsp;<span class="redColor">*</span></td>
                            <td class="{$WIDTHTYPE} fieldValue"><div class=" col-lg-6 col-md-6 col-sm-12"><input type="text" id="access_token" class="inputElement" name="token" data-rule-required="true" value="{$TOKEN}" ></div></td>
                        </tr>
                        <tr>
                           <td class="{$WIDTHTYPE} fieldLabel"><label> Portal URL </label>&nbsp;<span class="redColor">*</span></td>
                           <td class="{$WIDTHTYPE} fieldValue"><div class=" col-lg-6 col-md-6 col-sm-12"><input type="text" id="portal_url" class="inputElement" name="url" data-rule-required="true" value="{$URL}" ></div></td>
                       </tr>
                       <tr>
                            <td class="{$WIDTHTYPE} fieldLabel"> </td>
                            <td class="{$WIDTHTYPE} fieldValue"> 
                                <button type="button" class="btn  btn-primary" id="ba-fetch-templates"> Fetch Template </button> 
                                <span id="response_result"> </span>
                            </td>
                       </tr>
                   </tbody>
               </table>    
            </div>
        </div>
        <div class='modal-overlay-footer clearfix'>
            <div class="row clearfix">
                <div class='textAlignCenter col-lg-12 col-md-12 col-sm-12 '>
                    <button type='button' id="save_portal_config" class='btn btn-success saveButton' >{vtranslate('LBL_SAVE', $MODULE)}</button>&nbsp;&nbsp;
                    <a class='cancelLink' data-dismiss="modal" href="#">{vtranslate('LBL_CANCEL', $MODULE)}</a>
                </div>
            </div>
        </div>

    </div>
        
