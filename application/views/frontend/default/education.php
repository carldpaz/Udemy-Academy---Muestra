<link rel="stylesheet" href="<?php echo site_url('assets\frontend\default\css\animations.css');?>">
<link rel="stylesheet" href="<?php echo site_url('assets\frontend\default\css\style_education.css');?>">
<section class="home-banner-area animation_container" id="section_education">
    <div class="container">
        <div class="row">
            <div class="col animate__animated" data-animation="slideInLeft">
                <div class="home-banner-wrap">
                    <h2 class="section-title"><?php echo get_phrase('education'); ?></h2>
                    <h4 class="font-italic"><span class="font-bold"><?= get_phrase('how_');?></span> <?= get_phrase('_does_it_work');?></h4>
                    <br>
                    <p>
                        <?= get_phrase('discover_our_exclusive_service_where_you_will_receive_investment_signals_purchase_and_sale_of_coins_ensuring_growth_between_10_to_30_of_your_capital_each_month');?>
                    </p>
                </div>
                <div class="buttons">

                    <a href="<?php echo site_url('home/sign_up'); ?>" class="btn btn-transparent_white text-uppercase"><?php echo get_phrase('registration_link'); ?></a>
                    <a href="" class="btn btn-transparent_white text-uppercase"><?php echo get_phrase('advisory'); ?></a>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= base_url().'assets/frontend/default/js/animations.js'; ?>"></script>

<script>
    initializeAnimations();
</script>