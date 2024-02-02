<?php
   $features = getContent('feature.element',null,false,true);
?>
<section class="special-feature-section pb-60 pt-120 mt--200">
  <div class="container">
      <div class="row g-4 justify-content-center">
         <?php $__currentLoopData = $features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-6 col-lg-4">
                 <div class="special__feature">
                     <div class="special__feature-icon">
                         <?php echo $feature->data_values->feature_icon ?>
                     </div>
                     <div class="special__feature-content">
                         <h5 class="special__feature-content-title"><?php echo e(__($feature->data_values->heading)); ?></h5>
                         <p class="special__feature-content-txt">
                             <?php echo e(__($feature->data_values->sub_heading)); ?>

                         </p>
                     </div>
                 </div>
            </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
  </div>
</section>


<?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/sections/feature.blade.php ENDPATH**/ ?>