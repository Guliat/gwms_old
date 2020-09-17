<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class General extends Model {
    public static function showDate($showDate) {
        $showDateIn = strtotime($showDate);
        $dateStyle = date("d F Y", $showDateIn);
        $showDateArray1 = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $showDateArray2 = array("Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември");
        $showDateOut = str_replace($showDateArray1, $showDateArray2, $dateStyle);
        echo $showDateOut;
    }
    public static function showDateTime($showDate) {
        $showDateIn = strtotime($showDate);
        $dateStyle = date("d/m/Y - H:i:s", $showDateIn);
        $showDateArray1 = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $showDateArray2 = array("Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември");
        $showDateOut = str_replace($showDateArray1, $showDateArray2, $dateStyle);
        echo $showDateOut;
    }
    public static function backButton() {
        echo "<a href='";
        echo \Illuminate\Support\Facades\URL::previous();
        echo "' class='btn btn-danger btn-md' style='position: fixed; top: 0; left: 0; width: 10%; height: 36px;'>";
        echo \Illuminate\Support\Facades\Lang::get('general.button_back');
        echo "</a>";
    }
}    
