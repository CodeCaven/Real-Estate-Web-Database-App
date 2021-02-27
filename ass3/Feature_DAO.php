<?php
class DAO_Feature
{
    public $FEATURE_ID;
    public $FEATURE_NAME;
    private $_conn;

    function __construct($conn)
    {
        $this->_conn =$conn;
    }

    public function find_feature_by_id($feat_no)
    {
        $sql = 'SELECT * FROM Feature WHERE feature_id ='.$feat_no;
        $parse = oci_parse($this->_conn, $sql);
        if(!@oci_execute($parse)){
			return false;
		}

        $result = oci_fetch_assoc($parse);

        if($result)
        {
            $this->FEATURE_ID = $result['FEATURE_ID'];
            $this->FEATURE_NAME = $result['FEATURE_NAME'];
            return true;
        }
        else
        {
            return false;
        }

    }

    public function find($where)
    {
        $sql = "SELECT * FROM Feature";

        $whereClause = array();

        foreach($where as $key => $value)
        {
            $whereClause[] = $key . "='" . $value . "'";
        }
		

       if(count($whereClause) > 0)
       {
           $sql.= " WHERE " . implode(' AND ', $whereClause);
       }
	   
        $parse = oci_parse($this->_conn, $sql);
        if(!@oci_execute($parse)){
			return false;
		}

        $numrows = oci_fetch_all($parse, $results, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        if($numrows >0) {
            include_once('ReadOnlyResultSet.php');
            return new ReadOnlyResultSet($results);
        }
        else
        {
            return false;
        }
    }

}

?>
