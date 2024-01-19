<style type="text/css">
/* Absolute Center Spinner */
#spinner-div {
    display: none;
    position: fixed;
    z-index: 999;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    width: 50px;
    height: 50px;
}
/* Transparent Overlay */
#spinner-div:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255,255,255,0.5);
}
</style>

<?php
    if(!isset($_SESSION['username'])){
        echo "<META HTTP-EQUIV=Refresh content=0;URL=register.php>";  
    }else{
?>
<div class="container px-4 px-lg-5 mt-5">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <div class="card-body">
            <div class="row justify-content-md-center">
                <div class="col-md-auto">
                  <a href="index.php?file_name=register_activity" type="button" class="btn btn-primary btn-lg">ลงทะเบียนผู้เข้าร่วมกิจกรรม</a>
                </div>
                <div class="col-md-auto">
                    <a href="index.php?file_name=register_excecutive" type="button" class="btn btn-success btn-lg">ลงทะเบียนสำหรับผู้บริหาร</a>
                </div>
            </div>
            <br>
            <div class="text-center">
                <h2 class="fw-bolder">ลงทะเบียนผู้เข้าร่วมกิจกรรม</h2>
            </div>

            <br>
            <br>

            <div class="">
                    
                    <div class="row">
                        <div class="col">
                            <label for=""><h5><b>กิจกรรม :</b></h5></label>
                            <form action="index.php?file_name=register_activity" method="POST">
                                <select class="form-control" name="activity_id" id="activityId" onchange="this.form.submit()">
                                    <option value="">-- เลือกกิจกรรมที่ต้องการลงทะเบียน --</option>
                                <?php 
                                    $result =  $con -> query("SELECT * FROM activity");
                                    while ($row = $result->fetch()) {
                                        if(isset($_POST['activity_id']) && $_POST['activity_id'] == $row['activity_id']){
                                            echo "<option selected value='".$row['activity_id']."'>".$row['activityName']." ".$row['activityDetail']."</option>";
                                        }else{
                                            echo "<option value='".$row['activity_id']."'>".$row['activityName']." ".$row['activityDetail']."</option>";
                                        }
                                    }
                                ?>
                                </select>
                            </form>
                        </div>
                    </div>
                    <br>

                <form id="sendFormData" method="post" enctype="multipart/form-data">
                    <div class="row">

                        <?php
                            ////// จำนวนข้อมูลผู้สมัครในแต่ละกิจกรรม //////
                            $activity_id = "";
                            if(isset($_POST['activity_id'])){
                                $activity_id = $_POST['activity_id'];
                            } 
                            $getNumofActivityRegis = "SELECT numberOfRegisStudent, numberOfRegisTeacher 
                                FROM activity 
                                WHERE activity_id = :activity_id";
                            $stmt = $con -> prepare($getNumofActivityRegis);
                            $stmt -> bindParam(":activity_id", $activity_id);
                            $stmt -> execute();
                            $objGetNumofActivityRegis = $stmt -> fetch();

                            $numberOfRegisStudent = 0;
                            $numberOfRegisTeacher = 0;
                             ////// ตรวจสอบว่ามีข้อมูลหรือไม่ //////
                            if(isset($objGetNumofActivityRegis["numberOfRegisStudent"])){
                                $numberOfRegisStudent = $objGetNumofActivityRegis["numberOfRegisStudent"];
                                $numberOfRegisTeacher = $objGetNumofActivityRegis["numberOfRegisTeacher"];
                            }
                            

                            ///////////////////////////////////////
                        ?>


                        <label for=""><b><h5>ระบุนักศึกษาที่เข้าร่วมแข่งขัน <font color="red"><?php echo ($numberOfRegisStudent !=0) ? "(".$numberOfRegisStudent.")" : "" ; ?></font></b></h5></label><br><br>
                        <?php
                            $activity_id = "";
                            if(isset($_POST['activity_id'])){
                                $activity_id = "AND activity_id = '$_POST[activity_id]'";
                            } 
                            $result = $con -> query("SELECT * FROM register_student WHERE user_id = '$_SESSION[user_id]' $activity_id");
                            if($result -> rowCount() != 0){

                            }
                        ?>

                        <div class="col">                            
                          <label for="">ชื่อ-นามสกุลนักศึกษา<font color="red">*</font></label>
                          <input type="text" class="form-control" id="studentName" name="studentName" maxlength="100" placeholder="ชื่อ-นามสกุลนักศึกษา">
                        </div>
                        <div class="col">
                          <label for="">ชั้นปี<font color="red">*</font></label>
                          <input type="number" class="form-control" id="studentLevel" name="studentLevel" maxlength="50" placeholder="ชั้นปี">
                        </div>
                        <div class="col">
                          <label for="">หลักสูตร/สาขา<font color="red">*</font></label>
                          <input type="text" class="form-control" id="studentCourse" name="studentCourse" maxlength="150" placeholder="หลักสูตร/สาขา">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="">แนบสำเนาบัตรนักศึกษา/บัตรประจำตัวประชาชน (สำหรับบางกิจกรรมให้แนบผลการลงทะเบียนในภาคการศึกษาปัจจุบันด้วย) <font color="red">*[PDF]</font></label>
                            <input type="file" class="form-control" id="studentEvidence" name="studentEvidence" accept="application/pdf">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="">เลือกประเภทอาหาร<font color="red">*</font><font color="red"></font></label><br>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="studentFood" id="studentFood1" value="ปกติ" />
                                  <label class="form-check-label" for="studentFood1">ปกติ</label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="studentFood" id="studentFood2" value="ฮาลาล" />
                                  <label class="form-check-label" for="studentFood2">ฮาลาล</label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="studentFood" id="studentFood3" value="มังสวิรัติ" />
                                  <label class="form-check-label" for="studentFood3">มังสวิรัติ</label>
                                </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-3 regis-student">
                            <input type="hidden" id="userId" name="userId" value="<?php echo $_SESSION['user_id'];?>">                            
                            <button type="submit" class="btn btn-primary" id="addStudent"><span class="bi-plus"></span> เพิ่มรายชื่อผู้เข้าแข่งขัน</button>
                        </div>
                    </div>

                </form>
                    <br>




                    
                <!-------------------------------------- Option Answer --------------------------------------->

                    <div class="row">
                        <div class="col">
                            <?php 
                                if(isset($_POST['activity_id'])){
                                    $activity_id = $_POST['activity_id'];
                                    $activity = "SELECT * FROM activity WHERE activity_id = :activity_id";
                                    $stmt = $con -> prepare($activity);
                                    $stmt -> bindParam(":activity_id",$activity_id);
                                    $stmt -> execute();
                                    $resultActivity = $stmt -> fetch();

                                    if($resultActivity['activityOption'] == 1){

                                        $activityOption = "SELECT * FROM activity_option WHERE activity_id = :activity_id";
                                        $stmt = $con -> prepare($activityOption);
                                        $stmt -> bindParam(":activity_id",$activity_id);
                                        $stmt -> execute();
                                        $resultActivityOption = $stmt -> fetch();
                                        
                            ?>

                                        <label for=""><b><h5><?=$resultActivityOption['activityOptionDetail']?></b></h5></label><br><br>
                                        <div class="col">
                                          <?php
                                            $user_id = $_SESSION['user_id'];
                                            $activityOptionId = $resultActivityOption['activityOptionId'];
                                            $answerQuery = "SELECT * FROM activity_option_answer WHERE user_id = :user_id AND activityOptionId = :activityOptionId";
                                            $stmt = $con -> prepare($answerQuery);
                                            $stmt -> bindParam(":user_id", $user_id);
                                            $stmt -> bindParam(":activityOptionId", $activityOptionId);
                                            $stmt -> execute();
                                            if($stmt -> rowCount() != 0){
                                                $resultAnswer = $stmt -> fetch();
                                          ?>
                                          <input type="text" class="form-control" id="activityOptionAsnwer" name="activityOptionAsnwer" placeholder="<?=$resultActivityOption['activityOptionDetail']?>" value="<?=$resultAnswer['answer'];?>">

                                          <?php 
                                            }else{
                                          ?>
                                            <input type="text" class="form-control" id="activityOptionAsnwer" name="activityOptionAsnwer" placeholder="<?=$resultActivityOption['activityOptionDetail']?>">

                                          <?php 
                                            }
                                          ?>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-3">
                                                <input type="hidden" name="" id="activityOptionId" value="<?=$resultActivityOption['activityOptionId']?>">
                                                <input type="hidden" name="" id="user_id" value="<?=$_SESSION['user_id']?>">
                                                <button type="submit" class="btn btn-primary" id="addActivityOptionAnswer"><span class="bi-plus"></span> บันทึกข้อมูล</button>
                                            </div>
                                        </div>

                            <?php 
                                    }
                                }

                            ?>
                        </div>
                    </div>



                <!-------------------------------------- Option Answer --------------------------------------->



                    <div class="row">
                        <div class="col">
                            <?php
                                $activity_id = "";
                                if(isset($_POST['activity_id'])){                                    
                                    $activity_id = $_POST['activity_id'];
                                    $user_id = $_SESSION['user_id'];
                                    $result = "SELECT * FROM register_student WHERE user_id = :user_id AND activity_id = :activity_id";
                                    $stmt = $con -> prepare($result);
                                    $stmt -> bindParam(":user_id", $user_id);
                                    $stmt -> bindParam(":activity_id", $activity_id);
                                    $stmt -> execute();
                                    if($stmt -> rowCount() != 0){
                                ?>
                                        <table width="100%">
                                            <tr >
                                                <td align="right">
                                                    <a href="register/exportRegisterStudentPDF.php?activityId=<?php echo $_POST['activity_id'];?>&universityId=<?php echo $_SESSION['university_id'];?>" target="_blank" type="submit" class="btn btn-success" id="addStudent">
                                                    <span class="bi-files"></span> ดาวน์โหลดใบสมัครเข้าร่วมแข่งขัน</a></td>
                                            </tr>
                                        </table>

                                        <table class="table">
                                          <thead>                                    
                                            <tr>
                                              <th scope="col">ลำดับ</th>
                                              <th scope="col">ชื่อ-นามสกุล</th>
                                              <th scope="col">จัดการ</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                                $i = 1; 
                                                while ($row = $stmt -> fetch()) {
                                                    echo "<tr>";
                                                        echo "<td>".$i."</td>";
                                                        echo "<td>".$row['student_name']."</td>";
                                                        echo "<td>
                                                                <a type='button' target='_blank' href='register/fileupload/".$row['student_evidence']."' class='btn btn-primary btn-sm'><span class='bi-folder'></span></a>
                                                                <button type='button' class='btn btn-success btn-sm editRegisterStudent' data-bs-toggle='modal' data-bs-target='#exampleModal' value='".$row['register_id']."'><span class='bi-pencil'></span></button>
                                                                <button type='button' class='btn btn-danger btn-sm delRegisterStudent' value='".$row['register_id']."'><span class='bi-trash'></span></button> 
                                                        </td>";
                                                    echo "</tr>";
                                                    $i++;
                                                }
                                            ?>
                                          </tbody>
                                        </table>

                            <?php 
                                    }
                                }
                            ?>
                        </div>
                    </div>

                    <br><br>

                    <div class="row">
                        <label for=""><b><h5>ระบุอาจารย์ผู้ควบคุม/ประสานงาน <font color="red"><?php echo ($numberOfRegisTeacher !=0) ? "(".$numberOfRegisTeacher.")" : "" ; ?></font></b></h5></label><br><br>
                        <div class="col">                            
                          <label for="">ชื่อ-นามสกุล<font color="red">*</font></label>
                          <input type="text" class="form-control" id="teacherName" maxlength="100" placeholder="ชื่อ-นามสกุล">
                        </div>
                        <div class="col">
                          <label for="">ตำแหน่ง<font color="red">*</font></label>
                          <input type="text" class="form-control" id="teacherPosition" maxlength="100" placeholder="ตำแหน่ง">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">                            
                          <label for="">โทรศัพท์<font color="red">*</font></label>
                          <input type="number" class="form-control" id="teacherTel" placeholder="ระบุเบอร์โทรศัพท์ 10 หลัก ไม่ต้องมี -">
                        </div>
                        <div class="col">
                          <label for="">อีเมล์<font color="red">*</font></label>
                          <input type="text" class="form-control" id="teacherEmail" maxlength="100" placeholder="อีเมล์">
                        </div>
                    </div> 
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="">เลือกประเภทอาหาร<font color="red">*</font><font color="red"></font></label><br>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="teacherFood" id="teacherFood1" value="ปกติ" />
                                  <label class="form-check-label" for="teacherFood1">ปกติ</label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="teacherFood" id="teacherFood2" value="ฮาลาล" />
                                  <label class="form-check-label" for="teacherFood2">ฮาลาล</label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="teacherFood" id="teacherFood3" value="มังสวิรัติ" />
                                  <label class="form-check-label" for="teacherFood3">มังสวิรัติ</label>
                                </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-3">
                            <button type="submit" class="btn btn-primary" id="addTeacher"><span class="bi-plus"></span> เพิ่มรายชื่ออาจารย์ผู้ควบคุม</button>
                        </div>
                    </div>
                                        <div class="row">
                        <div class="col">
                            <?php
                                $activity_id = "";
                                if(isset($_POST['activity_id'])){
                                    $activity_id = $_POST['activity_id'];
                                    $user_id = $_SESSION['user_id'];
                                    $result = "SELECT * FROM register_teacher WHERE user_id = :user_id AND activity_id = :activity_id";
                                    $stmt = $con -> prepare($result);
                                    $stmt -> bindParam(":user_id", $user_id);
                                    $stmt -> bindParam(":activity_id", $activity_id);
                                    $stmt -> execute();
                                    if($stmt -> rowCount() != 0){
                                ?>
                                        <table class="table">
                                          <thead>
                                            <tr>
                                              <th scope="col">ลำดับ</th>
                                              <th scope="col">ชื่อ-นามสกุล</th>
                                              <th scope="col">จัดการ</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                                $i = 1; 
                                                while ($row = $stmt->fetch()) {
                                                    echo "<tr>";
                                                        echo "<td>".$i."</td>";
                                                        echo "<td>".$row['teacher_name']."</td>";
                                                        echo "<td>
                                                                <button type='button' class='btn btn-success btn-sm editTeacher' data-bs-toggle='modal' data-bs-target='#editTeacher' value='".$row['teacher_id']."'><span class='bi-pencil'></span></button>
                                                                <button type='button' class='btn btn-danger btn-sm delRegisterTeacher' value='".$row['teacher_id']."'><span class='bi-trash'></span></button> 
                                                        </td>";
                                                    echo "</tr>";
                                                    $i++;
                                                }
                                            ?>
                                          </tbody>
                                        </table>

                            <?php 
                                    }
                                }
                            ?>
                        </div>
                    </div>                   
            </div>

        </div>

    </div>
</div>

<?php
}
?>


