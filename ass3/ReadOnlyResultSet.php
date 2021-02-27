<?php
class ReadOnlyResultSet {
    // This member variable will hold the native result set
    private $_results;

    // Assign the native result set to an instance variable
    function __construct($results)
    {
        $this->_results = $results;
    }

    // Receives an instance of the DataObject we're working on
    function getNext($dataobject, $counter)
    {
        $row  = $this->_results[$counter];

        // Loop through the properties to set them from the current row
        foreach($row as $name=>$value)
        {
            $dataobject->$name = $value;
        }
		
        //var_dump(($dataobject));
        return $dataobject;
    }

    // Move the pointer back to the beginning of the result set
    function reset()
    {
        reset($this->results);
    }

    // Return the number of rows in the result set
    function rowCount()
    {
        $nrows = sizeof($this->_results);
        //echo "nrows is ".$nrows;
        return $nrows;
    }
}
?>
