<?php
/**
 * Created by PhpStorm.
 * User: cdy88
 * Date: 2018/4/1
 * Time: 21:31
 */
namespace common;

use \Fuel\Core\Upload;
use \Fuel\Core\Uri;

class Controller_Home extends \Controller_Home
{

    /**
     * 生成子目录：生成日期目录
     * @return string
     */
    private function generate_child_directory(){

        $year = date('Y');
        $month = date('m');
        $day = date('d');

        return $year.DIRECTORY_SEPARATOR.$month.DIRECTORY_SEPARATOR.$day.DIRECTORY_SEPARATOR;
    }

    /**
     * 生成文件夹目录
     * @param $root
     * @return string
     */
    private function generate_directory_path($root){

        $child_directory = $this->generate_child_directory();

        if ( ! is_dir($root.$child_directory) ){
            try{
                \File::create_dir($root, $child_directory);
            }catch (\Exception $e){
                \Log::error("创建目录时，发生异常：" . $e->getMessage());
            }
        }

        return $root.$child_directory;
    }

    /**
     * 上传接口
     * @return array
     * @throws \Exception
     */
    public function post_upload()
    {
        $root_directory_path = DOCROOT.'uploads'.DIRECTORY_SEPARATOR;

        $base_attachment_url = Uri::base().'uploads'.DIRECTORY_SEPARATOR;

        // Custom configuration for this upload
        $config = array(
            'path' => $this->generate_directory_path($root_directory_path),
            'randomize' => true,
            'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),

        );

        // process the uploaded files in $_FILES
        \Upload::process($config);

        // if there are any valid files
        if( ! \Upload::is_valid()){

            foreach (\Upload::get_errors() as $key => $value) {
                foreach ($value['errors'] as $error){
                    $this->result['msg'] .= $error['message'];
                }
            }

            $this->result['code'] = 201;
            return $this->result;
        }
        // save them according to the config
        \Upload::save();

        $this->result['data'] = [];
        // call a model method to update the database
        foreach(Upload::get_files() as $file){

            $data = [
                'url' => str_replace(
                    '\\',
                    '/',
                    str_replace(
                        $root_directory_path,
                        $base_attachment_url,
                        $file['saved_to'].$file['saved_as']) ),
                'path' => $file['saved_to'].$file['saved_as'],
                'file' => $file['saved_as'],
                'type' => $file['type'],
                'size' => $file['size'],
                'user_id' => \Auth::get_user_id()[1],
            ];

            $attachment = \Model_Attachment::forge($data);

            $attachment->save();

            array_push($this->result['data'], $attachment->to_array());
        }

        return $this->result;
    }
}