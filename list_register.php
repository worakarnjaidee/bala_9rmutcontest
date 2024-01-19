<div class="container px-4 px-lg-5 mt-5">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <div class="card-body">
            <br>
            <div class="text-center">
                <h2 class="fw-bolder">ตรวจสอบรายชื่อผู้สมัครในแต่ละกิจกรรม</h2>
                การแข่งขันทักษะทางวิชาการศิลปศาสตร์ราชมงคลแห่งประเทศไทย ครั้งที่ 8 ชิงถ้วยพระราชทานสมเด็จพระกนิษฐาธิราชเจ้า กรมสมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมาร
            </div>

            <br>
            <br>

            <div class="">
                
                    <div class="row">
                        <div class="col">
                            <label for=""><h5><b>เลือกมหาวิทลัย :</b></h5></label>
                            <form action="index.php?file_name=list_register" method="POST">
                                <select class="form-control" name="universityId" id="universityId" onchange="this.form.submit()">
                                    <option value="">-- เลือกมหาวิทยาลัย --</option>
                                    <?php 
                                        $result =  $con -> query("SELECT * FROM university");
                                        while ($row = $result->fetch()) {
                                            if(isset($_POST['universityId']) && $_POST['universityId'] == $row['university_id']){
                                                echo "<option selected value='".$row['university_id']."'>".$row['university_name']."</option>";
                                            }else{
                                                echo "<option value='".$row['university_id']."'>".$row['university_name']."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </form>
                        </div>
                    </div>
                    <br>

                
                    <div class="row">
                        <div class="col">
                            <?php 
                                if(isset($_POST['universityId'])){
                                    $universityId = $_POST['universityId'];

                                    $result =  $con -> query("SELECT * FROM activity");
                                    while ($row = $result->fetch()) {

                                        echo "<br><p><font color='blue'>".$row['activityName']." ".$row['activityDetail']." </font><p>";
                                        $activityId = $row['activity_id'];

                                        $listRegister = "SELECT * FROM register_student INNER JOIN user ON register_student.user_id = user.user_id WHERE register_student.activity_id = :activity_id AND user.university_id = :university_id" ;
                                        $stmt = $con -> prepare($listRegister);
                                        $stmt -> bindParam(":university_id", $universityId);
                                        $stmt -> bindParam(":activity_id", $activityId);
                                        $stmt -> execute();
                                        if($stmt -> rowCount() != 0){

                            ?>
                                        <table class="table table-striped">
                                          <thead>
                                            <tr>
                                              <th scope="col">ลำดับ</th>
                                              <th scope="col">ชื่อ-นามสกุล</th>
                                              <th scope="col">ชั้นปี</th>
                                              <th scope="col">หลักสูตร</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                           
                                            <?php 
                                                $i = 1; 
                                                while ($row = $stmt -> fetch()) {
                                                    echo "<tr>";
                                                        echo "<td width='10%'>".$i."</td>";
                                                        echo "<td width='40%'>".$row['student_name']."</td>";
                                                        echo "<td width='10%'>".$row['student_level']."</td>";
                                                        echo "<td width='40%'>".$row['student_course']."</td>";
                                                    echo "</tr>";
                                                    $i++;
                                                }
                                            ?>


                                          </tbody>
                                        </table>
                            <?php 

                                        }else{
                                            echo "ยังไม่มีข้อมูลการสมัคร";
                                            echo "<br><br><br>";
                                        }
                                    }
                                } 
                            
                            ?>
                        </div>
                    </div>

                    
                    <br>


                <br>
                                    
            </div>

        </div>

    </div>
</div>


<script type="text/javascript">
        $(document).ready(function() {

             $(this).scrollTop(600);
        });
</script>

