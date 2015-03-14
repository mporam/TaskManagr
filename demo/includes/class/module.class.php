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
        $el .= '<div id="' . $name . '" class="module col-' . $size . ' ' . $options['class'] . '">';
            $el .= '<div class="module-container ' . $name . '">';
                $el .= $module->display();
            $el .= '</div>';
        $el .= '</div>';
        echo $el;
    }

} 