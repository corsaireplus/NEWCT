<?php
   $faq = getContent('faq.content', true);
   $faqs = getContent('faq.element',null,false,true);
?>
<section class="faqs-section pt-120 pb-120">
    <div class="container">
        <div class="row justify-content-between gy-5 align-items-end">
            <div class="col-lg-6">
                <div class="section__header">
                    <span class="section__cate"><?php echo e(__(@$faq->data_values->title)); ?></span>
                    <h3 class="section__title"><?php echo e(__(@$faq->data_values->heading)); ?></h3>
                    <p>
                        <?php echo e(__(@$faq->data_values->sub_heading)); ?>

                    </p>
                </div>
                <div class="faq__wrapper">
                    <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                       <div class="faq__item">
                           <div class="faq__title">
                               <h5 class="title"><?php echo e(__($value->data_values->question)); ?></h5>
                               <span class="right-icon"></span>
                           </div>
                           <div class="faq__content">
                               <p>
                                   <?php echo e(__($value->data_values->answer)); ?>

                               </p>
                           </div>
                       </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="faqs-thumb">
                    <img src="<?php echo e(getImage('assets/images/frontend/faq/'. @$faq->data_values->faq_image, '651x464')); ?>" alt="<?php echo app('translator')->get('faqs'); ?>">
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/sections/faq.blade.php ENDPATH**/ ?>