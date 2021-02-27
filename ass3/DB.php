<?php
class DB
{
    private $_uname;
    private $_pword;
    private $_db;
    private $_conn;

    function __construct()
    {
        $this->setParams();
        $this->connDB();
    }

    public function setParams()
    {
        $this->_uname= 's11966939';
        $this->_pword ='monash00';
        $this->_db='fit2076';
    }

    public function get_conn()
    {
        return $this->_conn;
    }

    public function connDB()
    {
        $this->_conn = oci_connect($this->_uname, $this->_pword, $this->_db);
    }
}

?>
