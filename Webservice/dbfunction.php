<?php

/*
    This class contains all the database related functions which is required to run a query
*/

class dbfunction
{

    var $dbconnection1;
    var $ressel;

    /*
        This functions is a constructor of the class and will be executed on the object creation of this class.
        Arguments: -
    */

    function dbfunction()
    {
        $this->dbconnection1 = mysqli_connect(DATABASE_SERVER, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
        if (!$this->dbconnection1) {
            die("Error in establishing connection: " . mysqli_error());
        } else {

        }
    }

    function SelectQuery($tablename, $fieldlist, $where = '', $orderby = '', $groupby = '', $limit = '', $echoquery = 0)
    {
        $qrysel = "SELECT $fieldlist FROM $tablename " . ($where != "" ? " WHERE $where" : "") . " $groupby $orderby $limit";
        if ($echoquery == 1) {
            echo $qrysel;
        }
        $this->ressel = mysqli_query($this->dbconnection1, $qrysel) or die(mysqli_error($this->dbconnection1));
    }

    function getProcedure($procedure, $params = "")
    {
        $proce = "Call " . $procedure;
        $paran1 = "(";
        $paran2 = ")";
        $arrayVal = "";

        if (count($params) > 0) {
            if (is_array($params)) {
                foreach ($params as $key => $val) {
                    if ($arrayVal == "") {
                        $arrayVal = '"' . $val . '"';
                    } else {
                        $arrayVal .= ',"' . $val . '"';
                    }
                }
            }

            $getproce = $proce . $paran1 . $arrayVal . $paran2;
        } else {
            $getproce = $proce . $paran1 . $params . $paran2;
        }
        $this->ressel = mysqli_query($this->dbconnection1, $getproce);
        if (!$this->ressel) {
            die(mysqli_error($this->dbconnection1));
        }
    }

    function Query($query)
    {
        $this->ressel = mysqli_query($query);
    }

    function SimpleSelectQuery($selqry)
    {
        $qrysel = $selqry;
        $this->ressel = mysqli_query($this->dbconnection1, $qrysel) or die(mysqli_error($this->dbconnection1));

    }

    /*
        This functions is used for get the number of rows on the current query.
    */

    function getNumRows()
    {
        $totalnumberofrows = mysqli_num_rows($this->ressel);
        //echo '    come to getNumRows()';
        return $totalnumberofrows;
    }

    /*
        This functions is used for get the number of rows on the current query.
    */

    function getFetchArray()
    {
        $returnarray = mysqli_fetch_array($this->ressel, MYSQL_ASSOC);
        return $returnarray;
    }

    /*
        This functions is used for get the number of rows on the current query.
    */

    function getAffectedRows()
    {
        $affectedrows = mysqli_affected_rows($this->ressel);
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

        $lastinsertid = mysqli_insert_id($this->dbconnection1);
        return $lastinsertid;
    }

    /* function getLastInsertedId()
        {
        $lastinsertid = mysql_insert_id();
        return $lastinsertid;
    } */

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

    function getOutPutParamArrayData($Query, $OutPutParam = FALSE)
    {
        $this->SimpleSelectQuery("$Query");
        if ($OutPutParam === false) {
            $numRows = $this->getNumRows();
            if ($numRows > 0) {
                $ArrayData = array();
                foreach ($this->getFetchArray() as $key => $val) {
                    $ArrayData[$key] = $val;
                }
                return $ArrayData;
            } else {
                return FALSE;
            }
        } else {
            $this->SimpleSelectQuery("$OutPutParam");
            $ArrayData = array();
            $AllData = $this->getFetchArray();
            foreach ($AllData as $key => $val) {
                $ArrayData[$key] = $val;
            }
            return $ArrayData;
        }
    }

    function __destruct()
    {
        @mysqli_close();
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

    function getArrayData($Query, $OutPutParam = FALSE)
    {
        $this->SimpleSelectQuery("$Query");
        if ($OutPutParam === false) {
            $numRows = $this->getNumRows();
            if ($numRows > 0) {
                $ArrayData = array();
                foreach ($this->getFetchArray() as $key => $val) {
                    $ArrayData[$key] = $val;
                }
                return $ArrayData;
            } else {
                return FALSE;
            }
        } else {
            //            only for single row not for multiple row
            $this->SimpleSelectQuery("$OutPutParam");
            $ArrayData = array();
            $AllData = $this->getFetchArray();
            //            put the return int always first
            if (intval(current($AllData)) > 0) {
                foreach ($AllData as $key => $val) {
                    $ArrayData[$key] = $val;
                }
            } else {
                return FALSE;
            }
            return $ArrayData;
        }
    }

    function getCountryArrayData($Query, $DictionaryKey)
    {
        $this->SimpleSelectQuery("$Query");
        $numRows = $this->getNumRows();

        //echo $Query;
        $array[$DictionaryKey] = array();
        $objDBFunctions = new dbfunctions();
        if ($numRows > 0) {
            $i = 0;
            while ($countryData = $this->getFetchArray()) {
                $keyname = array_keys($countryData);
                foreach ($keyname as $key => $val) {
                    $array[$DictionaryKey][$i][$val] = trim($countryData[$val], "\n");
                }

                if ($DictionaryKey == "Category") {
                    //$array[$DictionaryKey][$i]['SubCategory']['id'] =$countryData['resturantID'];
                    $objDBFunctions->Query("select distinct(sc.`sub_category_name`),sc.`id`,sc.`sub_category_Photo` from categories c
							inner join sub_categories_master sc on (sc.`fk_category_id`=c.`id`)
							inner join subcategory_item_master si on (si.`fk_sub-categoty-id`=sc.`id`)
							inner join `foodItem_Resturant_Mapping` fr on (fr.`foodItemID`=si.`id`)
							where sc.`fk_category_id`=" . $countryData['id']);
                    $arr = array();
                    $arrt = array();
                    $j = 0;
                    while ($SubData = $objDBFunctions->getFetchArray()) {
                        $keyname1 = array_keys($SubData);

                        foreach ($keyname1 as $key1 => $val1) {
                            echo $SubData[$val1];
                            //$arr['SubCategory'][$val1]=trim($SubData[$val1],"\n");
                            $array[$DictionaryKey][$i]['SubCategory'][$val1] = trim($SubData[$val1], "\n");
                        }
                        //array_push($array[$DictionaryKey][$i],$arr);
                        //array_push($arrt,$arr);
                        //$array[$DictionaryKey][$i]=$arr;
                        $objDBFunctions->Query("select distinct(si.`ItemName`),si.`itemDescription`,frm.`price`,si.`id` from categories c
							inner join sub_categories_master sc on (sc.`fk_category_id`=c.`id`)
							inner join subcategory_item_master si on (si.`fk_sub-categoty-id`=sc.`id`)
							inner join fooditem_resturant_mapping frm on (frm.`foodItemID`=si.`id`)
							where si.`fk_sub-categoty-id`=" . $SubData['id']);
                        while ($SubItemData = $objDBFunctions->getFetchArray()) {
                            $keyname2 = array_keys($SubItemData);

                            foreach ($keyname2 as $key2 => $val2) {

                                $array[$DictionaryKey][$i]['SubCategory']['SubItem'][$val2] = trim($SubItemData[$val2], "\n");
                            }

                        }
                    }
                }


                $i++;
            }
            return $array;
        } else {
            return FALSE;
        }
    }

    function getTravelImagesArrayData($Query, $DictionaryKey)
    {
        $this->SimpleSelectQuery("$Query");
        $numRows = $this->getNumRows();
        $array[$DictionaryKey] = array();
        $arrays = array();
        if ($numRows > 0) {
            $i = 0;
            while ($countryData = $this->getFetchArray()) {
                $keyname = array_keys($countryData);
                // $array[$DictionaryKey]['TheatreDetails'][$countryData['TheatreId']]['MovieDetails'] = array();
                foreach ($keyname as $key => $val) {
                    // $array[$DictionaryKey][$val] = $countryData[$val];
                    $array[$DictionaryKey]['TheatreDetails'][$countryData['TheatreId']]['TheatreId'] = $countryData['TheatreId'];
                    $array[$DictionaryKey]['TheatreDetails'][$countryData['TheatreId']]['Latitude'] = $countryData['Latitude'];
                    $array[$DictionaryKey]['TheatreDetails'][$countryData['TheatreId']]['Longitude'] = $countryData['Longitude'];
                    $array[$DictionaryKey]['TheatreDetails'][$countryData['TheatreId']]['TheatreAddress'] = $countryData['TheatreAddress'];

                    $array[$DictionaryKey]['TheatreDetails'][$countryData['TheatreId']]['MovieDetails'][$i]['MovieName'] = $countryData['MovieName'];
                    /*$array[$DictionaryKey]['TheatreDetails'][$countryData['TheatreId']]['MovieDetails'][$countryData['TheatreId']][$i]['MovieUrl'] = $countryData['MovieUrl'];
                        $array[$DictionaryKey]['TheatreDetails'][$countryData['TheatreId']]['MovieDetails'][$countryData['TheatreId']][$i]['MovieDesc'] = $countryData['MovieDesc'];
                        $array[$DictionaryKey]['TheatreDetails'][$countryData['TheatreId']]['MovieDetails'][$countryData['TheatreId']][$i]['ReleaseDate'] = $countryData['ReleaseDate'];
                        $array[$DictionaryKey]['TheatreDetails'][$countryData['TheatreId']]['MovieDetails'][$countryData['TheatreId']][$i]['MovieId'] = $countryData['MovieId'];
                    $array[$DictionaryKey]['TheatreDetails'][$countryData['TheatreId']]['MovieDetails'][$countryData['TheatreId']][$i]['ShowTime'] = $countryData['ShowTime'];*/
                    // if(intval($countryData['TravelImagesId']) > 0)
                    // {
                    // $array[$DictionaryKey]['VisitedImages'][$countryData['TravelImagesId']]['TravelImagesId'] = $countryData['TravelImagesId'];
                    // $array[$DictionaryKey]['VisitedImages'][$countryData['TravelImagesId']]['TravelImages'] = $countryData['TravelImages'];
                    // }
                }
                $i++;
            }
            return $array;
        } else {
            return FALSE;
        }
    }
}

?>