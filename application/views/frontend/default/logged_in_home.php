<link rel="stylesheet" href="<?php echo site_url('assets\frontend\default\css\menu_flotante.css');?>">
<link rel="stylesheet" href="<?php echo site_url('assets\frontend\default\css\styles_logged_in_home.css?v=2');?>">
<section class="home-banner-area logged_in">

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="home-banner-wrap">
                    <h2 class="section-title">
                        <span class="font-bold">Capacitación</span>
                        <br class="hide-on-mobile">
                        al personal
                    </h2>
                </div>
                <div class="row-start align-center wrap buttons">
                    <div>
                        <a href="<?= site_url('home/courses'); ?>" class="btn btn-light"><?php echo get_phrase('view_courses'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="course-carousel-area section">
    <div class="container-narrow">
        <div class="row">
            <div class="col">
                <h2 class="course-carousel-title"><?php echo get_phrase('top_courses'); ?></h2>
                <div class="course-carousel">
                    <?php $top_courses = $this->crud_model->get_top_courses()->result_array();
                    $cart_items = $this->session->userdata('cart_items');
                    foreach ($top_courses as $top_course):?>
                        <div class="course-box-wrap">
                            <a href="<?php echo site_url('home/course/'.slugify($top_course['title']).'/'.$top_course['id']); ?>" class="has-popover">
                                <div class="course-box">
                                    <!-- <div class="course-badge position best-seller">Best seller</div> -->
                                    <div class="course-image">
                                        <img src="<?php echo $this->crud_model->get_course_thumbnail_url($top_course['id']); ?>" alt="" class="img-fluid">
                                    </div>
                                    <div class="course-details">
                                        <h5 class="title"><?php echo $top_course['title']; ?></h5>
                                        <p class="instructors"><?php echo $top_course['short_description']; ?></p>
                                        <div class="rating">
                                            <?php
                                            $total_rating =  $this->crud_model->get_ratings('course', $top_course['id'], true)->row()->rating;
                                            $number_of_ratings = $this->crud_model->get_ratings('course', $top_course['id'])->num_rows();
                                            if ($number_of_ratings > 0) {
                                                $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                                            }else {
                                                $average_ceil_rating = 0;
                                            }

                                            for($i = 1; $i < 6; $i++):?>
                                                <?php if ($i <= $average_ceil_rating): ?>
                                                    <i class="fas fa-star filled"></i>
                                                <?php else: ?>
                                                    <i class="fas fa-star"></i>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                            <span class="d-inline-block average-rating"><?php echo $average_ceil_rating; ?></span>
                                        </div>
                                        <?php if ($top_course['is_free_course'] == 1): ?>
                                            <p class="price text-right"><?php echo get_phrase('free'); ?></p>
                                        <?php else: ?>
                                            <?php if ($top_course['discount_flag'] == 1): ?>
                                                <p class="price text-right"><small><?php echo currency($top_course['price']); ?></small><?php echo currency($top_course['discounted_price']); ?></p>
                                            <?php else: ?>
                                                <p class="price text-right"><?php echo currency($top_course['price']); ?></p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>

                            <div class="webui-popover-content">
                                <div class="course-popover-content">
                                    <?php if ($top_course['last_modified'] == ""): ?>
                                        <div class="last-updated"><?php echo get_phrase('last_updater').' '.date('D, d-M-Y', $top_course['date_added']); ?></div>
                                    <?php else: ?>
                                        <div class="last-updated"><?php echo get_phrase('last_updater').' '.date('D, d-M-Y', $top_course['last_modified']); ?></div>
                                    <?php endif; ?>

                                    <div class="course-title">
                                        <a href="<?php echo site_url('home/course/'.slugify($top_course['title']).'/'.$top_course['id']); ?>"><?php echo $top_course['title']; ?></a>
                                    </div>
                                    <div class="course-meta">
                                <span class=""><i class="fas fa-play-circle"></i>
                                    <?php echo $this->crud_model->get_lessons('course', $top_course['id'])->num_rows().' '.get_phrase('lessons'); ?>
                                </span>
                                        <span class=""><i class="far fa-clock"></i>
                                    <?php
                                    $total_duration = 0;
                                    $lessons = $this->crud_model->get_lessons('course', $top_course['id'])->result_array();
                                    foreach ($lessons as $lesson) {
                                        if ($lesson['lesson_type'] != "other") {
                                            $time_array = explode(':', $lesson['duration']);
                                            $hour_to_seconds = $time_array[0] * 60 * 60;
                                            $minute_to_seconds = $time_array[1] * 60;
                                            $seconds = $time_array[2];
                                            $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
                                        }
                                    }
                                    echo gmdate("H:i:s", $total_duration).' '.get_phrase('hours');
                                    ?>
                                </span>
                                        <span class=""><i class="fas fa-closed-captioning"></i><?php echo ucfirst($top_course['language']); ?></span>
                                    </div>
                                    <div class="course-subtitle"><?php echo $top_course['short_description']; ?></div>
                                    <div class="what-will-learn">
                                        <ul>
                                            <?php
                                            $outcomes = json_decode($top_course['outcomes']);
                                            foreach ($outcomes as $outcome):?>
                                                <li><?php echo $outcome; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="popover-btns">
                                        <?php if (is_purchased($top_course['id'])): ?>
                                            <div class="purchased">
                                                <a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('already_purchased'); ?></a>
                                            </div>
                                        <?php else: ?>
                                            <?php if ($top_course['is_free_course'] == 1):
                                                if($this->session->userdata('user_login') != 1) {
                                                    $url = "#";
                                                }else {
                                                    $url = site_url('home/get_enrolled_to_free_course/'.$top_course['id']);
                                                }?>
                                                <a href="<?php echo $url; ?>" class="btn add-to-cart-btn big-cart-button" onclick="handleEnrolledButton()"><?php echo get_phrase('get_enrolled'); ?></a>
                                            <?php else: ?>
                                                <button type="button" class="btn add-to-cart-btn <?php if(in_array($top_course['id'], $cart_items)) echo 'addedToCart'; ?> big-cart-button-<?php echo $top_course['id'];?>" id = "<?php echo $top_course['id']; ?>" onclick="handleCartItems(this)">
                                                    <?php
                                                    if(in_array($top_course['id'], $cart_items))
                                                        echo get_phrase('added_to_cart');
                                                    else
                                                        echo get_phrase('add_to_cart');
                                                    ?>
                                                </button>
                                                <button type="button" class="wishlist-btn <?php if($this->crud_model->is_added_to_wishlist($top_course['id'])) echo 'active'; ?>" title="Add to wishlist" onclick="handleWishList(this)" id = "<?php echo $top_course['id']; ?>"><i class="fas fa-heart"></i></button>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $latest_courses = $this->crud_model->get_latest_10_course();?>
<section class="section section_banner bg-gray" id="section_new_course">
    <div class="container-narrow">
        <div class="row">
            <div class="col col-12 col-md-5">
                <div class="course_image">
                    <img src="<?php echo $this->crud_model->get_course_thumbnail_url($latest_courses[0]['id']); ?>" alt="" class="img-fluid">
                </div>
            </div>
            <div class="col col-12 col-md-6 row-start align-center">
                <div class="course_content">

                    <h3 class="section-title font-weight-light"><?php echo get_phrase('new_course'); ?></h3>
                    <h3 class="course_title"><?php echo $latest_courses[0]['title'];?></h3>
                    <p class="description"><?= $latest_courses[0]['short_description'];?></p>
                    <a href="<?php echo site_url('home/course/'.slugify($latest_courses[0]['title']).'/'.$latest_courses[0]['id']); ?>" class="btn"><?php echo get_phrase('go_to_course'); ?></a>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo base_url();?>assets/global/plyr/plyr.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/global/plyr/plyr.css">
<script>
    (function () {
        const player = new Plyr('#player_video_2');
        const playTrigger = document.querySelector('#player_video_2 .play-trigger');
        playTrigger.addEventListener('click', evt => {
            evt.preventDefault();
            playTrigger.classList.add('hidden');
            player.play();
        }, false);
    })();
</script>