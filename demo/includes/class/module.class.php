<?php
class module {

    public function __construct() {
    }

    private static $default = array(
        'class'     => null,
    );

    public function show($name, $size = 12, array $options = array())
    {
        $options = array_merge(\module::$default, $options);

        try {
            $module = new $name();
        } catch(Exception $e) {
            error($e->getMessage());
            return '<div>Module Failed to load.</div>';
        }

        $GLOBALS['js']->addScript('modules/' . $name . '.module.js');

        $el = '';
        $el .= '<div id="' . $name . '" class="module open col-' . $size . ' ' . $options['class'] . '">';
            $el .= '<div class="module-container ' . $name . '">';
                $el .= $module->display();
            $el .= '</div>';
        $el .= '</div>';
        echo $el;
    }

    public function filterBy() {
        $GLOBALS['js']->addScript('modules/filterBy.js');
        $el = '';
        $el .= '<div class="filterBy dropdown">';
        $el .= '<div class="title">Filter By</div>';
        $el .= '<ul><li class="err-msg">No Filters defined</li></ul>';
        $el .= '</div>';

        echo $el;
    }

    public function orderBy() {
        $GLOBALS['js']->addScript('modules/orderBy.js');
        $el = '';
        $el .= '<div class="orderBy dropdown">';
        $el .= '<div class="title">Order By</div>';
        $el .= '<ul><li class="err-msg">No order by defined</li></ul>';
        $el .= '</div>';

        echo $el;
    }
} 