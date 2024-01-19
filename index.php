<!DOCTYPE html>
<?php 
    session_start();
    include("db_connect.php");        
?>
<html lang="en">
    
    <head>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        
        
       
        <title>การสัมนาและการแข่งขันทักษะทางวิชาการ ด้านศิลปศาสตร์ 9 มทร.</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai&family=Prompt:wght@300&family=Sarabun:wght@200;300&display=swap" rel="stylesheet">


        <style type="text/css">
            body{
                font-family: 'Noto Sans Thai', sans-serif;
                font-family: 'Prompt', sans-serif;
                font-family: 'Sarabun', sans-serif;
            }
        </style>
        <!-- Sweetalert Css -->
        <!-- SweetAlert Plugin Js -->
        <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />
        <script src="plugins/sweetalert/sweetalert.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>
            document.addEventListener("contextmenu", e => e.preventDefault(), false);
        </script>

        

    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <?php
                include("menu.php");
            ?>
        </nav>
        <!-- Header-->
        <header class="py-6 text-center" >
            <img src="assets/img/banner.png" width="100%" style="box-shadow:  0 0 50px grey;">        
        </header>

        <!-- Section-->
        <section class="py-6">
            <?php 
                if(isset($_GET['file_name'])){
                    $file_name = $_GET['file_name'];
                    include("$file_name.php");
                }else{
                    include("main.php");
                }
            ?>
        </section>
        <br><br>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; การแข่งขันทักษะทางวิชาการศิลปศาสตร์ราชมงคลแห่งประเทศไทย ครั้งที่ 8 ชิงถ้วยพระราชทานสมเด็จพระกนิษฐาธิราชเจ้า กรมสมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมาร</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
