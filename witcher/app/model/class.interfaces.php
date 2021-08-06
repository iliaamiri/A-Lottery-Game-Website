<?php
namespace Model;

use Config\tables;

class interfaces{

    private $tbl;
    function __construct()
    {
        $table = new tables();
        $this->tbl = ['Sliders' => $table->MAIN_TABLES['Interfaces']['Sliders']];
    }

    // Sliders' Model Layers
    private $Slider_Values = [];
    private $Images_Path;
    private $Icon_Path;


    /* Sliders' SET values */
    public function SetSliderValues($ARRAY){
        $this->Slider_Values['Icon_Image'] = $ARRAY['Icon_Image'];
        $this->Slider_Values['Big_Image'] = $ARRAY['Big_Image'];
        $this->Slider_Values['Header_Text'] = $ARRAY['Header_Text'];
        $this->Slider_Values['Active_Status'] = $ARRAY['Active_Status'];
        $this->Slider_Values['Content_Text'] = $ARRAY['Content_Text'];
        $this->Slider_Values['Href_Url'] = $ARRAY['Href_Url'];
        $this->Slider_Values['Button_Status'] = $ARRAY['Button_Status'];
        $this->Slider_Values['Button_Text'] = $ARRAY['Button_Text'];
        $this->Slider_Values['Button_Color'] = $ARRAY['Button_Color'];
        $this->Slider_Values['Published_At'] = $ARRAY['Published_At'];
        $this->Slider_Values['Published_By'] = $ARRAY['Published_By'];
    }
    public function SetImagesPath($path){
        $this->Images_Path = $path;
    }
    public function SetIconPath($path){
        $this->Icon_Path = $path;
    }
    /*
     * Sliders' GET values
     *
     */
    public function GetSlidersByStatement($statements){
        $db = new db();
        $sql = $db->db_query("SELECT * FROM ".$this->tbl['Sliders']." $statements",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function GetSlidersNumberByStatement($statements){
        $db = new db();
        $sql = $db->db_query("SELECT * FROM ".$this->tbl['Sliders']." $statements",1);
        return count($sql->fetchAll(\PDO::FETCH_ASSOC));
    }
    public function GetSlidersColumnByStatementDirectly($columns, $statements){
        $db = new db();
        $sql = $db->db_query("SELECT $columns FROM ".$this->tbl['Sliders']." $statements",1);
        return $sql->fetchAll(\PDO::FETCH_COLUMN);
    }
    public function IsSlidersActive($add_to_statement){
        $db = new db();
        $sql = $db->db_query("SELECT * FROM ".$this->tbl['Sliders']." WHERE Active_Status = '1' $add_to_statement",1);
        if ($sql->rowCount() > 0 ){
            return true;
        }else{
            return false;
        }
    }
    public function IsSlidersEdited($add_to_statement){
        $db = new db();
        $sql = $db->db_query("SELECT * FROM ".$this->tbl['Sliders']." WHERE Last_Edit_At != NULL $add_to_statement",1);
        if ($sql->rowCount() > 0 ){
            return true;
        }else{
            return false;
        }
    }
    public function IsSliderButtonActive($add_to_statement){
        $db = new db();
        $sql = $db->db_query("SELECT * FROM ".$this->tbl['Sliders']." WHERE Button_Status = '1' $add_to_statement",1);
        if ($sql->rowCount() > 0 ){
            return true;
        }else{
            return false;
        }
    }
    /*
     * Sliders' Services Layer
     *
     */
    public function NewSlider(){
        $Uploader = new upload();
        $db = new db();
        $image_target_folder = $this->Images_Path;
        $icon_target_folder = $this->Icon_Path;
        $NewName = "s".rand(1000,9999);
        $White_list_formats = ['JPG','jpg','PNG','png','svg']; // white list of files' formats
        $files = [$this->Slider_Values['Icon_Image'],$this->Slider_Values['Big_Image']];
        foreach ($files as $file){
            $Uploader->set_file_uploader($file);
            if ($Uploader->upload_file_error_check() == 1 ){
                return ['status' => false,'cause' => 'files_error'];
            }
        }
        $upload1 = $Uploader->Upload($White_list_formats,$NewName,$image_target_folder,$files[1]);
        if (isset($upload1['status'])){
            if ($upload1['status'] == false){
                return ['status' => false,'cause' => 'format_files']; // check upload result
            }
        }
        $upload1_path = $this->Images_Path."/".$Uploader->upload_get_filename().".".$Uploader->get_end_file($files[1]);
        $upload2 = $Uploader->Upload($White_list_formats,$NewName,$icon_target_folder,$files[0]);
        if (isset($upload2['status'])){
            if ($upload2['status'] == false){
                return ['status' => false,'cause' => 'format_files']; // check upload result
            }
        }
        $upload2_path = $this->Icon_Path."/".$Uploader->upload_get_filename().".".$Uploader->get_end_file($files[0]);
        $this->Slider_Values['Icon_Image'] = $upload2_path; // set new Icon_Image value
        $this->Slider_Values['Big_Image'] = $upload1_path; // set new Big_Image value
        $values = "'".implode("','",$this->Slider_Values)."'";
        // Insert into db :
        $db->db_query("INSERT INTO ".$this->tbl['Sliders']." (Icon_Image,Big_Image,Header_Text,Content_Text,Href_Url,Button_Status,Button_Text,Button_Color,Active_Status,Published_At,Published_By) VALUES ($values)",1);
    }
    public function UpdateSlider($slider_id,$by){
        $db = new db();
        $Uploader = new upload();
        $old_slider = $this->GetSlidersByStatement("WHERE id = '".$slider_id."'")[0];
        $NewName = "s".rand(1000,9999);
        $white_list = ['JPG','jpg','PNG','png','svg'];
        if ($this->Slider_Values['Big_Image'] != ""){
            $image_name = explode("/",$old_slider['Big_Image']);
            $image_name = end($image_name);
            if(file_exists(DIR_PUBLIC.$this->Images_Path."/".$image_name)){
                unlink(DIR_PUBLIC.$this->Images_Path."/".$image_name);
            }
            $upload2 = $Uploader->Upload($white_list,$NewName,"public_html/".$this->Images_Path,$this->Slider_Values['Big_Image']);
            if (isset($upload2['status'])){
                if ($upload2['status'] != false){
                    return ['status' => false,'cause' => 'failed to upload.'];
                }
            }
            $upload2_path = $this->Images_Path."/".$Uploader->upload_get_filename();
            $this->Slider_Values['Big_Image'] = $upload2_path;
        }else{
            $this->Slider_Values['Big_Image'] = $old_slider['Big_Image'];
        }
        if ($this->Slider_Values['Icon_Image'] != ""){
            $icon_name = explode("/",$old_slider['Icon_Image']);
            $icon_name = end($icon_name);
            if (file_exists(DIR_PUBLIC.$this->Icon_Path."/".$icon_name)){
                unlink(DIR_PUBLIC.$this->Icon_Path."/".$icon_name);
            }
            $upload1 = $Uploader->Upload($white_list,$NewName,"public_html/".$this->Icon_Path,$this->Slider_Values['Icon_Image']);
            if (isset($upload1['status'])){
                if ($upload1['status'] != false){
                    return ['status' => false,'cause' => 'failed to upload.'];
                }
            }
            $upload1_path = $this->Icon_Path."/".$Uploader->upload_get_filename();
            $this->Slider_Values['Icon_Image'] = $upload1_path;
        }else{
            $this->Slider_Values['Icon_Image'] = $old_slider['Icon_Image'];
        }
        $time = time();
        $db->db_query("UPDATE ".$this->tbl['Sliders']." SET Icon_Image = '".$this->Slider_Values['Icon_Image']."' , Big_Image = '".$this->Slider_Values['Big_Image']."' , Header_Text = '".$this->Slider_Values['Header_Text']."' , Content_Text = '".$this->Slider_Values['Content_Text']."' , Href_Url = '".$this->Slider_Values['Href_Url']."' , Button_Status = '".$this->Slider_Values['Button_Status']."' , Button_Text = '".$this->Slider_Values['Button_Text']."', Button_Color ='".$this->Slider_Values['Button_Color']."' , Last_Edit_By = '$by' , Last_Edit_At = '$time' , Active_Status = '".$this->Slider_Values[Active_Status]."' WHERE id = '$slider_id'",1);
    }
    public function UpdateSliderCustom($changes,$statements){
        $db = new db();
        $db->db_query("UPDATE ".$this->tbl['Sliders']." SET $changes $statements",1);
        return true;
    }
    public function DeleteSlider($slider_id){
        $db = new db();
        $old_slider = $this->GetSlidersByStatement("WHERE id = '".$slider_id."'");
        $icon_name = explode("/",$old_slider['Icon_Image']);
        $image_name = explode("/",$old_slider['Big_Image']);
        $icon_name = end($icon_name);
        $image_name = end($image_name);
        if (file_exists(DIR_PUBLIC.$this->Icon_Path."/".$icon_name)){
            unlink(DIR_PUBLIC.$this->Icon_Path."/".$icon_name);
        }elseif(file_exists(DIR_PUBLIC.$this->Images_Path."/".$image_name)){
            unlink(DIR_PUBLIC.$this->Images_Path."/".$image_name);
        }
        $db->db_query("DELETE FROM ".$this->tbl['Sliders']." WHERE id = '$slider_id'",1);
    }
}