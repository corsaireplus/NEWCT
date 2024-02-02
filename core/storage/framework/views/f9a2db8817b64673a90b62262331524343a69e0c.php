<?php
    $counter = getContent('counter.content', true);
    $counters = getContent('counter.element', false, null, true);
?>
<div class="counter-section pt-80 pb-80 bg--title-overlay bg_fixed bg_img"
    data-background="<?php echo e(getImage('assets/images/frontend/counter/' . @$counter->data_values->background_image, '1920x1080')); ?>">
    <div class="container">
        <div class="row justify-content-center g-4">
            <?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-3 col-sm-6">
                    <div class="counter-item">
                        <div class="counter-header">
                            <h3 class="title rafcounter" data-counter-end="<?php echo e($value->data_values->counter_digit); ?>">
                                <?php echo e($value->data_values->counter_digit); ?></h3>
                        </div>
                        <div class="counter-content">
                            <?php echo e(__($value->data_values->title)); ?>

                        </div>
                        <div class="icon">
                            <?php echo $value->data_values->counter_icon ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/sections/counter.blade.php ENDPATH**/ ?>