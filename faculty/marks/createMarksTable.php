<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$conn = mysqli_connect("localhost", "root", "", "college");
$dept_id = 16;
for($j=1;$j<=8;$j++){
    
    mysqli_autocommit($conn, FALSE);
    
    $subarray = array();
    
    $createTable = "CREATE TABLE sem".$j."_".$dept_id."(enrolment bigint(20) PRIMARY KEY,year int(11));";
    mysqli_query($conn, $createTable);
    
    $createTableremid = "CREATE TABLE sem".$j."_".$dept_id."_r (enrolment bigint(20) PRIMARY KEY,year int(11));";
    mysqli_query($conn, $createTableremid);

    $fetchSubject = "select subject_code from subject where semester=$j";
    $resultSub = mysqli_query($conn, $fetchSubject);
    
    if(mysqli_num_rows($resultSub)>0){
        while($row = mysqli_fetch_array($resultSub,MYSQLI_BOTH)){
            $subarray[] = $row;
        }
    }
    
    echo 'Processing...';
    
    $iserrorfree = FALSE;
    foreach ($subarray as $subcode){
        
            $query = "ALTER TABLE sem".$j."_".$dept_id." ADD COLUMN ".$subcode[0]."_m int(10);";
            
            if(mysqli_query($conn, $query)){
                $iserrorfree = TRUE;
            }else{
                echo mysqli_error($conn);
            }
            
            $query1 = "ALTER TABLE sem".$j."_".$dept_id." ADD COLUMN ".$subcode[0]."_v int(10);";
            
            if(mysqli_query($conn, $query1)){
                $iserrorfree = TRUE;
            }else{
                echo mysqli_error($conn);
            }
            
            $query2 = "ALTER TABLE sem".$j."_".$dept_id."_r ADD COLUMN ".$subcode[0]."_r int(10);";
            
            if(mysqli_query($conn, $query2)){
                $iserrorfree = TRUE;
            }else{
                echo mysqli_error($conn);
            }
    }
    
    if($iserrorfree){
        
    }else{
        mysqli_rollback($conn);
    }
}

