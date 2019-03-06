<?php
/**
 * Created by PhpStorm.
 * User: Moting
 * Date: 2018/4/2
 * Time: 13:16
 */
namespace tool;

use \Fuel\Core\Image;

class Common
{
    public static function cut_picture($file_path, $file_type, $file_name)
    {
        // Using the file upload data, we can force the image's extension
        // via $force_extension
        Image::load($file_path, false, $file_type)
            ->crop_resize(225, 150)
            ->save($file_path);

    }
}