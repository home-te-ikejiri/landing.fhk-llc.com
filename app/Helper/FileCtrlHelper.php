<?php

use App\Libraries\FileCtrl;

// View側からパスを取得するときに利用
if (!function_exists('getFilePath')) {
    function getFilePath($file_name, $subdir = "", $isPhysical=false)
    {
        $file_ctrl = new FileCtrl();
        return $file_ctrl->getFilePath($file_name, $subdir);
    }
}

if (!function_exists('getDefaultImagePath')) {
    function getDefaultImagePath($file_name, $subdir = "", $isPhysical=false)
    {
        $file_ctrl = new FileCtrl();
        $default_image = url('images/default.jpg');
        if ($file_name) {
            $default_image = $file_ctrl->getFilePath($file_name, $subdir);
        }
        return $default_image;
    }
}