<script type="text/javascript">
        $(document).ready(function() {
             $(this).scrollTop(600);
            //////// เพิ่มข้อมูลผู้เข้าแข่งขัน /////////////
            //////////////////////////////////////
            $("#sendFormData").on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                var activityId = $("#activityId").val();

                formData.append('activityId', activityId);

                if(activityId == ""){
                    swal("กรุณาเลือกกิจกรรม!", "", "warning");
                }else{
                    
                    //โหลดข้อมูลแสดง
                    $('#spinner-div').show();

                    $.ajax({
                        type: 'POST',
                        url: 'register/register_student.php',
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData:false,
                        dataType: "json",
                        success: function(data){
                            if(data.status == 'ok'){
                                $('#spinner-div').hide();
                                swal({
                                  title: "บันทึกข้อมูลสำเร็จ!", 
                                  text: "Success", 
                                  type: "success"
                                },function(){
                                    location.reload();
                                });
                            }else if(data.status == 'empty'){
                                $('#spinner-div').hide();     
                                swal("กรุณากรอกข้อมูลให้ครบ!", "", "warning");
                            }else{
                                $('#spinner-div').hide();
                                swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาอัปโหลดไฟล์", "", "warning");
                                
                            }
                        },
                        complete: function(){
                            //alert("Data uploaded successfully.");
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert("เกิดข้อผิดพลาด ไม่สามารถบันทึกข้อมูลได้.");
                       } 
                    });

                }

            });

        

            /////////// เพิ่มข้อมูล Option ///////////////
            /////////////////////////////////////////////
            $("#addActivityOptionAnswer").on("click", function(e){

                var activityOptionId = $("#activityOptionId").val();
                var answer = $("#activityOptionAsnwer").val();
                var user_id = $("#user_id").val();

                if(answer == ""){
                    swal("กรุณากรอกข้อมูลให้ครบ!", "", "warning");
                }else{                    

                    $.ajax({
                        type: 'POST',
                        url: 'register/add_option_answer.php',
                        dataType: "json",
                        data: {
                          user_id: user_id,
                          answer: answer,
                          activityOptionId: activityOptionId,
                        },
                        success: function (data) {
                            if(data.status == 'ok'){
                                swal({
                                  title: "บันทึกข้อมูลสำเร็จ!", 
                                  text: "Success", 
                                  type: "success"
                                },function(){ 
                                    location.reload();
                                });
                              }else{
                                swal("ไม่สามารถบันทึกข้อมูลได้ในขณะนี้!", "Fail", "error");
                              }
                        },
                        error: function (data) {
                          swal("ไม่สามารถบันทึกข้อมูลได้ในขณะนี้!", "Fail", "error");
                        }
                    });
                }
            });


        
            /////////// เพิ่มข้อมูลอาจารย์ผู้ควบคุม ///////////////
            /////////////////////////////////////////////
            $("#addTeacher").on("click", function(e){

                var activityId = $("#activityId").val();
                var teacherName = $("#teacherName").val();
                var teacherPosition = $("#teacherPosition").val();
                var teacherTel = $("#teacherTel").val();
                var teacherEmail = $("#teacherEmail").val();
                var teacherFood = "";
                var userId = $("#userId").val();

                /* เช็คว่าประเภทอาหารใดถูกเลือก และนำค่ามาเก็บในตัวแปร */
                if($('#teacherFood1').is(':checked') ){
                    teacherFood = "ปกติ";
                }else if($('#teacherFood2').is(':checked')){
                    teacherFood = "ฮาลาล";
                }else if($('#teacherFood3').is(':checked')){
                    teacherFood = "มังสวิรัติ";
                }
                
                if(activityId == ""){
                    swal("กรุณาเลือกกิจกรรม!", "", "warning");
                }else if(teacherName == "" || teacherPosition == "" || teacherTel == "" || teacherEmail == "" || teacherFood == ""){
                    swal("กรุณากรอกข้อมูลให้ครบ!", "", "warning");
                }else{
                    //โหลดข้อมูลแสดง
                    $('#spinner-div').show();
                    $.ajax({
                        type: 'POST',
                        url: 'register/register_teacher.php',
                        dataType: "json",
                        data: {
                          teacherName: teacherName,
                          teacherPosition: teacherPosition,
                          teacherTel: teacherTel,
                          teacherEmail: teacherEmail,
                          teacherFood: teacherFood,
                          activityId: activityId,                          
                          userId: userId
                        },
                        success: function (data) {
                            if(data.status == 'ok'){
                                $('#spinner-div').hide();
                                swal({
                                  title: "บันทึกข้อมูลสำเร็จ!", 
                                  text: "Success", 
                                  type: "success"
                                },function(){ 
                                    location.reload();
                                });
                              }else{
                                $('#spinner-div').hide();
                                swal("ไม่สามารถบันทึกข้อมูลได้ในขณะนี้!", "Fail", "error");
                              }
                        },
                        error: function (data) {
                            $('#spinner-div').hide();
                            swal("ไม่สามารถบันทึกข้อมูลได้ในขณะนี้!", "Fail", "error");
                        }
                    });
                }
            });


        //// แก้ไขข้อมูลนักศึกษา Pop Up ////
        //////////////////////////////
        $(".btn.btn-success.btn-sm.editRegisterStudent").on("click", function(e){
            var register_id = $(this).val();
            sessionStorage.setItem('register_id', register_id);            

              $.ajax({
                type: 'POST',
                dataType: "json",
                url: 'register/select_register_student.php',
                data: {
                  register_id: register_id,
                },
                success: function (data) {
                  if(data.status == 'ok'){
                    $("#editRegisterName").val(data.result.student_name);
                    $("#editRegisterLevel").val(data.result.student_level);
                    $("#editRegisterCourse").val(data.result.student_course);
                    if(data.result.student_food == "ปกติ"){
                        $("#editStudentFood1").prop("checked", true);
                    }else if(data.result.student_food == "ฮาลาล"){
                        $("#editStudentFood2").prop("checked", true);
                    }else if(data.result.student_food == "มังสวิรัติ"){
                        $("#editStudentFood3").prop("checked", true);
                    }
                  }else{
                    swal("ไม่สามารถแสดงข้อมูลได้ในขณะนี้!", "Fail", "error");
                  }
                  
                },
                error: function (data) {
                  swal("ไม่สามารถแสดงข้อมูลได้ในขณะนี้!", "Fail", "error");
                }
             });               
        });


            //////// แก้ไขข้อมูลผู้เข้าแข่งขัน /////////////
            //////////////////////////////////////
            $("#sendFormEditStudent").on('submit', function(e){

                e.preventDefault();
                var formData = new FormData(this);
                var register_id = sessionStorage.getItem('register_id');
                formData.append('register_id', register_id);

                $.ajax({
                    type: 'POST',
                    url: 'register/update_register_student.php',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData:false,
                    dataType: "json",
                    success: function(data){
                        if(data.status == 'ok'){
                            swal({
                              title: "บันทึกข้อมูลสำเร็จ!", 
                              text: "Success", 
                              type: "success"
                            },function(){ 
                              location.reload();
                            });
                        }else if(data.status == 'empty'){
                            swal("กรุณากรอกข้อมูลให้ครบถ้วน!", "", "warning");
                        }else{
                            swal("ไม่สามารถบันทึกข้อมูลได้ กรุณาอัปโหลดไฟล์", "", "warning");
                        }
                    },
                    complete: function(){
                        //alert("Data uploaded successfully.");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert("Some problem occurred, please try again.");
                   } 
                });
            });



        //// แก้ไขข้อมูลอาจารย์ผู้ควบคุม Pop Up ////
        //////////////////////////////
        $(".btn.btn-success.btn-sm.editTeacher").on("click", function(e){
            var teacher_id = $(this).val();
            sessionStorage.setItem('teacher_id', teacher_id);            

              $.ajax({
                type: 'POST',
                dataType: "json",
                url: 'register/select_register_teacher.php',
                data: {
                  teacher_id: teacher_id,
                },
                success: function (data) {
                  if(data.status == 'ok'){
                    $("#editTeacherName").val(data.result.teacher_name);
                    $("#editTeacherPosition").val(data.result.teacher_position);
                    $("#editTeacherTel").val(data.result.tel);
                    $("#editTeacherEmail").val(data.result.email);
                    if(data.result.teacher_food == "ปกติ"){
                        $("#editTeacherFood1").prop("checked", true);
                    }else if(data.result.teacher_food == "ฮาลาล"){
                        $("#editTeacherFood2").prop("checked", true);
                    }else if(data.result.teacher_food == "มังสวิรัติ"){
                        $("#editTeacherFood3").prop("checked", true);
                    }
                  }else{
                    swal("ไม่สามารถแสดงข้อมูลได้ในขณะนี้!", "Fail", "error");
                  }
                  
                },
                error: function (data) {
                  swal("ไม่สามารถแสดงข้อมูลได้ในขณะนี้!", "Fail", "error");
                }
             });               
        });

        

        $(".btn.btn-success.updateTeacher").on("click", function(e){

            var teacher_id = sessionStorage.getItem('teacher_id');
            var teacher_name = $("#editTeacherName").val();
            var teacher_position = $("#editTeacherPosition").val();
            var tel = $("#editTeacherTel").val();
            var email = $("#editTeacherEmail").val();

            /* เช็คว่าประเภทอาหารใดถูกเลือก และนำค่ามาเก็บในตัวแปร */
            if($('#editTeacherFood1').is(':checked') ){
                var teacher_food = $("#editTeacherFood1").val();
            }else if($('#editTeacherFood2').is(':checked')){
                var teacher_food = $("#editTeacherFood2").val();
            }else if($('#editTeacherFood3').is(':checked')){
                var teacher_food = $("#editTeacherFood3").val();
            }

            if(teacher_name == "" || teacher_position == "" || tel == "" || email == "" || teacher_food == ""){
                swal("กรุณากรอกข้อมูลให้ครบถ้วน!", "", "warning");
            }else{

                $.ajax({
                    type: 'POST',
                    dataType: "json",
                    url: 'register/update_register_teacher.php',
                    data: {
                      teacher_id: teacher_id,
                      teacher_name: teacher_name,
                      teacher_position: teacher_position,
                      teacher_food: teacher_food,
                      tel: tel,
                      email: email,
                    },
                    success: function (data) {
                      if(data.status == 'ok'){
                            swal({
                                title: "บันทึกข้อมูลสำเร็จ!", 
                                text: "Success", 
                                type: "success"
                                },function(){ 
                                location.reload();
                            });                       
                      }else{
                        swal("ไม่สามารถแก้ไขข้อมูลได้ในขณะนี้", "Fail", "error");
                      }
                      
                    },
                    error: function (data) {
                      swal("ไม่สามารถแก้ไขข้อมูลได้ในขณะนี้", "Fail", "error");
                    }
                 });    
                }
           
        });


        //// ลบข้อมูลนักศึกษา ////
        ////////////////
        $(".btn.btn-danger.btn-sm.delRegisterStudent").on("click", function(e){            
            e.preventDefault();
            var register_id = $(this).val();
              var data = $(this).serialize();
              swal({
                title: "ยืนยันการลบข้อมูล!",
                text: "ต้องการลบข้อมูลหรือไม่?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: false,
                closeOnCancel: false
              },
                function (isConfirm) {
                  if (isConfirm) {
                    $.ajax({
                      type: 'POST',
                      dataType: "json",
                      url: 'register/delete_student.php',
                      data: {
                        register_id: register_id,
                      },
                      success: function (data) {
                        if(data.status == 'ok'){
                          swal({
                            title: "ลบข้อมูลสำเร็จ!", 
                            text: "Success", 
                            type: "success"
                          },function(){ 
                            location.reload();
                          });
                        }else{
                          swal("ไม่สามารถลบข้อมูลได้ในขณะนี้!", "Fail", "error");
                        }

                      },
                      error: function (data) {
                        swal("ไม่สามารถลบข้อมูลได้ในขณะนี้!", "Fail", "error");
                      }
                    });
                  } else {
                    swal("ยกเลิก", "ยกเลิกการลบข้อมูล", "error");
                  }
                });
              return false;
          });



        //// ลบข้อมูลอาจารย์ผู้ควบคุม ////
        ///////////////////////////
        $(".btn.btn-danger.btn-sm.delRegisterTeacher").on("click", function(e){            
            e.preventDefault();
            var teacher_id = $(this).val();
              var data = $(this).serialize();
              swal({
                title: "ยืนยันการลบข้อมูล!",
                text: "ต้องการลบข้อมูลหรือไม่?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: false,
                closeOnCancel: false
              },
                function (isConfirm) {
                  if (isConfirm) {
                    $.ajax({
                      type: 'POST',
                      dataType: "json",
                      url: 'register/delete_teacher.php',
                      data: {
                        teacher_id: teacher_id,
                      },
                      success: function (data) {
                        if(data.status == 'ok'){
                          swal({
                            title: "ลบข้อมูลสำเร็จ!", 
                            text: "Success", 
                            type: "success"
                          },function(){ 
                            location.reload();
                          });
                        }else{
                          swal("ไม่สามารถลบข้อมูลได้ในขณะนี้!", "Fail", "error");
                        }

                      },
                      error: function (data) {
                        swal("ไม่สามารถลบข้อมูลได้ในขณะนี้!", "Fail", "error");
                      }
                    });
                  } else {
                    swal("ยกเลิก", "ยกเลิกการลบข้อมูล", "error");
                  }
                });
              return false;
          });

        });
