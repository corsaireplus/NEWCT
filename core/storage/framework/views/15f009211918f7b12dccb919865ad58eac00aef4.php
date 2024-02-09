<?php $__env->startSection('content'); ?>
<?php echo $__env->make($activeTemplate . 'partials.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<section class="track-section pt-120 pb-120">
        <div class="container">
            <div class="section__header">
                    <span class="section__cate">Challenge Transit</span>
                    <!--h3 class="section__title">Nos Prochains départs</h3>
                    <p>
                        veuillez contactez-nous au 0179751616
                    </p-->
                </div>
                <div class="col-lg-12">
                <div class="faqs-thumb">
               <img src="<?php echo e(getImage('assets/images/frontend/departs/ct_departs_janvier.jpeg','departs')); ?>"  alt="<?php echo app('translator')->get('contact'); ?>">                </div>
              </div>
              
               
            
            </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/departs.blade.php ENDPATH**/ ?>