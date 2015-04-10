<?php

/*
    This class contains all the database related functions which is required to run a query
*/

class dbfunctions
{
    var $dbconnection;
    var $ressel;
    var $temp;

    /*
        This functions is a constructor of the class and will be executed on the object creation of this class.
        Arguments: -
    */

    function dbfunctions()
    {
        $this->temp = $dbconnection = mysql_connect(DATABASE_SERVER, DATABASE_USER, DATABASE_PASSWORD);
        if (!$dbconnection) {
            die("Error in establishing connection: " . mysql_error());
        } else {
            $dblink = mysql_select_db(DATABASE_NAME, $dbconnection);
        }
    }

    /*
        This functions is used for the select query.
        @$tablename = Table name
        @fieldlist = Field list
        @where = Where clause
        @orderby = Order by clause
        @groupby = Group by clause
        @limit = Limit for the query
        @echoquery = Print query for debugging.
    */

    function SelectQuery($tablename, $fieldlist, $where = '', $orderby = '', $groupby = '', $limit = '', $echoquery = 0)
    {
        $qrysel = "SELECT $fieldlist FROM $tablename " . ($where != "" ? " WHERE $where" : "") . " $groupby $orderby $limit";
        if ($echoquery == 1) {
            echo $qrysel;
        }
        $this->ressel = mysql_query($qrysel);
    }

    function Query($query)
    {

        $this->ressel = mysql_query($query);

    }

    function SimpleSelectQuery($selqry)
    {
        $qrysel = $selqry;
        $this->ressel = mysql_query($qrysel, $this->temp) or die(mysql_error());
    }

    /*
        This functions is used for get the number of rows on the current query.
    */
    function getNumRows()
    {
        $totalnumberofrows = mysql_num_rows($this->ressel);
        return $totalnumberofrows;
    }

    function GenerateSelectQuery($tablename, $fieldlist, $where = '', $orderby = '', $groupby = '', $limit = '', $echoquery = 0)
    {
        $qrysel = "SELECT $fieldlist FROM $tablename " . ($where != "" ? " WHERE $where" : "") . " $groupby $orderby $limit";
        return $qrysel;
    }

    /*
        This functions is used for get the number of rows on the current query.
    */
    function getFetchArray()
    {
        $returnarray = mysql_fetch_array($this->ressel, MYSQL_ASSOC);
        return $returnarray;
    }

    /*
        This functions is used for get the number of rows on the current query.
    */
    function getAffectedRows()
    {
        $affectedrows = mysql_affected_rows();
        return $affectedrows;
    }

    /*
        This functions is used for get the number of rows on the current query.
        @tablename = Table name
        @fieldsarray = Fields array with key and values - key = fieldname - value = value
    */
    function InsertQuery($tablename, $fieldsarray)
    {
        $qryins = "Insert into $tablename ";

        $allkeys = "(";
        $allvalues = "(";

        foreach ($fieldsarray as $key => $value) {
            $allkeys .= $key . ",";
            $allvalues .= "'" . addslashes($value) . "',";
        }
        $allkeys = substr($allkeys, 0, -1) . ")";
        $allvalues = substr($allvalues, 0, -1) . ")";

        $qryins .= $allkeys . " VALUES " . $allvalues;
        mysql_query($qryins) or die(mysql_error());
    }

    /*
        This functions is used for get the last inserted id from the insert query.
    */
    function getLastInsertedId()
    {
        $lastinsertid = mysql_insert_id();
        return $lastinsertid;
    }

    /*
        This functions is used for get the number of rows on the current query.
        @tablename = Table name
        @fieldsarray = Fields array with key and values - key = fieldname - value = value
    */
    function UpdateQuery($tablename, $fieldsarray, $where = '')
    {
        $qryupd = "Update $tablename set ";

        foreach ($fieldsarray as $key => $value) {
            $qryupd .= $key . "='" . mysql_real_escape_string($value) . "',";
        }
        $qryupd = substr($qryupd, 0, -1) . " " . ($where != "" ? "Where $where" : "");
        mysql_query($qryupd) or die(mysql_error());
    }

    function db_safe()
    {
        $arguments = func_get_args();
        $returnquery = $arguments[0];
        for ($i = 1; $i < count($arguments); $i++) {
            $returnquery = str_replace("%" . $i, mysql_real_escape_string($arguments[$i]), $returnquery);
        }
        return $returnquery;
    }

    function __destruct()
    {
        @mysql_close();
    }

    function DeleteQuery($tablename, $where = '')
    {
        $this->sql = "DELETE FROM  " . $tablename;

        if ($where != '') {
            $this->sql .= " WHERE " . $where . " ";
        }
        //echo $this->sql;echo"<br>";exit;
        $this->result = mysql_query($this->sql);
        return $this->result;
    }

}

?>