</script>




<!---------------------------------------------------- แก้ไขข้อมูลผู้เข้าแข่งขัน------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle" align="center">แก้ไขข้อมูลผู้เข้าแข่งขัน</h5>
      </div>
      <form id="sendFormEditStudent" method="post" enctype="multipart/form-data">
      <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>*ชื่อ-นามสกุลนักศึกษา</label>
                                            <input type="text" class="form-control" name="editRegisterName" id="editRegisterName" placeholder="ชื่อ-นามสกุลนักศึกษา" maxlength="100" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>*ชั้นปี</label>
                                            <input type="text" class="form-control" name="editRegisterLevel" id="editRegisterLevel" placeholder="ชั้นปี" maxlength="50" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>*หลักสูตร/สาขา</label>
                                            <input type="text" class="form-control" name="editRegisterCourse" id="editRegisterCourse" maxlength="150" placeholder="หลักสูตร/สาขา" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>*แนบสำเนาบัตรนักศึกษา/บัตรประจำตัวประชาชน</label>
                                            <input type="file" class="form-control" id="editRegisterEvidence" name="editRegisterEvidence" accept="application/pdf">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="form-line">
                                                <label for="">*เลือกประเภทอาหาร</font></label><br>
                                                    <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="editStudentFood" id="editStudentFood1" value="ปกติ" />
                                                      <label class="form-check-label" for="editStudentFood1">ปกติ</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="editStudentFood" id="editStudentFood2" value="ฮาลาล" />
                                                      <label class="form-check-label" for="editStudentFood2">ฮาลาล</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="editStudentFood" id="editStudentFood3" value="มังสวิรัติ" />
                                                      <label class="form-check-label" for="editStudentFood3">มังสวิรัติ</label>
                                                    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
      </div>
      <div class="modal-footer">        
        <button type="submit" class="btn btn-success">แก้ไข</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </form>
    </div>
  </div>
