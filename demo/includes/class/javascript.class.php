<?php
class javascript {

    private $scripts = array();

    public function addScript($file) {
        $this->scripts[] = $file;
    }

    public function showScripts() {
        if (count($this->scripts) > 0) {
            $output = '';
            $str = '';
            if ($GLOBALS['environment']) {
                foreach ($this->scripts as $file) {
                    $output .= '<script src="/js/' . $file . '"></script>';
                }
            } else {
                foreach ($this->scripts as $file) {
                    $str .= file_get_contents($GLOBALS['root'] . '/js/' . $file);
                }
                $fileId = rand(1000,9999);
                $pattern = '/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/';
                $str = preg_replace($pattern, '', $str);
                $str = str_replace(array("\r", "\n"), "",$str);
                $str = preg_replace('/\s\s+/', ' ', $str);
                if (file_put_contents($GLOBALS['root'] . '/js/bundle-' . $fileId . '.min.js',$str)) {
                    $output = '<script src="/js/bundle-' . $fileId . '.min.js"></script>';
                }
            }
            echo $output;
        }
    }

} 