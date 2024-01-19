<style type="text/css">
    .col.mb-5 a:link{
      text-decoration: none;
    }
    .col.mb-5 a:hover {
      background-color: #a9822d;
      box-shadow:  0 0 20px grey;
    }
</style>

<div class="container px-4 px-lg-5 mt-5">
            <div class="text-center">
                <h2 class="fw-bolder">กิจกรรม</h2>
                การแข่งขันทักษะทางวิชาการศิลปศาสตร์ราชมงคลแห่งประเทศไทย ครั้งที่ 8 ชิงถ้วยพระราชทานสมเด็จพระกนิษฐาธิราชเจ้า กรมสมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมาร
                <br>
                <br>
            </div>

                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-5 justify-content-center">
                    
                    <?php 
                        $result = $con -> query("SELECT * FROM activity");
                            while ($row = $result->fetch()) {
                        
                    ?>
                    
                    <div class="col mb-5">
                        <a href="index.php?file_name=activity&activity_id=<?php echo $row['activity_id'];?>" class="col mb-5">
                            <div class="card h-100">
                                    <!-- Product image-->
                                    <img class="card-img-top" src="assets/img/logo.png" />
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <h5 class="fw-bolder"><font color="black"><?php echo $row['activityName'];?></h5>
                                            <?php echo $row['activityDetail'];?></font>
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="index.php?file_name=activity&activity_id=<?php echo $row['activity_id'];?>">รายละเอียดกิจกรรม</a></div>
                                    </div>

                            </div>
                        </a>
                    </div>
                    
                    <?php 
                        }
                    ?>


    </div>
</div>




<div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-2 justify-content-center">
                    
                <iframe width="560" height="315" src="https://www.youtube.com/embed/rhBKZMHDmss?si=udGPRPYZqb94aqgj" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                   
                       
                <iframe width="560" height="315" src="https://www.youtube.com/embed/ktk2LR2DLc8?si=rD9I8Yv21URsCqYM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
          
    </div>
</div>

<div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-2 justify-content-center">
                
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/KEu16CuIh90?si=akdSm9_LZR1cFmRg" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/ukzA-PTM27s?si=ydmp1aV2vx_-hJn3" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

    </div>
</div>

<div class="container px-4 px-lg-5 mt-5">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <div class="card-body">
            <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3776.7263800555475!2d98.95011977519879!3d18.810343482340283!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30da3a43cfcd65b5%3A0x1c0026152fc6a3df!2z4Lih4Lir4Liy4Lin4Li04LiX4Lii4Liy4Lil4Lix4Lii4LmA4LiX4LiE4LmC4LiZ4LmC4Lil4Lii4Li14Lij4Liy4LiK4Lih4LiH4LiE4Lil4Lil4LmJ4Liy4LiZ4LiZ4Liy!5e0!3m2!1sth!2sth!4v1700806799363!5m2!1sth!2sth" width="100%" height="600" style="border:1;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"> 
            </iframe>
        </div>
    </div>
</div>
