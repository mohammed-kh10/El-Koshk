<?php
function langEn($phrase){
    static $lang = array(
        // home page
        'message' => 'welcome',
        'Admin' => 'adimistrator',

    );

    return $lang ($phrase);
}
?>