<?php
namespace Model;

use Config\tables;

class user {
    //private $user_permission = [1=>"admin"];
    public $user_db_info = array(
        'db_Table' => "user_tbl",
        'db_Column'=> "Username"
    );
    public $user_column = "Username";
    private static $permission;
    public $Image_src_target = "panel/src/img";

    public function user_exist($user_name){
        $preg = new preg();
        $preg_user = $preg->username($user_name);
        if ($preg_user == 1){
            $db = new db();
            $sql = $db->db_query("SELECT * FROM $this->user_db_info['db_Table'] WHERE $this->user_db_info['db_Column'] = '$user_name'",1);
            if ($sql->rowCount() > 0){
                return 1;
            }
            else{
                return 0;
            }
        }else{
            return $result = ['status' => 'failed', 'cause' => 'Invalid Value'];
        }
    }
    public function user_get_certificate(){
        $preg = new preg();
        if (isset($_SESSION['Certificate_Code'])){
            $preg_code = $preg->custom('/^[a-z0-9]*$/i',$_SESSION['Certificate_Code']);
            if ($preg_code === 1){
                $db = new db();
                $table = $this->user_db_info['db_Table'];
                $sql = $db->db_query("SELECT * FROM $table WHERE Session_id = '$_SESSION[Certificate_Code]'",1);
                if ($sql->rowCount() > 0){
                    $row = $sql->fetch(\PDO::FETCH_ASSOC);
                    return $row;
                }
                else{
                    return $result = ['status' => 'failed', 'cause' => 'Certificate Code is not set'];
                }
            }else{
                return $result = ['status' => 'failed', 'cause' => 'pregmatch is invalid'];
            }
        }elseif (!isset($_SESSION['Certificate_Code'])){
            return $result = ['status' => 'failed', 'cause' => 'Certificate Code is not set'];
        }
    }
    public function user_get_permission($check_certificate = 1,$by_email = "",$by_custom = ""){
        $table = new tables();
        $user_tbl = $table->MAIN_TABLES['user'];
        if ($check_certificate == 1){
            $user = $this->user_get_certificate();
            $where = $user_tbl.".Session_id='".$user['Session_id']."'";
        }
        elseif($by_email != "" AND $check_certificate != 1){
            $user = $by_email;
            $where = $user_tbl.".Email = '".$user."'";
        }
        elseif (empty($by_username) AND is_array($by_custom)){
            $where = $user_tbl.".".$by_custom[0]." = '".$by_custom[1]."'";
        }
        $db = new db();
        $sql = $db->db_query("SELECT user_permissions.* FROM user_tbl RIGHT JOIN user_permissions ON user_tbl.Email = user_permissions.Email WHERE $where", 1);
        if ($sql->rowCount() > 0 ){
            self::$permission = $sql->fetch(\PDO::FETCH_ASSOC);
            return self::$permission;
        }else{
            return false;
        }
    }
    public function AddUser($data,$permissions){
        $db = new db();
        $preg = new preg();
            $data['Password'] = md5(sha1(md5($data['Password'])));
            $tables = new tables();
            $user_tbl = $tables->MAIN_TABLES['user'];
            $user_permissions = $tables->MAIN_TABLES['permissions'];
            $values = "";
            $end = count($permissions) - 1;
            foreach ($permissions as $a=>$b){
                if ($a == $end){
                    $values .= "'".$b."'";
                }else{
                    $values .= "'".$b."',";
                }
            }
            try{
                $db->db_query("INSERT INTO $user_permissions (Email,Active,Admin,Invite,WriteSite,ReadUsers,WriteUsers,WriteMenu,Comment,Login) VALUE ($values)",1);
                $db->db_query("INSERT INTO $user_tbl (Username,Password,Email,Full_Name) VALUE ('$data[Username]','$data[Password]','$data[Email]','$data[Full_Name]')",1);
                return true;
            }catch (\PDOException $e){
                $error = [
                    'Name' => 'PDO Exception',
                    'Function' => 'AddUser',
                    'Details' => $e
                ];
                return $error;
            }

    }
    public function CountUsers(){
        $db = new db();
        $table = new tables();
        $table = $table->MAIN_TABLES['user'];
        $sql = $db->db_query("SELECT * FROM $table",1);
        return $sql->rowCount();
    }
    public function CountUsersBy($column,$value){
        $db = new db();
        $table = new tables();
        $table = $table->MAIN_TABLES['user'];
        $sql = $db->db_query("SELECT * FROM $table WHERE $column = '$value'",1);
        return $sql->rowCount();
    }
    public function getActiveUsers(){
        $db = new db();
        $table = new tables();
        $table = array($table->MAIN_TABLES['user'],$table->MAIN_TABLES['permissions']);
        $sql = $db->db_query("SELECT $table[0].* FROM $table[0] LEFT JOIN $table[1] ON $table[0].Email = $table[1].Email WHERE $table[1].Active = 1",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getUserInfoBy($column,$value){
        $db = new db();
        $table = new tables();
        $table = $table->MAIN_TABLES['user'];
        $sql = $db->db_query("SELECT * FROM $table WHERE $column = '$value'",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getAll(){
        $db = new db();
        $table = new tables();
        $table = [$table->MAIN_TABLES['user'],$table->MAIN_TABLES['permissions']];
        $sql = $db->db_query("SELECT $table[0].*, $table[1].* FROM $table[0] INNER JOIN $table[1] ON $table[0].Email = $table[1].Email",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getWhoHasWallet(){
        $db = new db();
        $table = new tables();
        $table = [$table->MAIN_TABLES['user'],$table->MAIN_TABLES['Wallet_tbl']];
        $wallet_tbl = $table[1];
        $user_tbl = $table[0];
        $sql = $db->db_query("SELECT $user_tbl.* , $wallet_tbl.* FROM $wallet_tbl LEFT JOIN $user_tbl ON $wallet_tbl.Email = $user_tbl.Email",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getUserRoleCats($Email){
        $db = new db();
        $table = new tables();
        $table = [$table->MAIN_TABLES['permissions'],$table->MAIN_TABLES['Roles']];
        $sql = $db->db_query("SELECT $table[1].* FROM $table[0] RIGHT JOIN $table[1] ON $table[0].role_id = $table[1].Role_Id WHERE $table[0].Email = '$Email'",1);
        return $sql->fetch(\PDO::FETCH_ASSOC);
    }
    public function CountUsersBy_Permission($permission,$value){
        $db = new db();
        $table = new tables();
        $table = $table->MAIN_TABLES['permissions'];
        $sql = $db->db_query("SELECT * FROM $table WHERE $permission = '$value'",1);
        $row = $sql->fetchAll(\PDO::FETCH_ASSOC);
        return count($row);
    }
    public function SwitchPermission($permission,$statement,$email){
        $db = new db();
        $table = new tables();
        $table = $table->MAIN_TABLES['permissions'];
        $value = $db->db_query("SELECT * FROM $table WHERE Email = '$email'",1)->fetch(\PDO::FETCH_ASSOC)[$permission];
        if ($value == 0 ) {
            $newvalue = 1;
        }else {
            $newvalue = 0;
        }
        $db->db_query("UPDATE $table SET $permission = '$newvalue' $statement",1);
    }
    public function UpdateRolePermission($email,$new){
        $db = new db();
        $table = new tables();
        $table = $table->MAIN_TABLES['permissions'];
        $db->db_query("UPDATE $table SET Role_Id = '$new' WHERE Email = '$email'",1);
    }
    public function UpdateUserTbl($password,$image,$Email,$newEmail = "",$newFull = "",$newusername = ""){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['user'];
        $custom = "";
        $custom2 = "";
        $custom3 = "";
        if ($newEmail != ""){
            $custom = ", Email = '".$newEmail."'";
        }
        if ($newFull != ""){
            $custom2 = " , Full_Name = '".$newFull."'";
        }
        if ($newusername != ""){
            $custom3 = " , Username = '".$newusername."'";
        }
        $db->db_query("UPDATE $tbl SET Password = '$password', Profile_Image = '$image' $custom $custom2 $custom3 WHERE Email = '$Email'",1);
    }
    public function HowCompleteIsProfile($email){
        $db = new db();
        $table = new tables();
        $tbl = [$table->MAIN_TABLES['user'],$table->MAIN_TABLES['permissions']];
        $sql = $db->db_query("SELECT * FROM $tbl[0] WHERE Email = '$email'",1);
        $sql2 = $db->db_query("SELECT * FROM $tbl[1] WHERE Email = '$email'",1);
        $user_info = $sql->fetch(\PDO::FETCH_ASSOC);
        $user_permissions = $sql2->fetch(\PDO::FETCH_ASSOC);
        $total_info = array_merge($user_info,$user_permissions);
        $percentages_names = ['Active','Invite_Code','Profile_Image','Message'];
        $total = count($percentages_names);
        $i = 0;
        foreach ($percentages_names as $key){
            if (isset($user_info[$key])){
                if (strlen($user_info[$key]) > 0){
                    $i++;
                }
            }
            if (isset($user_permissions[$key])){
                if ($user_permissions[$key] == 1){
                    $i++;
                }
            }
        }
        return ($i * 100) / $total;
    }
    public function UpdateColumn($column,$value,$statement){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['user'];
        $db->db_query("UPDATE $tbl SET $column = '$value' $statement" ,1 );
        return true;
    }
    public function UpdatePermission($column,$value,$email){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['permissions'];
        $db->db_query("UPDATE $tbl SET $column = '$value' WHERE Email = '$email'" ,1 );
        return true;
    }
    public function PercentageOfBrowsers($browsers_list){
        $db = new db();
        $table = new tables();
        $tbl = $table->MAIN_TABLES['user'];
        $result = [];
        $sql_users = $db->db_query("SELECT * FROM $tbl",1);
        $rows = $sql_users->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($browsers_list as $browser){
            $sql = $db->db_query("SELECT * FROM $tbl WHERE Last_Browser = '$browser'",1);
            $result[$browser] = $sql->rowCount();
        }
        $last_result = [];
        foreach ($result as $key => $cal){
            $last_result[$key] = 100 * $cal / $sql_users->rowCount();

        }
        return $last_result;
    }
    public function getRoles(){
        $db = new db();
        $table = new tables();
        $table = $table->MAIN_TABLES['Roles'];
        $sql = $db->db_query("SELECT * FROM $table",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function exist_role($id){
        $db = new db();
        $table = new tables();
        $table = $table->MAIN_TABLES['Roles'];
        $sql = $db->db_query("SELECT * FROM $table WHERE Role_Id = '$id'",1);
        if ($sql->rowCount() > 0 )
            return true;
        else
            return false;
    }
    public function delete($email){
        $db = new db();
        $table = new tables();
        $tbl = [$table->MAIN_TABLES['user'],$table->MAIN_TABLES['permissions']];
        $db->db_query("DELETE FROM $tbl[0] WHERE Email = '$email'",1);
        $db->db_query("DELETE FROM $tbl[1] WHERE Email = '$email'",1);
        return true;
    }
    public function select_from_permission($statement){
        $db = new db();
        $table = new tables();
        $table = $table->MAIN_TABLES['permissions'];
        $sql = $db->db_query("SELECT * FROM $table $statement",1);
        return $sql->fetchAll(\PDO::FETCH_ASSOC);
    }
}