<?php $__env->startSection('content'); ?>
    <div class="contact-section pt-120 pb-120">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 d-none d-lg-block rtl pe-xxl-50">
                    <img src="<?php echo e(getImage('assets/images/frontend/contact_us/'. @$contact->data_values->contact_image, '653x612')); ?>" alt="<?php echo app('translator')->get('contact'); ?>">
                </div>
                <div class="col-lg-6">
                    <div class="section__header">
                        <span class="section__cate"><?php echo e(__(@$contact->data_values->title)); ?></span>
                        <h3 class="section__title"><?php echo e(__(@$contact->data_values->heading)); ?></h3>
                        <p>
                            <?php echo e(__(@$contact->data_values->sub_heading)); ?>

                        </p>
                    </div>
                    <form class="contact-form" action="" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3">
                            <label for="name" class="form--label"><?php echo app('translator')->get('Votre Nom'); ?></label>
                            <input type="text" class="form-control form--control" id="name" name="name" value="<?php echo e(old('name')); ?>" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="form--label"><?php echo app('translator')->get('Votre Contact'); ?></label>
                            <input type="text" class="form-control form--control" id="contact" name="contact" value="<?php echo e(old('contact')); ?>" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form--label"><?php echo app('translator')->get('Email'); ?></label>
                            <input type="text" class="form-control form--control" id="email" name="email" value="<?php echo e(old('email')); ?>" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="subject" class="form--label"><?php echo app('translator')->get('Objet'); ?></label>
                            <input type="text" class="form-control form--control" id="subject" name="subject" value="<?php echo e(old('subject')); ?>" required="">
                        </div>
                        <div class="form-group mb-3">
                            <label for="message" class="form--label"><?php echo app('translator')->get('Votre Message'); ?></label>
                            <textarea name="message" class="form-control form--control" id="message" name="message" required=""><?php echo e(old('message')); ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                <label for="capatcha">Captcha</label>
                <div class="captcha">
                </div>
               
                <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="alert alert-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
                       
                        <div class="form-group">
                            <button class="cmn--btn btn--lg rounded" type="submit"><?php echo app('translator')->get('Envoyer Message'); ?></button>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate.'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/contact.blade.php ENDPATH**/ ?>