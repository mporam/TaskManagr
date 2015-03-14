<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/class/modules/module.abstract.php');

class inprogress extends moduleAbstract {

    public function display() {
        $el = '';
        $el .= '<h3>In Progress</h3>';
        $el .= '<div class="inner-module">';
        $el .= '<img src="images/site/icons/loading.gif" class="loader">';
        $el .= '<table><tbody></tbody></table>';
        $el .= '</div>';

        return $el;
    }
} 