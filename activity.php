<div class="container px-4 px-lg-5 mt-5">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <div class="card-body">

            <?php 
                $activityId = $_GET['activity_id'];
                $activity = "SELECT * FROM activity WHERE activity_id = :activity_id";
                $stmt = $con -> prepare($activity);
                $stmt -> bindParam(":activity_id", $activityId);
                $stmt -> execute();
                $resultActivity = $stmt -> fetch();
            ?>


            <div class="text-center">
                <!-- Product name-->
                <h2 class="fw-bolder"><?php echo $resultActivity['activityName'];?></h2>
                <h5><?php echo $resultActivity['activityDetail'];?></h5>
            </div>

            <br>


            <?php
                //กลุ่มไลน์เข้าร่วมกิจกรรม
                /*
            <div class="text-center">
                <!-- Product name-->
                <h5 class="fw-bolder">เข้าร่วมกลุ่มไลน์ <?php echo $resultActivity['activityName'];?></h5>
                <?php 
                    if($resultActivity['activityGroup'] != ""){
                        echo "<img src='assets/activity/".$resultActivity['activityGroup']."'>";
                    }
                ?>
            </div>
            <?php
                */
            ?>

            <div class="text-center">
                <?php
                    if(isset($_SESSION['user_id'])){
                        echo "<a href='index.php?file_name=register_activity' type='submit' class='btn btn-primary'><span class='bi-people'></span> สมัครเข้าร่วมการแข่งขัน ".$resultActivity['activityName']."</a>";
                    }else{
                        echo "<a href='index.php?file_name=register' type='submit' class='btn btn-primary'><span class='bi-people'></span> สมัครเข้าร่วมการแข่งขัน ".$resultActivity['activityName']."</a>";
                    }
                ?>
                
            </div>

            <div class="text-right">
                <h5><a href="#bottom" type='submit' class='btn btn-success'>ผลการแข่งขัน <?php echo $resultActivity['activityName'];?></a></h5>
            </div>

            <?php 

                if($resultActivity['activityFile'] != ""){

            ?>

            <object data="assets/activity/<?php echo $resultActivity['activityFile'];?>" width="100%" height="1000px">
                <p>Unable to display PDF file. <a href="/uploads/media/default/0001/01/540cb75550adf33f281f29132dddd14fded85bfc.pdf">Download</a> instead.</p>
            </object>
            <a type='submit' class='btn btn-outline-dark' href="assets/activity/<?php echo $resultActivity['activityFile'];?>" download>Download</a>
            <?php
                }
            ?>

            <br>
            <br>
            <br>

            <div class="text-center" id="bottom">
                <!-- Product name-->
                <h4 class="fw-bolder">ผลการแข่งขัน <?php echo $resultActivity['activityName'];?></h4>
                    <?php 
                        $competitionResult = "SELECT * FROM competition INNER JOIN activity ON activity.activity_id = competition.activity_id INNER JOIN university ON university.university_id = competition.university_id WHERE activity.activity_id = :activity_id";
                        $stmt = $con -> prepare($competitionResult);
                        $stmt -> bindParam(":activity_id", $activityId);
                        $stmt -> execute();
                        if($stmt -> rowCount() != 0){
                    ?>
                        <table class="table table-striped table-hover">
                            <thead>
                              <tr>
                                <th>รางวัล</th>
                                <th>สังกัด/มหาวิทยาลัย</th>
                                <th>รายชื่อนักศึกษาที่ได้รับรางวัล</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $i = 1;
                                    while ($row = $stmt->fetch()) {
                                            if($i == 1){
                                                $color = "gold";
                                            }else if($i == 2){
                                                $color = "orange";
                                            }else if($i == 3){
                                                $color = "silver";
                                            }else{
                                                $color = "white";
                                            }
                                            echo "<tr>";
                                                //echo "<td align='center'><b><font color='$color'>".$row['competitionTitle']."</font></b></td>";
                                                echo "<td style='text-align: center;
        vertical-align: middle;'><a type='submit' class='btn btn-secondary'><b><font color='$color'>".$row['competitionTitle']."</font></b></a></td>";
                                                echo "<td style='text-align: center;
        vertical-align: middle;'>".$row['university_name']."</td>";
                                                $studentResult = $mysqli -> query("SELECT * FROM register_student INNER JOIN user ON user.user_id = register_student.user_id INNER JOIN university ON university.university_id = user.university_id WHERE user.university_id = '".$row['university_id']."' ");
                                                echo "<td align='center'>";
                                                $j = 1;
                                                while($rowStudent = $studentResult->fetch_assoc()){
                                                    echo $rowStudent['student_name']."<br>";
                                                    $j++;
                                                }
                                                echo "</td>";
                                            echo "</tr>";
                                        $i++;
                                    }
                                ?>
                            </tbody>
                        </table>
                    <?php 
                        }else{
                            echo "<br>
                            <img src='assets/img/progress.png' width='200px' height='200px'><br>
                            <font color='green'>อยู่ระหว่างประมวลผล</font>";
                        }
                    ?>


            </div>

        </div>

    </div>
</div>



<script type="text/javascript">
        $(document).ready(function() {
            //$(this).scrollTop(650);

        });
</script>