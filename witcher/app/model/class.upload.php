<?php

namespace Model;



class upload
{
    public $file_uploader;
    private $valid_array;
    public $file_name;
    private $target;
    public function Upload($valid_format_as_array,$newName,$targetfolder,$file){
        $witcher = new \witcher();
        $this->file_name = $newName;
        $this->file_uploader = $file;
        $ds = DIRECTORY_SEPARATOR;
        $this->valid_array = $valid_format_as_array;
        $this->target = $witcher->root().$targetfolder;
        if ($this->upload_file_error_check() == 0){
            if ($this->file_format_check() == 1){
                $from = $this->file_uploader['tmp_name'];
                $to = $this->target."/".$this->upload_get_filename();
                move_uploaded_file($from,$to);
                return $this->file_name;
            }else{
                return ['status' => false,'cause' => 'format'];
            }
        }else{
            return ['status' => false,'cause' => 'error_check_failed'];
        }
    }
    public function set_file_uploader($value){
        return $this->file_uploader = $value;
    }
    private function file_format_check(){
        $valid_array = $this->valid_array;
        $file_name = $this->file_uploader['name'];
        $iupload = explode(".",$file_name);
        $eupload = end($iupload);
        $success = false;
        foreach ($valid_array as $key) {
            switch ($eupload){
                case $key:
                    $success = true;
                    break;
            }
        }
        if ($success == true)
            return 1;
        else
            return 0;
    }
    public function upload_get_filename(){
        $name = $this->file_name;
        $file_name = $this->file_uploader['name'];
        $iupload = explode(".",$file_name);
        $eupload = end($iupload);
        $newname = $name.".".$eupload;
        return $newname;
    }
    public function upload_file_error_check(){
        if ($this->file_uploader['error'] > 0)
            return 1;
        else
            return 0;
    }
    public function get_end_file($file){
        $file_name = $file['name'];
        $iupload = explode(".",$file_name);
        $eupload = end($iupload);
        return $eupload;
    }
}