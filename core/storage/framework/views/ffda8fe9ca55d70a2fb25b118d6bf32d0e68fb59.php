<?php
    $footer = getContent('footer.content', true);
    $contactInfo = getContent('contactInfo.content', true);
    $socialIcons = getContent('social_icon.element');
    $links = getContent('policy_pages.element', orderById: true);
?>


<footer class="footer-section bg--title-overlay bg_img bg_fixed"
    data-background="<?php echo e(getImage('assets/images/frontend/footer/' . $footer->data_values->background_image, '1920x1080')); ?>">
    <div class="footer-top pt-120 pb-120 position-relative">
        <div class="container">
            <div class="row gy-5 justify-content-between">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <div class="logo">
                            <a href="<?php echo e(route('home')); ?>">
                                <img src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png')); ?>" alt="<?php echo app('translator')->get('logo'); ?>">
                            </a>
                        </div>
                        <p>
                            <?php echo e(__($footer->data_values->heading)); ?>

                        </p>
                        <ul class="social-icons justify-content-start">
                            <?php $__currentLoopData = $socialIcons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socialIcon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e($socialIcon->data_values->url); ?>" target="__blank"><?php echo $socialIcon->data_values->social_icon ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h5 class="title text--white"><?php echo app('translator')->get('Company'); ?></h5>
                        <ul class="useful-link">
                            <li>
                                <a href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('Home'); ?></a>
                            </li>
                            <?php $__currentLoopData = $pages->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e(route('pages', [slug($data->slug)])); ?>">
                                        <?php echo e(__($data->name)); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h5 class="title text--white"><?php echo app('translator')->get('Useful Link'); ?></h5>
                        <ul class="useful-link">
                            <li>
                                <a href="<?php echo e(route('order.tracking')); ?>"><?php echo app('translator')->get('Order Tracking'); ?></a>
                            </li>

                            <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(route('policy.pages', [slug($link->data_values->title), $link->id])); ?>">
                                        <?php echo e(__($link->data_values->title)); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                            <li>
                                <a href="<?php echo e(route('contact')); ?>"><?php echo app('translator')->get('Support'); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__widget">
                        <h5 class="title text--white"><?php echo app('translator')->get('Get In Touch'); ?></h5>
                        <ul class="footer__widget-contact">
                            <li>
                                <i class="las la-map-marker"></i> <?php echo e(__($footer->data_values->address)); ?>

                            </li>
                            <li>
                                <i class="las la-mobile"></i> <?php echo app('translator')->get('Mobile'); ?>:
                                <?php echo e($footer->data_values->mobile); ?>

                            </li>
                            <li>
                                <i class="las la-fax"></i> <?php echo app('translator')->get('Fax'); ?> : <?php echo e($footer->data_values->fax); ?>

                            </li>
                            <li>
                                <i class="las la-envelope"></i> <?php echo e($footer->data_values->email); ?>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom position-relative text-center">
        <div class="container">
            &copy; <?php echo app('translator')->get('All Right Reserved by'); ?> <a href="<?php echo e(route('home')); ?>"><?php echo e(__($general->site_name)); ?></a>
        </div>
    </div>
</footer>

<?php
$cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
?>
<?php if($cookie->data_values->status == Status::YES && !\Cookie::get('gdpr_cookie')): ?>
<div class="cookies-card text-center hide">
    <div class="cookies-card__icon bg--base">
        <i class="las la-cookie-bite"></i>
    </div>
    <p class="mt-4 cookies-card__content"><?php echo e($cookie->data_values->short_desc); ?> <a
            href="<?php echo e(route('cookie.policy')); ?>" target="_blank"><?php echo app('translator')->get('learn more'); ?></a></p>
    <div class="cookies-card__btn mt-4">
        <button class="cmn--btn btn--lg w-100 policy"><?php echo app('translator')->get('Allow'); ?></button>
    </div>
</div>
<?php endif; ?>

<?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/partials/footer.blade.php ENDPATH**/ ?>