<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
if (isset($_SESSION['aid'])) {
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title></title>
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <link rel="stylesheet" href="bootstrap-4.1.1-dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
            <link rel="stylesheet" href="css/style.css"/>
            <!-- jQuery library -->
            <script src="node_modules/jquery/dist/jquery.min.js"></script>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> <!-- cdn google icons -->
            <!-- Popper JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

            <!-- Latest compiled JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

            <script>
                $(document).ready(function(){
                   $("#quotehere").append('<p>Loading...</p>');
                   $.getJSON("http://quotesondesign.com/wp-json/posts?filter[orderby]=rand&filter[posts_per_page]=1&callback=", function(a) {
                        $("#quotehere").empty();
                        $("#quotehere").append("<p>"+a[0].content + "</p><p>— <i>" + a[0].title + "</i></p>")
                    }); 
                });
            </script>
        </head>
        <body>
            <div class="container">
                <?php require_once './master-layout/admin/master-page-admin.php'; ?>
                
                <div class="row" style="margin-top: 3%;">
                    <div class="col text-center"><b>Daily Quote</b></div>                    
                </div>
                <div class="row">
                    <div class="col text-center">
                        <div>
                            <span id="quotehere"></span>
                        </div>
                    </div>
                </div>
            </div>
            
        </body>
    </html>
<?php
} else {
    header("Location: index.php");
}