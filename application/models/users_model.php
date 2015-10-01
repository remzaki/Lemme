<?php
class users_model extends CI_Model {

    public function __construct()
    {
        $this->load->model('db_model');
    }

    public function dbconnect($server, $instance, $username, $password, $database)
    {
        $dbcon_init = $this->db_model->dbcon_init($server, $instance, $username, $password, $database);
        if(!$this->db_model->dbcon_check($dbcon_init)){
            return FALSE;
            exit();
        }

        return $dbcon_init;
    }
    /*end of dbconnect*/
    
    public function search($server, $instance, $username, $password, $store ,$database, $dbcon_init)
    {
        $script = "SELECT UserName,
                    up.UserID,
                    YEAR(wm.PasswordChangedDate) AS PCD,
                    FirstName,
                    LastName,
                    DisplayName,
                    RoleName,
                    RoleCode,
                    PasswordFailuresSinceLastSuccess AS RetryCount
                    FROM OrgUnit ou
                    JOIN OrgUnitUser ouu ON ou.OrgUnitId=ouu.OrgUnitId
                    JOIN UserProfile up ON ouu.UserId=up.UserId
                    JOIN webpages_Roles wr ON ouu.RoleId=wr.RoleId
                    JOIN webpages_Membership wm ON up.UserId=wm.UserId
                    WHERE ou.Name=?";
        $query = $dbcon_init->query($script, array($store));

        if ($query->num_rows() > 0){
            $result = array(
                'data'=>$query->result(),
                'count'=>$query->num_rows()
            );
            return $result;
//            echo ($result);
//            return $query->result();
//            echo $query->num_rows();
        }
        else{
            return FALSE;
        }
    }
    /*end of search*/
    
    public function details($server, $instance, $username, $password, $store ,$database, $dbcon_init, $userid)
    {
        $script = "SELECT DISTINCT(up.UserID),
                    UserName,
                    wm.PasswordChangedDate AS PCD,
                    FirstName,
                    LastName,
                    DisplayName,
                    RoleName,
                    RoleCode
                    FROM OrgUnit ou
                    JOIN OrgUnitUser ouu ON ou.OrgUnitId=ouu.OrgUnitId
                    JOIN UserProfile up ON ouu.UserId=up.UserId
                    JOIN webpages_Roles wr ON ouu.RoleId=wr.RoleId
                    JOIN webpages_Membership wm ON up.UserId=wm.UserId
                    WHERE up.UserID=?";
        $query = $dbcon_init->query($script, array($userid));

        if ($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return FALSE;
        }
    }
    /*end of details*/
    
    public function unlock($server, $instance, $username, $password, $database, $dbcon_init, $userid)
    {
        $script = "UPDATE webpages_Membership SET PasswordFailuresSinceLastSuccess='0' WHERE UserId=?";
        $query = $dbcon_init->query($script, array($userid));

        if ($query){
            $msg = array('msg'=>'Successfully Unlocked the User');
            return $msg;
        }
        else{
            return FALSE;
        }
    }
    /*end of search*/
	
}