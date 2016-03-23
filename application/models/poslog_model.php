<?php
class poslog_model extends CI_Model {

    public function __construct()
    {
        $this->load->model('db_model');
    }
    
    public function gettranstypes($dbcon_init)
    {
        // GET THE Transaction Type IDs
        $sql = "SELECT TransactionTypeID, TransactionTypeDescription FROM TransactionTypeDictionary";

        $result = $dbcon_init->query($sql); 

        if ($result->num_rows() > 0)
        {
                return $result->result();
        }
        else
        {
                return FALSE;
        }
    }
    
    public function search($dbcon_init, $row, $table, $filter)
    {
        if ($row==0 || $row==1){
            $min = 1;
            $max = 21;
        }
        else{
            $min = $row + 1;
            $max = $row + 21;
        }
        if($table=="Transactions"){
            $script = "SELECT * 
                    FROM (SELECT ROW_NUMBER() OVER (ORDER BY TransactionNode.TransactionDateTime DESC) AS RowNum,
                            TransactionTypeDictionary.TransactionTypeDescription as TransType,
                            TransactionNode.TransactionID as TranID,
                            TransactionNode.StoreId as StoreId,
                            TransactionNode.WorkstationID as TermId,
                            TransactionTypeDictionary.TransactionTypeID as TransTypeId,
                            TransactionNode.TransactionDateTime as TransDate
                            FROM NCRWO_EJ..TransactionNode
                            JOIN NCRWO_EJ..TransactionTypeDictionary ON TransactionNode.TransactionTypeID=TransactionTypeDictionary.TransactionTypeID
                            ".$filter."
                            ) AS RC
                    WHERE RowNum >= ".$min."
                    AND RowNum < ".$max."
                    ORDER BY RowNum";
        }
        else{
            $script = "SELECT TransactionKey as TranID, * FROM TransactionLogDb..".$table." ".$filter." ORDER BY SequenceNumber DESC";
        }
        
        $query = $dbcon_init->query($script);

        if ($query->num_rows() > 0){
            return array($query->result(), $script);
        }
        else{
            return FALSE;
        }
    }
    /*end of search*/

    public function getPOSLog($dbcon_init, $table, $idtrn)
    {
        $sql = "SELECT TOP 1 XMLPayload FROM ".$table." WHERE TransactionKey = ".$idtrn." ";

        $result = $dbcon_init->query($sql); 

        if ($result->num_rows() > 0)
        {
                return $result->result();
        }
        else
        {
                return FALSE;
        }
        $dbcon_init->close();
    }
    /*end of getPOSLog*/
}