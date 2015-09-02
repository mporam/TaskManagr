<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/class/modules/module.abstract.php');

class stats extends moduleAbstract {

    public function display() {
        $GLOBALS['js']->addScript('libraries/jquery.circliful.min.js');

        $el = '';
        $el .= '<h3>My stats</h3>';
        $el .= '<div class="inner-module">';
        $el .= '<img src="images/site/icons/loading.gif" class="loader">';
        $el .= '</div>';

        return $el;
    }
} 