<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/class/modules/module.abstract.php');

class recenttasks extends moduleAbstract {

    public function display() {
        $el = '';
        $el .= '<h3>Recent Tasks</h3>';
        $el .= '<div class="inner-module">';
        $el .= '<img src="images/site/icons/loading.gif" class="loader">';
        $el .= '<table><tbody></tbody></table>';
        $el .= '</div>';

        return $el;
    }
} 