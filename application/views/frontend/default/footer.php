<footer class="footer-area d-print-none">
    <div class="container-xl">
        <div class="row row_top_footer">
            <div class="col-12 col-md-3 flex-row align-center" style="display: flex;">
                <a href="" ><img src="<?php echo base_url().'uploads/system/get_logo_blanco.png'; ?>" alt="" class="d-inline-block logo-footer" width="90"></a>
            </div>
            <div class="col-6 col-md-2">
                <ul class="nav footer-menu menu-vr">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?= get_phrase('home'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" target="_blank"><?= get_phrase('contact_us'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" target="_blank"><?= get_phrase('about_us'); ?></a>
                    </li>
                </ul>
            </div>
            <div class="col-6 col-md-2">
                <ul class="nav footer-menu menu-vr">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/terms_and_condition'); ?>"><?php echo get_phrase('terms_and_condition'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/cookie_policy'); ?>"><?php echo get_phrase('cookie_policy'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/about_us'); ?>"><?php echo get_phrase('about_us'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/#top_courses'); ?>"><?php echo get_phrase('top_courses'); ?></a>
                    </li>

                </ul>
            </div>
            <div class="col-6 col-md-2">
                <ul class="nav footer-menu menu-vr">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/terms_and_condition'); ?>"><?php echo get_phrase('terms_and_condition'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/cookie_policy'); ?>"><?php echo get_phrase('cookie_policy'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/about_us'); ?>"><?php echo get_phrase('about_us'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/#top_courses'); ?>"><?php echo get_phrase('top_courses'); ?></a>
                    </li>

                </ul>
            </div>
            <div class="col-12 col-md-3">
                <ul class="nav social">
                    <li class="social-item"><a target="_blank" href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="social-item"><a title="twitter" target="_blank" href="#"><i class="fab fa-twitter"></i></a></li>
                    <li class="social-item"><a title="" target="_blank" href="#"><i class="fab fa-linkedin"></i></a></li>
                    <li class="social-item"><a title="" target="_blank" href="#"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>

        </div>
        <div class="row row_bottom_footer">
            <div class="col-12">
                <ul class="nav justify-content-center footer-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/privacy_policy'); ?>"><?php echo get_phrase('privacy_policy'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/terms_and_condition'); ?>"><?php echo get_phrase('terms_and_condition'); ?></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/login'); ?>">
                            <?php echo get_phrase('login'); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo site_url('language/switch_lang/spanish'); ?>" class="nav-link lang_item <?php echo $this->session->userdata('site_lang') === 'spanish' ? 'selected' : '';?>"><span class="flag-icon flag-icon-es"></span> <?php echo get_phrase('spanish'); ?></a>
                        <a href="<?php echo site_url('language/switch_lang/english'); ?>" class="nav-link lang_item <?php echo $this->session->userdata('site_lang') === 'english' ? 'selected' : '';?>"><span class="flag-icon flag-icon-us"></span> <?php echo get_phrase('english'); ?></a>
                    </li>
                </ul>
            </div>
            <div class="col-12">
                <p class="copyright-text">
                    <a href="<?php echo get_settings('footer_link'); ?>" target="_blank"><?php echo get_settings('footer_text'); ?></a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- PAYMENT MODAL -->
<!-- Modal -->
<?php
$paypal_info = json_decode(get_settings('paypal'), true);
$stripe_info = json_decode(get_settings('stripe_keys'), true);
if ($paypal_info[0]['active'] == 0) {
    $paypal_status = 'disabled';
}else {
    $paypal_status = '';
}
if ($stripe_info[0]['active'] == 0) {
    $stripe_status = 'disabled';
}else {
    $stripe_status = '';
}
?>

<!-- Modal -->
<div class="modal fade multi-step" id="EditRatingModal" tabindex="-1" role="dialog" aria-hidden="true" reset-on-close="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content edit-rating-modal">
            <div class="modal-header">
                <h5 class="modal-title step-1" data-step="1"><?php echo get_phrase('step').' 1'; ?></h5>
                <h5 class="modal-title step-2" data-step="2"><?php echo get_phrase('step').' 2'; ?></h5>
                <h5 class="m-progress-stats modal-title">
                    &nbsp;of&nbsp;<span class="m-progress-total"></span>
                </h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="m-progress-bar-wrapper">
                <div class="m-progress-bar">
                </div>
            </div>
            <div class="modal-body step step-1">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modal-rating-box">
                                <h4 class="rating-title"><?php echo get_phrase('how_would_you_rate_this_course_overall'); ?>?</h4>
                                <fieldset class="your-rating">

                                    <input type="radio" id="star5" name="rating" value="5" />
                                    <label class = "full" for="star5"></label>

                                    <!-- <input type="radio" id="star4half" name="rating" value="4 and a half" />
                                    <label class="half" for="star4half"></label> -->

                                    <input type="radio" id="star4" name="rating" value="4" />
                                    <label class = "full" for="star4"></label>

                                    <!-- <input type="radio" id="star3half" name="rating" value="3 and a half" />
                                    <label class="half" for="star3half"></label> -->

                                    <input type="radio" id="star3" name="rating" value="3" />
                                    <label class = "full" for="star3"></label>

                                    <!-- <input type="radio" id="star2half" name="rating" value="2 and a half" />
                                    <label class="half" for="star2half"></label> -->

                                    <input type="radio" id="star2" name="rating" value="2" />
                                    <label class = "full" for="star2"></label>

                                    <!-- <input type="radio" id="star1half" name="rating" value="1 and a half" />
                                    <label class="half" for="star1half"></label> -->

                                    <input type="radio" id="star1" name="rating" value="1" />
                                    <label class = "full" for="star1"></label>

                                    <!-- <input type="radio" id="starhalf" name="rating" value="half" />
                                    <label class="half" for="starhalf"></label> -->

                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-course-preview-box">
                                <div class="card">
                                    <img class="card-img-top img-fluid" id = "course_thumbnail_1" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title" class = "course_title_for_rating" id = "course_title_1"></h5>
                                        <p class="card-text" id = "instructor_details">

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-body step step-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="modal-rating-comment-box">
                                <h4 class="rating-title"><?php echo get_phrase('write_a_public_review'); ?></h4>
                                <textarea id = "review_of_a_course" name = "review_of_a_course" placeholder="<?php echo get_phrase('describe_your_experience_what_you_got_out_of_the_course_and_other_helpful_highlights').'. '.get_phrase('what_did_the_instructor_do_well_and_what_could_use_some_improvement') ?>?" maxlength="65000" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-course-preview-box">
                                <div class="card">
                                    <img class="card-img-top img-fluid" id = "course_thumbnail_2" alt="">
                                    <div class="card-body">
                                        <h5 class="card-title" class = "course_title_for_rating" id = "course_title_2"></h5>
                                        <p class="card-text">
                                            -
                                            <?php
                                            $admin_details = $this->user_model->get_admin_details()->row_array();
                                            echo $admin_details['first_name'].' '.$admin_details['last_name'];
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="course_id" id = "course_id_for_rating" value="">
            <div class="modal-footer">
                <button type="button" class="btn btn-primary next step step-1" data-step="1" onclick="sendEvent(2)"><?php echo get_phrase('next'); ?></button>
                <button type="button" class="btn btn-primary previous step step-2 mr-auto" data-step="2" onclick="sendEvent(1)"><?php echo get_phrase('previous'); ?></button>
                <button type="button" class="btn btn-primary publish step step-2" onclick="publishRating($('#course_id_for_rating').val())" id = ""><?php echo get_phrase('publish'); ?></button>
            </div>
        </div>
    </div>
</div><!-- Modal -->

<?php include 'codigos_de_rastreo.html'; ?>