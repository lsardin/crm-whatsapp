{strip}
    <div id="VtEmailTaskContainer">
        <div class="row">
            <div class="col-sm-12 col-xs-12" style="margin-bottom: 70px;">
                <div class="row form-group" >
                    <div class="col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-sm-3 col-xs-3"> Recepients </div>
                            <div class="col-sm-4 col-xs-4">
                                <input name="recepients" id="ba-recepients" class=" fields inputElement" type="text" value="{$TASK_OBJECT->recepients}" />
                            </div>
                            <div class="col-md-5">
                                <select id="ba_contact" class="select2 col-md-10">
                                    {$TASK_OBJECT->getContacts()}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group" >
                    <div class="col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-sm-3 col-xs-3"> WhatsApp Template </div>
                            <div class="col-sm-9 col-xs-9">
                                <select name="template" class="select2" >
                                    {$TASK_OBJECT->getTemplates()}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group" >
                    <div class="col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-sm-3 col-xs-3"> General fields </div>
                            <div class="col-sm-9 col-xs-9">
                                <select name="general_field" id="ba-contact-field" class="select2" style="width:200px">
                                    {$TASK_OBJECT->getFields()}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group" >
                    <div class="col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-sm-3 col-xs-3">  </div>
                            <div class="col-sm-9 col-xs-9">
                                <button class="btn btn-primary" id="ba-add-ield" type="button"> Add Field </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-group" >
                    <div class="col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-sm-3 col-xs-3"> Message </div>
                            <div class="col-sm-9 col-xs-9">
                                <textarea name="message" class="form-control" id="ba-message-content"> {$TASK_OBJECT->message} </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/strip}
