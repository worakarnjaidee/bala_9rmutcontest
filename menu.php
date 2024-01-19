<?php
    $file_name = ""; 
    if(isset($_GET['file_name'])){
        $file_name = $_GET['file_name'];
    }
?>   

            <div class="container px-4 px-lg-5">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link <?php echo ($file_name == "") ? "active" : ""; ?>" aria-current="page" href="index.php">หน้าแรก</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link <?php echo ($file_name == "activity") ? "active" : ""; ?> dropdown-toggle " id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">กิจกรรม</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php 
                                    $result = $con -> query("SELECT * FROM activity");
                                    while ($row = $result->fetch()) {

                                        echo "<li><a class='dropdown-item' href='index.php?file_name=activity&activity_id=".$row['activity_id']."'>".$row['activityName']."</a></li>";
                                    }
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link <?php echo ($file_name == "program") ? "active" : ""; ?>" href="index.php?file_name=program" >สูจิบัตร</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo ($file_name == "accommodation") ? "active" : ""; ?>" href="index.php?file_name=accommodation" >ข้อมูลที่พัก</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo ($file_name == "travel") ? "active" : ""; ?>" href="index.php?file_name=travel" >สถานที่ท่องเที่ยว</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo ($file_name == "manual") ? "active" : ""; ?>" href="index.php?file_name=manual" >คู่มือการใช้งานระบบ</a></li>
                        <li class="nav-item"><a class="nav-link <?php echo ($file_name == "album") ? "active" : ""; ?>" href="index.php?file_name=album" >ภาพกิจกรรม</a></li>
                        <?php 
                            if(!isset($_SESSION['username'])){
                                if($file_name == "register"){
                                    echo '<li class="nav-item"><a class="nav-link active" href="index.php?file_name=register">ลงทะเบียนเข้าร่วมกิจกรรม</a></li>';
                                }else{
                                    echo '<li class="nav-item"><a class="nav-link" href="index.php?file_name=register">ลงทะเบียนเข้าร่วมกิจกรรม</a></li>';
                                }
                                
                            }else{
                                if($file_name == "register_activity"){
                                    echo '<li class="nav-item"><a class="nav-link active" href="index.php?file_name=register_activity">ลงทะเบียนเข้าร่วมกิจกรรม</a></li>';
                                    echo '<li class="nav-item"><a class="nav-link" href="user/logout.php"><font color="white"> ออกจากระบบ</font></a></li>';
                                }else{
                                    echo '<li class="nav-item"><a class="nav-link" href="index.php?file_name=register_activity">ลงทะเบียนเข้าร่วมกิจกรรม</a></li>';
                                    echo '<li class="nav-item"><a class="nav-link" href="user/logout.php"><font color="white"> ออกจากระบบ</font></a></li>';
                                }
                                
                            }
                        ?>
                        <li class="nav-item"><a class="nav-link <?php echo ($file_name == "list_register") ? "active" : ""; ?>" href="index.php?file_name=list_register" >ตรวจสอบรายชื่อผู้สมัคร</a></li>
                    </ul>

                    <form class="d-flex" action="#">
                        <a class="btn btn-outline-light" href="https://www.facebook.com/profile.php?id=61555195061478" target="_blank"> <i class="bi-facebook"></i></a>
                    </form>
                </div>
            </div>