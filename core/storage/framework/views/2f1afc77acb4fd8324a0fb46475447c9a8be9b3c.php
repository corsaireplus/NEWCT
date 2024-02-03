<?php $__env->startSection('content'); ?>
    <div class="contact-section pt-120 pb-120">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 d-none d-lg-block rtl pe-xxl-50">
                    <img src="<?php echo e(getImage('assets/images/frontend/contact_us/' . @$contact->data_values->contact_image, '655x615')); ?>"
                        alt="<?php echo app('translator')->get('contact'); ?>">
                </div>
                <div class="col-lg-6">
                    <div class="section__header">
                        <span class="section__cate"><?php echo e(__(@$contact->data_values->title)); ?></span>
                        <h3 class="section__title"><?php echo e(__(@$contact->data_values->heading)); ?></h3>
                        <p>
                            <?php echo e(__(@$contact->data_values->sub_heading)); ?>

                        </p>
                    </div>
                    <form class="contact-form" action="" method="POST" class="verify-gcaptcha">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3">
                            <label><?php echo app('translator')->get('Your Name'); ?></label>
                            <input type="text" class="form-control form--control" name="name"
                                value="<?php echo e(old('name')); ?>" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label><?php echo app('translator')->get('Email Address'); ?></label>
                            <input type="text" class="form-control form--control" name="email"
                                value="<?php echo e(old('email')); ?>" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label><?php echo app('translator')->get('Subject'); ?></label>
                            <input type="text" class="form-control form--control" name="subject"
                                value="<?php echo e(old('subject')); ?>" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label><?php echo app('translator')->get('Your Message'); ?></label>
                            <textarea name="message" class="form-control form--control" name="message" required=""><?php echo e(old('message')); ?></textarea>
                        </div>
                        <?php if (isset($component)) { $__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243 = $component; } ?>
<?php $component = App\View\Components\Captcha::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('captcha'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Captcha::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243)): ?>
<?php $component = $__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243; ?>
<?php unset($__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243); ?>
<?php endif; ?>

                        <div class="form-group mt-2">
                            <button class="cmn--btn btn--lg rounded" type="submit"><?php echo app('translator')->get('Send Message'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/contact.blade.php ENDPATH**/ ?>