<?php
include './WebServicesLibrary.php';
include './dbfunction.php';
include "dbfunctions.php";
include './config.php';
$EMAIL_ALREADY_EXISTS = "Email already exist.";
$action = $_GET['action'];
if (isset($action) && ($action === strval("getRegistered"))) {
    $WebserviceLibrary = new WebserviceLibrary(true);
    $SelectedParam = $WebserviceLibrary->getSelectedParam(array("Email"));
    $Email = $SelectedParam["Email"];
    $DbObj = new dbfunction();
    $DbObj->getProcedure("GetEmail", array($Email));
    $NumRows = $DbObj->getNumRows();
    if ($NumRows > 0) {
//$ResponseMessage,$KeyName = false, $sort = "",$ImageKeyName="",$SendEmail="",$msg="",$Code="",$status="")
        $DbObj1 = new dbfunction();//getUserDataByEmail//getFetchArray
        $DbObj1->getProcedure("getUserDataByEmail", array($Email));
        $checkValue = $DbObj1->getFetchArray();
        $WebserviceLibrary->getJsonResponse($checkValue, false, "", "", "", "Email already exist.", "P002", "false");
    } else {
        //$WebserviceLibrary->getSuccessMessage();
        $WebserviceLibrary->uploadImage("ProfileImage");

        $DbObj1 = new dbfunction();
        $checkValue = $DbObj1->getArrayData($WebserviceLibrary->ProcedureParam("getRegister"));
        $WebserviceLibrary->getJsonResponse($checkValue, false, "", "", "", "New user created.", "P001", "true");
    }
    unset($WebserviceLibrary, $DbObj1);
} elseif (isset($action) && ($action === strval("getCategory"))) {
    $WebserviceLibrary = new WebserviceLibrary();
    $Response = $WebserviceLibrary->getCategory();
    if ($Response === FALSE) {
        $WebserviceLibrary->getJsonResponse($Response, false, "", "", "", "Data not found", "P004", "false");
    } else {
        $WebserviceLibrary->getJsonResponse($Response, false, "", "", "", "Data found", "P003", "true");
    }
} elseif (isset($action) && ($action === strval("addToCart"))) {
    $WebserviceLibrary = new WebserviceLibrary();
    $DbObj1 = new dbfunction();
    $DbObj1->getArrayData($WebserviceLibrary->ProcedureParam("addToCart"));
    $WebserviceLibrary->getStaticJsonResponse("Item added to cart", "P005", "true");
}
?>