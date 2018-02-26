<?php
//auto form builder
session_start();
$error = array();

//type, currentvalue, name, label, placeholder, error msg
$feilds = array(
    array("text", "company", "company name","Ex: My Company, llc", "please enter a company name", "required"),
    array("text"),
);



function buildField($arr){
    echo '<label>';
    echo '<span>'.$arr[3].'</span>';
    echo '<input type="'.$arr[0].'" name="'.$arr[2].'" id="'.$arr[2].'" value="'.$arr[1].'"/>';
    echo '<div class="error">'.$arr[5].'</div>';
}