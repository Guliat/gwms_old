<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class GeneralController extends Controller {
    
    
    
    
    public function addCustomerModal($modalbuttontext, $headertitle, $bodytext, $action, $updateid, $buttonsize) {
        // JAVASCRIPT
        echo '<script type="text/javascript">';
        echo '$j(function() {';
        echo 'var availableTags = ';
        $addCustomer = new \App\AutoComplete();
        $addCustomer->customers();
        echo ';';
        echo '$j("#addCustomer").autocomplete({';
        echo 'source: availableTags, appendTo: "#addcustomermodal", autoFocus:true, minLength: 2 });});';
        echo '</script>';
        // BUTTON
        echo "<button class='btn btn-info btn-";
        echo $buttonsize;
        echo "' data-toggle='modal' data-target='#addcustomermodal'>";
        echo $modalbuttontext;
        echo "</button>";
        // MODAL
        echo "<div id='addcustomermodal' class='modal fade' role='dialog'>";
        echo "<div class='modal-dialog'><div class='modal-content'>";
        // FORM
        echo "<form method='POST' action='";
        echo url($action);
        echo "'>";
        echo csrf_field();
        // HEADER
        echo "<div class='modal-header'>";
            echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
            echo "<h4 class='modal-title'>";
            echo $headertitle;
            echo "</h4>";
        echo "</div>";
        // BODY
        echo "<div class='modal-body'>";
            echo '<input type="hidden" name="update_id" value="';
            echo $updateid;
            echo '"/>';
            echo '<input class="form-control" placeholder="можете да търсите по номер, имена, прякор/напомняне, телефон" autocomplete="off" type="text" name="customer_id" id="addCustomer" />';
            echo $bodytext;
        echo "</div>";
        // FOOTER
        echo "<div class='modal-footer'>";
            echo "<button type='submit' class='btn btn-success ladda-button' data-style='expand-left'>";
            echo \Illuminate\Support\Facades\Lang::get('general.button_add');
            echo "</button>";
            echo "<button type='button' class='btn btn-danger' data-dismiss='modal'>";
            echo \Illuminate\Support\Facades\Lang::get('general.button_cancel');
            echo "</button>";
        echo "</div></form></div></div></div>";
    }
    
    public function addCompanyModal($modalbuttontext, $headertitle, $bodytext, $action, $updateid, $buttonsize) {
        // JAVASCRIPT
        echo '<script type="text/javascript">';
        echo '$j(function() {';
        echo 'var availableTags = ';
        $addCompany = new \App\AutoComplete();
        $addCompany->companies();
        echo ';';
        echo '$j("#addCompany").autocomplete({';
        echo 'source: availableTags, appendTo: "#addcompanymodal", autoFocus:true, minLength: 2 });});';
        echo '</script>';
        // BUTTON
        echo "<button class='btn btn-danger btn-";
        echo $buttonsize;
        echo "' data-toggle='modal' data-target='#addcompanymodal'>";
        echo $modalbuttontext;
        echo "</button>";
        // MODAL
        echo "<div id='addcompanymodal' class='modal fade' role='dialog'>";
        echo "<div class='modal-dialog'><div class='modal-content'>";
        // FORM
        echo "<form method='POST' action='";
        echo url($action);
        echo "'>";
        echo csrf_field();
        // HEADER
        echo "<div class='modal-header'>";
            echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
            echo "<h4 class='modal-title'>";
            echo $headertitle;
            echo "</h4>";
        echo "</div>";
        // BODY
        echo "<div class='modal-body'>";
            echo '<input type="hidden" name="update_id" value="';
            echo $updateid;
            echo '"/>';
            echo '<input class="form-control" placeholder="можете да търсите по номер, име, ЕИК, МОЛ и адрес" autocomplete="off" type="text" name="company_id" id="addCompany" />';
            echo $bodytext;
        echo "</div>";
        // FOOTER
        echo "<div class='modal-footer'>";
            echo "<button type='submit' class='btn btn-success ladda-button' data-style='expand-left'>";
            echo \Illuminate\Support\Facades\Lang::get('general.button_add');
            echo "</button>";
            echo "<button type='button' class='btn btn-danger' data-dismiss='modal'>";
            echo \Illuminate\Support\Facades\Lang::get('general.button_cancel');
            echo "</button>";
        echo "</div></form></div></div></div>";
    }
    
    static public function confirmModal($buttonstyle, $buttonsize, $modalbuttontext, $bodytext, $action, $confirmid) {
        // BUTTON
        echo "<button class='btn btn-";
        echo $buttonstyle;
        echo " btn-";
        echo $buttonsize;
        echo "' data-toggle='modal' data-target='#confirmModal'>";
        echo $modalbuttontext;
        echo "</button>";
        // MODAL
        echo "<div id='confirmModal' class='modal fade' role='dialog'>";
        echo "<div class='modal-dialog'><div class='modal-content'>";
        // FORM
        echo "<form method='POST' action='";
        echo url($action);
        echo "'>";
        echo csrf_field();
        // HEADER
        echo "<div class='modal-header text-center'>";
            echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
            echo "<h4 class='modal-title'>";
            echo \Illuminate\Support\Facades\Lang::get('general.usuretitle');
            echo "</h4>";
        echo "</div>";
        // BODY
        echo "<div class='modal-body text-center calibri20'>";
            echo "<input type='hidden' name='confirmid' value='";
            echo $confirmid;
            echo "' />";
            echo \Illuminate\Support\Facades\Lang::get('general.pleaseconfirm');
            echo $bodytext;
        echo "</div>";
        // FOOTER
        echo "<div class='modal-footer'>";
            echo "<button type='submit' class='btn btn-success ladda-button' data-style='expand-left'>";
            echo \Illuminate\Support\Facades\Lang::get('general.button_confirm');
            echo "</button>";
            echo "<button type='button' class='btn btn-danger' data-dismiss='modal'>";
            echo \Illuminate\Support\Facades\Lang::get('general.button_cancel');
            echo "</button>";
        echo "</div></form></div></div></div>";
    }

}
