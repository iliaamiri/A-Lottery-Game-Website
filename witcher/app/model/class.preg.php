<?php
namespace Model;

class preg{
    public function username($value){
        if (preg_match('/^[a-zA-Z0-9-_]*$/i',$value)){
            return 1;
        }else{
            return 0;
        }
    }
    public function password($value){
        if (preg_match('/^[a-zA-Z0-9-_+?!$@#*\s]*$/i',$value)){
            return 1;
        }else{
            return 0;
        }
    }
    public function text($value){
        if (preg_match('/^[a-zA-Z0-9آ-ی-.،,*:;()<>"+=@&?؟ !#\/_\s]*$/u',$value)){
            return 1;
        }else{
            return 0;
        }
    }
    public function alphabet($value,$space = 0){
        $match = "/^[a-zA-Z]*$/i";
        if ($space == 1){
            $match = "/^[a-zA-Z\s]*$/i";
        }
        if (preg_match($match,$value)){
            return 1;
        }else{
            return 0;
        }
    }
    public function number($value){
        if (preg_match('/^[0-9]*$/i',$value)){
            return 1;
        }else{
            return 0;
        }
    }
    public function email($value){
        if (filter_var($value, FILTER_VALIDATE_EMAIL)){
            if (preg_match('/^[a-zA-Z0-9_.-@+,]*$/i',$value)){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    public function md5($value){
        if (preg_match('/^[a-z0-9]*$/i',$value)){
            return 1;
        }else{
            return 0;
        }
    }
    public function custom($pattern,$value){
        if (preg_match($pattern,$value)){
            return 1;
        }else{
            return 0;
        }
    }
}