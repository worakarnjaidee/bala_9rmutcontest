<style>
:root {
  --lightbox: rgb(0 0 0 / 0.75);
  --carousel-text: #fff;
}


@keyframes zoomin {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.05);
  }
  100% {
    transform: scale(1);
  }
}

.gallery-item {
  display: block;
}

.gallery-item img {
  box-shadow: 0 1rem 1rem rgba(0, 0, 0, 0.15);
  transition: box-shadow 0.2s;
}

.gallery-item:hover img {
  box-shadow: 0 1rem 1rem rgba(0, 0, 0, 0.35);
}

.lightbox-modal .modal-content {
  background-color: var(--lightbox);
}

.lightbox-modal .btn-close {
  position: absolute;
  top: 1.25rem;
  right: 1.25rem;
  font-size: 1.25rem;
  z-index: 10;
  filter: invert(1) grayscale(100);
}

.lightbox-modal .modal-body {
  display: flex;
  align-items: center;
  padding: 0;
}

.lightbox-modal .lightbox-content {
  width: 100%;
}

.lightbox-modal .carousel-indicators {
  margin-bottom: 0;
}

.lightbox-modal .carousel-indicators [data-bs-target] {
  background-color: var(--carousel-text) !important;
}

.lightbox-modal .carousel-inner {
  width: 75%;
}

.lightbox-modal .carousel-inner img {
  animation: zoomin 10s linear infinite;
}

.lightbox-modal .carousel-item .carousel-caption {
  right: 0;
  bottom: 0;
  left: 0;
  padding-bottom: 2rem;
  background-color: var(--lightbox);
  color: var(--carousel-text) !important;
}

.lightbox-modal .carousel-control-prev,
.lightbox-modal .carousel-control-next {
  width: auto;
}

.lightbox-modal .carousel-control-prev {
  left: 1.25rem;
}

.lightbox-modal .carousel-control-next {
  right: 1.25rem;
}

@media (min-width: 1400px) {
  .lightbox-modal .carousel-inner {
    max-width: 60%;
  }
}

[data-bs-theme = "dark"] .lightbox-modal .carousel-control-next-icon,
[data-bs-theme = "dark"] .lightbox-modal .carousel-control-prev-icon {
    filter: none;
}

.btn-fullscreen-enlarge,
.btn-fullscreen-exit {
  position: absolute;
  top: 1.25rem;
  right: 3.5rem;
  z-index: 10;
  border: 0;
  background: transparent;
  opacity: .6;
  font-size: 1.25rem;
}

.bi {
  display: inline-block;
  width: 1em;
  height: 1em;
  vertical-align: -0.035em;
  fill: currentcolor;
}
</style>
<script>
    const html = document.querySelector('html');
html.setAttribute('data-bs-theme', 'dark');

