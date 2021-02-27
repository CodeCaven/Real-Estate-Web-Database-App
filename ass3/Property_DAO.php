<?php
class DAO_Property
{
    public $PROPERTY_ID;
    public $PROPETY_STREET;
    public $PROPERTY_SUBURB;
    public $PROPERTY_STATE;
    public $PROPERTY_PC;
	public $TYPE_NAME;
	public $LIST_PRICE;
	public $FEATURES = array();
	public $FEATURES_NAMES = array();
    private $_conn;

    function __construct($conn)
    {
        $this->_conn =$conn;
    }

    public function find_property_by_id($prop_no)
    {
        $sql = 'SELECT * FROM property p, property_type t
		WHERE t.type_id = p.property_type 
		AND property_id =' . $prop_no;
        $parse = oci_parse($this->_conn, $sql);
        if(!@oci_execute($parse)){
			return false;
		}

        $result = oci_fetch_assoc($parse);

        if($result)
        {
            $this->PROPERTY_ID = $result['PROPERTY_ID'];
            $this->PROPERTY_PC = $result['PROPERTY_PC'];
            $this->PROPERTY_STATE = $result['PROPERTY_STATE'];
            $this->PROPERTY_SUBURB = $result['PROPERTY_SUBURB'];
			$this->TYPE_NAME = $result['TYPE_NAME'];
			$this->PROPERTY_STREET = $result['PROPERTY_STREET'];
			$this->find_features();
            return true;
        }
        else
        {
            return false;
        }

    }
	
	public function find_features()
    {
        $sql = 'SELECT * FROM property_feature p, feature f
		WHERE p.FEATURE_ID = f.FEATURE_ID
		AND property_id =' . $this->PROPERTY_ID;
        $parse = oci_parse($this->_conn, $sql);
        if(!@oci_execute($parse)){
			return false;
		}

		
		$count = 0;
        while($row = oci_fetch_array($parse)){
			$this->FEATURES[$count] = $row["FEATURE_ID"];
			$this->FEATURES_NAMES[$count] = $row["FEATURE_NAME"];
			$count = $count + 1;
		}

    }
	
	public function getPrice()
	{
		$sql = 'SELECT l.LIST_PRICE FROM property p, property_listing l
		WHERE p.PROPERTY_ID = l.PL_ID
		AND p.property_id =' . $this->PROPERTY_ID;
        $parse = oci_parse($this->_conn, $sql);
        if(!@oci_execute($parse)){
			return false;
		}

		$row = oci_fetch_array($parse);
		if($row){
			$this->LIST_PRICE = $row["LIST_PRICE"];
		}
		else{
			return false;
		}
	}
	
	public function search($where)
    {
        $sql = "SELECT * FROM property p, property_type t";

        
        $whereClause = array();

        foreach($where as $key => $value)
        {
            $whereClause[] = 'UPPER('.$key.')' . " LIKE '%" . strtoupper($value) . "%'";
        }

       if(count($whereClause) > 0)
       {
           $sql .= " WHERE " . implode(' AND ', $whereClause);
       }
		$sql .= " AND p.PROPERTY_TYPE = t.TYPE_ID";
		
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
