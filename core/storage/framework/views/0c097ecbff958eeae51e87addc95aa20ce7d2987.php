<?php
   $service = getContent('service.content', true);
   $serviceElements = getContent('service.element',null,false,true);
?>
<section class="service-section pt-120 pb-120 bg--title-overlay bg_fixed bg_img" data-background="<?php echo e(getImage('assets/images/frontend/service/'. @$service->data_values->background_image, '1920x1080')); ?>">
    <div class="container position-relative">
        <div class="section__header section__header__center text--white">
            <span class="section__cate">
                <?php echo e(__(@$service->data_values->title)); ?>

            </span>
            <h3 class="section__title"><?php echo e(__(@$service->data_values->heading)); ?></h3>
            <p>
               <?php echo e(__(@$service->data_values->sub_heading)); ?>

            </p>
        </div>
        <div class="row justify-content-center g-4">
           <?php $__currentLoopData = $serviceElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $serviceElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <div class="col-md-6 col-sm-10 col-lg-4">
                   <div class="service__item">
                       <div class="service__item-thumb">
                           <img src="<?php echo e(getImage('assets/images/frontend/service/'. $serviceElement->data_values->image, '128x128')); ?>" alt="<?php echo app('translator')->get('service image'); ?>">
                       </div>
                       <div class="service__item-content">
                           <h5 class="service__item-content-title"><?php echo e(__($serviceElement->data_values->title)); ?></h5>
                           <p><?php echo e(__($serviceElement->data_values->description)); ?></p>
                       </div>
                   </div>
               </div>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/sections/service.blade.php ENDPATH**/ ?>