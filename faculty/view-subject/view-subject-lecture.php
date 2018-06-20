<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if(!isset($_SESSION['fid'])){
    header("Location: ../../facultyLogin.php");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="../../bootstrap-4.1.1-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/style.css"/>
        <!-- jQuery library -->
        <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
         
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        
        <script>
            $(document).ready(function(){
               $("#btnSubmit").click(function(){
                   var semester = $("#semester").val();
                   $.ajax({
                       type: 'POST',
                       url: "ajax-show-lecture-table.php",
                       data: {semester : semester},
                       success: function(response){
                           $("#showTable").html(response);
                       }
                   });
                   return false;
               });  
            });
        </script>
        
        <div class="container">
            <?php
                require_once '../../master-layout/faculty/master-faculty-layout.php';
            ?>
            
            <div class="badge-light" style="margin-top: 0.5%;">
                <div class="text-center">
                    <h5>See Subject Allocation</h5>
                </div>
            </div>
            
            <div id="showlecturesubject" style="margin-top: 3%;" class="row">
                <div class="col-4"></div>
                <div class="col-8">    
                    <form>
                        <div class="row">
                            <div class="col-5">
                                <div class="form-group">
                                    <input class="form-control" id="semester" name="semester" placeholder="Semester"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-primary" id="btnSubmit" value="Show"/>
                            </div>
                        </div>
                    </form>    
                </div>
            </div>
            <div id="showTable"></div>
        </div>
    </body>
</html>
