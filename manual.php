<div class="container px-4 px-lg-5 mt-5">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <div class="card-body">
            <div class="text-center">
                
                <!-- Product name-->
                <h2 class="fw-bolder">คู่มือการใช้งานระบบ</h2>
                การแข่งขันทักษะทางวิชาการศิลปศาสตร์ราชมงคลแห่งประเทศไทย ครั้งที่ 8 ชิงถ้วยพระราชทานสมเด็จพระกนิษฐาธิราชเจ้า กรมสมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมาร
            </div>

            <br>
            <br>
            <?php 
                $documentId = '004'; 
                $document = "SELECT * FROM document WHERE documentId = :documentId";
                $stmt = $con -> prepare($document);
                $stmt -> bindParam(":documentId", $documentId);
                $stmt -> execute();
                $objDocument = $stmt -> fetch();
                    if($objDocument['documentFile'] != ""){
            ?>

            <object data="assets/document/<?php echo $objDocument['documentFile'];?>" width="100%" height="1000px">
                <p>Unable to display PDF file. <a href="/uploads/media/default/0001/01/540cb75550adf33f281f29132dddd14fded85bfc.pdf">Download</a> instead.</p>
            </object>
            <a type='submit' class='btn btn-outline-dark' href="assets/document/<?php echo $objDocument['documentFile'];?>" download>Download</a>

            <?php 

                }else{

            ?>
            <div class="text-center">

                <a type='button' class='btn btn-success'>อยู่ระหว่างการอัปเดตข้อมูล</a>
            </div>
            <?php 

                }

            ?>
        </div>

    </div>
</div>


<script type="text/javascript">
        $(document).ready(function() {
            //$(this).scrollTop(650);

        });
</script>