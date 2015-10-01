<?php
class params_model extends CI_Model {

    public function __construct()
    {
        $this->load->model('db_model');
    }

    public function preset()
    {
        $this->load->database();

        $query = $this->db->query('SELECT Server, Instance, Username, Password FROM params ORDER BY ID DESC LIMIT 1');

        if ($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return FALSE;
        }
    }
     /*end of preset*/

    public function update_default($server, $instance, $username, $password, $database)
    {
        $this->load->database();

        $date=date("m-d-Y D g:i:s A");
        $data = array(
            'Server' => ($server),
            'Instance' => ($instance),
            'Username' => ($username),
            'Password' => ($password),
            'DateAdded' => ($date)
        );

        $query = $this->db->insert('params', $data);

        if ($query){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
     /*end of update_default*/

    public function search($server, $instance, $username, $password, $database)
    {
        $dbcon_init = $this->db_model->dbcon_init($server, $instance, $username, $password, $database);
        if(!$this->db_model->dbcon_check($dbcon_init)){
                        return FALSE;
                        exit();
        }

        $script = "select DisplayName Parameter,
                    pc.Name Category,
                    pg.[Description] [Group],
                    dc.Name Tab,
                    pg.GroupName rGroup,
                    pf.FieldName rParameter,
                    pf.[Description] [Description],
                    pg.RecordLimit
                    from ParameterCategory pc
                    join DeviceClass dc on pc.DeviceClassId=dc.DeviceClassId
                    join ParameterGroup pg on pc.ParameterCategoryId=pg.ParameterCategoryId
                    join ParameterField pf on pf.GroupName=pg.GroupName                    
                    ";
        $query = $dbcon_init->query($script);

        if ($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return FALSE;
        }
    }
    /*end of search*/
    
    public function getdetails($server, $instance, $username, $password, $database, $group, $field)
    {
        $dbcon_init = $this->db_model->dbcon_init($server, $instance, $username, $password, $database);
        if(!$this->db_model->dbcon_check($dbcon_init)){
            return FALSE;
            exit();
        }

        $script = "select DisplayName Field,
                    pc.Name Category,
                    pg.[Description] [Group],
                    dc.Name Tab,
                    pg.GroupName rGroup,
                    pf.FieldName rParameter,
                    pf.[Description] [Description],
                    pf.DetailedHelp Help,
                    vt.UIControlId UIType,
                    vt.FieldChoiceSetId
                    from ParameterCategory pc
                    join DeviceClass dc on pc.DeviceClassId=dc.DeviceClassId
                    join ParameterGroup pg on pc.ParameterCategoryId=pg.ParameterCategoryId
                    join ParameterField pf on pf.GroupName=pg.GroupName
                    join ValidationType vt on pf.ValidationTypeId=vt.ValidationTypeId
                    where pg.GroupName=? and pf.FieldName=?";
        $info = $dbcon_init->query($script, array($group, $field));
        $infos = $info->result();
        
        if ($info->num_rows() > 0){
            // check if parameter has options for selecting
            
            // setting it to empty by default
            $option = "";
            
            if($info->row('FieldChoiceSetId')!=''){    
                // has param value option
                $optqry = "select fc.Name Val, fc.Value rVal
                        from ParameterField pf
                        join ValidationType vt on pf.ValidationTypeId=vt.ValidationTypeId
                        join FieldChoiceSet fcs on fcs.FieldChoiceSetId=vt.FieldChoiceSetId
                        join FieldChoice fc on vt.FieldChoiceSetId=fc.FieldChoiceSetId
                        where GroupName=? and FieldName=?";
                
                $optres = $dbcon_init->query($optqry, array($group, $field));
                $option = $optres->result();
            }
            
            // get default value/s
            $defqry = "select * from ParameterDefaultData where GroupName=? and FieldName=?";
            $defres = $dbcon_init->query($defqry, array($group, $field));
            $defval = $defres->result();
            
            
            // final results as array
            $results = array(
                'infos' => $infos,
                'option' => $option,
                'defval' => $defval
                );
            
//            print_r($results);
            return $results;
        }
        else{
            return FALSE;
        }
    }
    /*end if getdetails*/
    
    public function getgroupdetails($server, $instance, $username, $password, $database, $group)
    {
        $dbcon_init = $this->db_model->dbcon_init($server, $instance, $username, $password, $database);
        if(!$this->db_model->dbcon_check($dbcon_init)){
            return FALSE;
            exit();
        }
        
        $query = "select * from ParameterDefaultData where GroupName=? order by RecordKey asc";
        $result = $dbcon_init->query($query, array($group));
        if ($result->num_rows() > 0){
            return $result->result();
        }
        else{
            return FALSE;
        }
    }
    
}