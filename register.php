<div class="container px-4 px-lg-5 mt-5">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <div class="card-body">

            <?php
                /*
                $checkDate = date("d-m-y");
                if($checkDate == "20-01-24"){
                */
                    
            ?>
            <!--
                <div class="text-center">
                    <h2 class="fw-bolder">ระบบปิดรับสมัคร</h2>
                    การแข่งขันทักษะทางวิชาการศิลปศาสตร์ราชมงคลแห่งประเทศไทย ครั้งที่ 8 ชิงถ้วยพระราชทานสมเด็จพระกนิษฐาธิราชเจ้า กรมสมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมาร
                </div>
                <br>
                <br>
                <br>
                <br>
                <br>
            -->
            <?php 
                /*
                }else{
                */
            ?>
            <div class="text-center">
                <h2 class="fw-bolder">เข้าสู่ระบบเพื่อลงทะเบียน</h2>
            </div>

            <br>


              <div class="form-group">
                <label for="exampleInputEmail1">ชื่อผู้ใช้</label>
                <input type="email" class="form-control" id="username" placeholder="ชื่อผู้ใช้" maxlength="20">
              </div>
              <br>
              <div class="form-group">
                <label for="exampleInputPassword1">รหัสผ่าน</label>
                <input type="password" class="form-control" id="password" placeholder="รหัสผ่าน" maxlength="20">
              </div>
              <br>
              <div class="form-group">
                <div class="d-grid gap-2">
                    <button type="button" id="submitLogin" class="btn btn-primary btn-block">เข้าสู่ระบบ</button>
                </div>
              </div>
              
            <?php 
                /*
                }
                */
            ?>

        </div>

    </div>
</div>



<script type="text/javascript">
        $(document).ready(function() {
            //$(this).scrollTop(200);
            $("#submitLogin").on("click", function(e){

                var username = $("#username").val();
                var password = $("#password").val();;

                if(username == "" || password == ""){
                    swal("กรุณากรอกชื่อผู้ใช้และรหัสผ่าน!", "", "warning");
                }else{
                    $.ajax({
                        type: 'POST',
                        url: 'user/check_login.php',
                        dataType: "json",
                        data: {
                          username: username,
                          password: password,
                        },
                        success: function (data) {
                            if(data.status == 'ok'){
                                swal({
                                  title: "เข้าสู่ระบบสำเร็จ", 
                                  text: "Success", 
                                  type: "success"
                                },function(){ 
                                    location.assign("index.php?file_name=register_activity");
                                });
                              }else if(data.status == 'notactive'){
                                swal("ระบบปิดรับสมัครแล้ว", "กรุณาติดต่อฝ่ายประสานงาน", "error");
                              }else{
                                swal("ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง", "Fail", "error");
                              }
                        },
                        error: function (data) {
                          swal("ไม่สามารถเข้าสู่ระบบได้ในขณะนี้", "Fail", "error");
                        }
                    });
                }
            });
        });
</script>

