    <!-- Carousel Start -->
    <div class="container-fluid p-0 pb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="owl-carousel header-carousel position-relative">
            <?php 
                $folderPath = 'Default/PageHeader/';
                $files = scandir($folderPath);
                $imageFiles = array_diff($files, array('.', '..'));
                $numImages = count($imageFiles);
                foreach ($imageFiles as $imageFile) {
            ?>
            <div class="owl-carousel-item position-relative" data-dot="<img src='<?= $folderPath.$imageFile ?>'>">
                <img class="img-fluid" src="<?= $folderPath.$imageFile ?>" alt="" style="height:400px;">
                <div class="owl-carousel-inner">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-12 col-lg-10">
                                <h1 class="display-5 text-white animated slideInDown">LEADING INTEGRATED ENERGY PLAYER
                                </h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-3">บริษัท กันกุลเอ็นจิเนียริ่ง จำกัด (มหาชน)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                }
            ?>
        </div>
    </div>
    <!-- Carousel End -->