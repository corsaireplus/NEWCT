<?php
    $breadcrumbs = getContent('breadcrumb.content', true);
?>
<div class="hero-section bg--title-overlay bg_img"
    data-background="<?php echo e(getImage('assets/images/frontend/breadcrumb/' . $breadcrumbs->data_values->background_image, '1920x770')); ?>">
    <div class="container">
        <div class="hero__content">
            <h2 class="hero__title"><?php echo e(__($pageTitle)); ?></h2>
            <div class="breadcrumb">
                <li>
                    <a href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('home'); ?></a>
                </li>
                <li>
                    <?php echo e(__($pageTitle)); ?>

                </li>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/partials/breadcrumb.blade.php ENDPATH**/ ?>