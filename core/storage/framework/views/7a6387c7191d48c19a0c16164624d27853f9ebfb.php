<?php
    $partners = getContent('partner.element', null, false, true);
?>
<div class="partner-section pt-80 pb-80">
    <div class="container">
        <div class="partner-slider owl-theme owl-carousel">
            <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a class="partner-thumb" href="javascript:void(0)">
                    <img src="<?php echo e(getImage('assets/images/frontend/partner/' . $partner->data_values->partner_image, '135x45')); ?>"
                        alt="<?php echo app('translator')->get('partner'); ?>">
                    <img src="<?php echo e(getImage('assets/images/frontend/partner/' . $partner->data_values->partner_image, '135x45')); ?>"
                        alt="<?php echo app('translator')->get('partner'); ?>">
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/sections/partner.blade.php ENDPATH**/ ?>