</div>




<!---------------------------------------------------- แก้ไขข้อมูลอาจารย์ผู้ควบคุม------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>

<div class="modal fade" id="editTeacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle" align="center">แก้ไขข้อมูลอาจารย์ผู้ควบคุม</h5>
      </div>
      <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>*ชื่อ-นามสกุล</label>
                                            <input type="text" class="form-control" name="editTeacherName" id="editTeacherName" placeholder="ชื่อ-นามสกุล" maxlength="100" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>*ตำแหน่ง</label>
                                            <input type="text" class="form-control" name="editTeacherPosition" id="editTeacherPosition" placeholder="ตำแหน่ง" maxlength="100" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>*โทรศัพท์</label>
                                            <input type="number" class="form-control" name="editTeacherTel" id="editTeacherTel" placeholder="โทรศัพท์" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label>*อีเมล์</label>
                                            <input type="email" class="form-control" name="editTeacherEmail" id="editTeacherEmail" placeholder="อีเมล์" maxlength="100" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label for="">*เลือกประเภทอาหาร</font></label><br>
                                                    <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="editTeacherFood" id="editTeacherFood1" value="ปกติ" />
                                                      <label class="form-check-label" for="editTeacherFood1">ปกติ</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="editTeacherFood" id="editTeacherFood2" value="ฮาลาล" />
                                                      <label class="form-check-label" for="editTeacherFood2">ฮาลาล</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="editTeacherFood" id="editTeacherFood3" value="มังสวิรัติ" />
                                                      <label class="form-check-label" for="editTeacherFood3">มังสวิรัติ</label>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
      </div>
      <div class="modal-footer">        
        <button type="submit" class="btn btn-success updateTeacher">แก้ไข</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>


<div id="spinner-div" class="pt-5">
    <div class="spinner-border text-primary" role="status">
    </div>
</div>

