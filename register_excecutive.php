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
                <h2 class="fw-bolder">ลงทะเบียนสำหรับผู้บริหาร</h2>
            </div>

            <br>
            <br>

            <div class="">
                <form id="sendFormData" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col">
                            <label for=""><h5><b>ตำแหน่ง :</b></h5></label>
                                <select class="form-control" name="executivePosition">
                                    <option value="">-- ระบุตำแหน่ง --</option>
                                    <option value="คณบดี">คณบดี</option>
                                    <option value="รองคณบดี">รองคณบดี</option>
                                    <option value="ผู้ช่วยคณบดี">ผู้ช่วยคณบดี</option>
                                    <option value="บุคลากรสายวิชาการ">บุคลากรสายวิชาการ</option>
                                    <option value="บุคลากรสายสนับสนุน">บุคลากรสายสนับสนุน</option>
                                </select>
                        </div>
                    </div>
                    <br>

                
                    <div class="row">
                        <div class="col">
                          <label for="">คำนำหน้า<font color="red">*</font></label>
                          <select class="form-control" name="executiveTitleName">
                                <option value="">-- ระบุคำนำหน้า --</option>
                                <option value="นาย">นาย</option>
                                <option value="นาง">นาง</option>
                                <option value="นางสาว">นางสาว</option>
                                <option value="ดร.">ดร.</option>
                                <option value="ผศ.">ผศ.</option>
                                <option value="ผศ.ดร.">ผศ.ดร.</option>
                                <option value="รศ.">รศ.</option>
                                <option value="รศ.ดร.">รศ.ดร.</option>
                                <option value="ศ.">ศ.</option>
                                <option value="ศ.ดร.">ศ.ดร.</option>
                        </select>
                        </div>
                        <div class="col">                            
                          <label for="">ชื่อ-นามสกุล<font color="red">*</font></label>
                          <input type="text" class="form-control" name="executiveName" placeholder="ระบุชื่อ-นามสกุล">
                        </div>
                        <div class="col">                            
                          <label for="">เบอร์โทรศัพท์<font color="red">*</font></label>
                          <input type="text" class="form-control" name="executiveTel" maxlength="10" placeholder="ระบุเบอร์โทรศัพท์ 10 หลัก ไม่ต้องมี -">
                        </div>
                        
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="">เลือกประเภทอาหาร<font color="red">*</font><font color="red"></font></label><br>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="executiveFood" value="ปกติ" />
                                  <label class="form-check-label" for="studentFood1">ปกติ</label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="executiveFood" value="ฮาลาล" />
                                  <label class="form-check-label" for="studentFood2">ฮาลาล</label>
                                </div>

                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="executiveFood" value="มังสวิรัติ" />
                                  <label class="form-check-label" for="studentFood3">มังสวิรัติ</label>
                                </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-3">
                            <input type="hidden" id="userId" name="userId" value="<?php echo $_SESSION['user_id'];?>">
                            <button type="submit" class="btn btn-primary" id="addStudent"><span class="bi-plus"></span> เพิ่มรายชื่อผู้บริหาร</button>
                        </div>
                    </div>

                </form>
                <br><br>
                    <div class="row">
                        <div class="col">
                            <?php
                                    $user_id = $_SESSION['user_id'];
                                    $sql = "SELECT * FROM executive WHERE user_id = :user_id";
                                    $stmt = $con -> prepare($sql);
                                    $stmt -> bindParam(":user_id", $user_id);
                                    $stmt -> execute();                                    
                                    if($stmt -> rowCount() != 0){
                                ?>

                                        <table class="table">
                                          <thead>                                    
                                            <tr>
                                              <th scope="col">ลำดับ</th>
                                              <th scope="col">ตำแหน่ง</th>
                                              <th scope="col">ชื่อ-นามสกุล</th>
                                              <th scope="col">เบอร์โทรศัพท์</th>
                                              <th scope="col">จัดการ</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php
                                                $i = 1; 
                                                while ($row = $stmt->fetch()) {
                                                    echo "<tr>";
                                                        echo "<td>".$i."</td>";
                                                        echo "<td>".$row['executivePosition']."</td>";
                                                        echo "<td>".$row['executiveTitleName']." ".$row['executiveName']."</td>";
                                                        echo "<td>".$row['executiveTel']."</td>";
                                                        echo "<td>
                                                                
                                                                <button type='button' class='btn btn-success btn-sm editExecutive' data-bs-toggle='modal' data-bs-target='#exampleModal' value='".$row['executiveId']."'><span class='bi-pencil'></span></button>
                                                                <button type='button' class='btn btn-danger btn-sm delExecutive' value='".$row['executiveId']."'><span class='bi-trash'></span></button> 
                                                        </td>";
                                                    echo "</tr>";
                                                    $i++;
                                                }
                                            ?>
                                          </tbody>
                                        </table>

                            <?php 
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

            //////// เพิ่มข้อมูลผู้บริหาร /////////////
            //////////////////////////////////////
            $("#sendFormData").on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: 'register/register_executive.php',
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
                            swal("กรุณากรอกข้อมูลให้ครบ!", "", "warning");
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




        //// แก้ไขข้อมูลผู้บริหาร Pop Up ////
        //////////////////////////////
        $(".btn.btn-success.btn-sm.editExecutive").on("click", function(e){
            var executiveId = $(this).val();
            sessionStorage.setItem('executiveId', executiveId);            

              $.ajax({
                type: 'POST',
                dataType: "json",
                url: 'register/select_executive.php',
                data: {
                  executiveId: executiveId,
                },
                success: function (data) {
                  if(data.status == 'ok'){
                    $("#executivePosition").val(data.result.executivePosition);
                    $("#executiveTitleName").val(data.result.executiveTitleName);
                    
                    $("#executiveName").val(data.result.executiveName);
                    $("#executiveTel").val(data.result.executiveTel);
                    
                    if(data.result.executiveFood == "ปกติ"){
                        $("#executiveFood1").prop("checked", true);
                    }else if(data.result.executiveFood == "ฮาลาล"){
                        $("#executiveFood2").prop("checked", true);
                    }else if(data.result.executiveFood == "มังสวิรัติ"){
                        $("#executiveFood3").prop("checked", true);
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


            //////// แก้ไขข้อมูลผู้บริหาร /////////////
            //////////////////////////////////////
            $("#sendFormEditStudent").on('submit', function(e){

                e.preventDefault();
                var formData = new FormData(this);
                var executiveId = sessionStorage.getItem('executiveId');
                formData.append('executiveId', executiveId);

                $.ajax({
                    type: 'POST',
                    url: 'register/update_executive.php',
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
                            swal("ไม่สามารถบันทึกข้อมูลได้ ", "", "warning");
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




        //// ลบข้อมูลผู้บริหาร ////
        ////////////////
        $(".btn.btn-danger.btn-sm.delExecutive").on("click", function(e){            
            e.preventDefault();
            var executiveId = $(this).val();
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
                      url: 'register/delete_executive.php',
                      data: {
                        executiveId: executiveId,
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




<!---------------------------------------------------- แก้ไขข้อมูลผู้บริหาร------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle" align="center">แก้ไขข้อมูลผู้บริหาร</h5>
      </div>
      <form id="sendFormEditStudent" method="post" enctype="multipart/form-data">
      <div class="modal-body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for=""><h5><b>ตำแหน่ง :</b></h5></label>
                                            <select class="form-control" name="executivePosition" id="executivePosition">
                                                <option value="">-- ระบุตำแหน่ง --</option>
                                                <option value="คณบดี">คณบดี</option>
                                                <option value="รองคณบดี">รองคณบดี</option>
                                                <option value="ผู้ช่วยคณบดี">ผู้ช่วยคณบดี</option>
                                                <option value="บุคลากรสายวิชาการ">บุคลากรสายวิชาการ</option>
                                                <option value="บุคลากรสายสนับสนุน">บุคลากรสายสนับสนุน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="">คำนำหน้า<font color="red">*</font></label>
                                            <select class="form-control" name="executiveTitleName" id="executiveTitleName">
                                                <option value="">-- ระบุคำนำหน้า --</option>
                                                <option value="นาย">นาย</option>
                                                <option value="นาง">นาง</option>
                                                <option value="นางสาว">นางสาว</option>
                                                <option value="ดร.">ดร.</option>
                                                <option value="ผศ.">ผศ.</option>
                                                <option value="ผศ.ดร.">ผศ.ดร.</option>
                                                <option value="รศ.">รศ.</option>
                                                <option value="รศ.ดร.">รศ.ดร.</option>
                                                <option value="ศ.">ศ.</option>
                                                <option value="ศ.ดร.">ศ.ดร.</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="">ชื่อ-นามสกุล<font color="red">*</font></label>
                                            <input type="text" class="form-control" name="executiveName" placeholder="ระบุชื่อ-นามสกุล" id="executiveName">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="">เบอร์โทรศัพท์<font color="red">*</font></label>
                                            <input type="text" class="form-control" name="executiveTel" maxlength="10" placeholder="ระบุเบอร์โทรศัพท์ 10 หลัก ไม่ต้องมี -" id="executiveTel">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="">เลือกประเภทอาหาร<font color="red">*</font><font color="red"></font></label><br>
                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="executiveFood" id="executiveFood1" value="ปกติ" />
                                              <label class="form-check-label" for="executiveFood1">ปกติ</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="executiveFood" id="executiveFood2" value="ฮาลาล" />
                                              <label class="form-check-label" for="executiveFood2">ฮาลาล</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                              <input class="form-check-input" type="radio" name="executiveFood" id="executiveFood3" value="มังสวิรัติ" />
                                              <label class="form-check-label" for="executiveFood3">มังสวิรัติ</label>
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