document.addEventListener('DOMContentLoaded', () => {
  // --- Create LightBox
  const galleryGrid = document.querySelector(".gallery-grid");
  const links = galleryGrid.querySelectorAll("a");
  const imgs = galleryGrid.querySelectorAll("img");
  const lightboxModal = document.getElementById("lightbox-modal");
  const bsModal = new bootstrap.Modal(lightboxModal);
  const modalBody = lightboxModal.querySelector(".lightbox-content");

  function createCaption (caption) {
    return `<div class="carousel-caption d-none d-md-block">
        <h4 class="m-0">${caption}</h4>
      </div>`;
  }

  function createIndicators (img) {
    let markup = "", i, len;

    const countSlides = links.length;
    const parentCol = img.closest('.col');
    const curIndex = [...parentCol.parentElement.children].indexOf(parentCol);

    for (i = 0, len = countSlides; i < len; i++) {
      markup += `
        <button type="button" data-bs-target="#lightboxCarousel"
          data-bs-slide-to="${i}"
          ${i === curIndex ? 'class="active" aria-current="true"' : ''}
          aria-label="Slide ${i + 1}">
        </button>`;
    }

    return markup;
  }

  function createSlides (img) {
    let markup = "";
    const currentImgSrc = img.closest('.gallery-item').getAttribute("href");

    for (const img of imgs) {
      const imgSrc = img.closest('.gallery-item').getAttribute("href");
      const imgAlt = img.getAttribute("alt");

      markup += `
        <div class="carousel-item${currentImgSrc === imgSrc ? " active" : ""}">
          <img class="d-block img-fluid w-100" src=${imgSrc} alt="${imgAlt}">
          ${imgAlt ? createCaption(imgAlt) : ""}
        </div>`;
    }

    return markup;
  }

  function createCarousel (img) {
    const markup = `
      <!-- Lightbox Carousel -->
      <div id="lightboxCarousel" class="carousel slide carousel-fade" data-bs-ride="true">
        <!-- Indicators/dots -->
        <div class="carousel-indicators">
          ${createIndicators(img)}
        </div>
        <!-- Wrapper for Slides -->
        <div class="carousel-inner justify-content-center mx-auto">
          ${createSlides(img)}
        </div>
        <!-- Controls/icons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      `;

    modalBody.innerHTML = markup;
  }

  for (const link of links) {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const currentImg = link.querySelector("img");
      const lightboxCarousel = document.getElementById("lightboxCarousel");

      if (lightboxCarousel) {
        const parentCol = link.closest('.col');
        const index = [...parentCol.parentElement.children].indexOf(parentCol);

        const bsCarousel = new bootstrap.Carousel(lightboxCarousel);
        bsCarousel.to(index);
      } else {
        createCarousel(currentImg);
      }

      bsModal.show();
    });
  }

  // --- Support Fullscreen
  const fsEnlarge = document.querySelector(".btn-fullscreen-enlarge");
  const fsExit = document.querySelector(".btn-fullscreen-exit");

  function enterFS () {
    lightboxModal.requestFullscreen().then({}).catch(err => {
      alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
    });
    fsEnlarge.classList.toggle("d-none");
    fsExit.classList.toggle("d-none");
  }

  function exitFS () {
    document.exitFullscreen();
    fsExit.classList.toggle("d-none");
    fsEnlarge.classList.toggle("d-none");
  }

  fsEnlarge.addEventListener("click", (e) => {
    e.preventDefault();
    enterFS();
  });

  fsExit.addEventListener("click", (e) => {
    e.preventDefault();
    exitFS();
  });
})

</script>
<br>
<br>
<h2 class="text-center mb-0"><b>ภาพกิจกรรม</b></h2>
<p class="text-center mb-4">การแข่งขันทักษะทางวิชาการศิลปศาสตร์ราชมงคลแห่งประเทศไทย ครั้งที่ 8 ชิงถ้วยพระราชทานสมเด็จพระกนิษฐาธิราชเจ้า กรมสมเด็จพระเทพรัตนราชสุดาฯ สยามบรมราชกุมาร</p>

<section class="photo-gallery">
  <div class="container">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4 gallery-grid">

    <?php
        $dir = "album/";

            // Open a directory, and read its contents
        if (is_dir($dir)){
            if ($dh = opendir($dir)){
                while (($file = readdir($dh)) !== false){
                  if($file != ".." && $file != "."){
                    echo "<div class='col'>
                        <a class='gallery-item' href='album/".$file."'>
                          <img src='album/".$file."' class='img-fluid'>
                        </a>
                      </div>";
                    
                  }
                  
                }
                closedir($dh);
             }
        }
    ?>

    </div>

  </div>
</section>

<br><br>
<?php 
  $directory = "album/";
 
  // Initialize filecount variable
  $filecount = 0;
   
  $files2 = glob( $directory ."*" );
   
  if( $files2 ) {
      $filecount = count($files2);
  }
   
  if($filecount == 0){
    echo "<div class='text-center mb-0'>
            <a type='button' class='btn btn-success'>อยู่ระหว่างการอัปเดตข้อมูล</a>
          </div>";
  }
?>

<div class="modal fade lightbox-modal" id="lightbox-modal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-fullscreen">
    <div class="modal-content">
      <button type="button" class="btn-fullscreen-enlarge" aria-label="Enlarge fullscreen">
        <svg class="bi"><use href="#enlarge"></use></svg>
      </button>
      <button type="button" class="btn-fullscreen-exit d-none" aria-label="Exit fullscreen">
        <svg class="bi"><use href="#exit"></use></svg>
      </button>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-body">
        <div class="lightbox-content">
          <!-- JS content here -->
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
        $(document).ready(function() {
            //$(this).scrollTop(650);

        });
</script>