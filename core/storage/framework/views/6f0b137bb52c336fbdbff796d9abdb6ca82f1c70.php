<?php $__env->startSection('content'); ?>
<?php
	$banners = getContent('banner.element');
?>
<section class="banner-slider owl-theme owl-carousel">
    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="banner-slide-item bg_img" data-background="<?php echo e(getImage('assets/images/frontend/banner/'. $banner->data_values->background_image, '1920x1080')); ?>">
            <div class="container">
                <div class="banner__content">
                    <h5 class="banner__subtitle"><?php echo e(__($banner->data_values->heading)); ?></h5>
                    <h1 class="banner__title"><?php echo e(__($banner->data_values->sub_heading)); ?></h1>
                    <div class="banner__btn__grp">
                        <a href="<?php echo e($banner->data_values->first_button_url); ?>" class="cmn--btn"><?php echo e(__($banner->data_values->first_button_name)); ?></a>
                        <a href="<?php echo e($banner->data_values->second_button_url); ?>" class="cmn--btn"><?php echo e(__($banner->data_values->second_button_name)); ?></a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</section>

<?php if($sections->secs != null): ?>
    <?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make($activeTemplate.'sections.'.$sec, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/home.blade.php ENDPATH**/ ?>