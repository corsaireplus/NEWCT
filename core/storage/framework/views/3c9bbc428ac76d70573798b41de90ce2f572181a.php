<?php $__env->startSection('panel'); ?>
<div class="row mb-none-30">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body">
                <form action="<?php echo e(route('staff.conteneurs.store')); ?>" method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="website"><?php echo app('translator')->get('Date Depart'); ?></label>
                            <input type="text" name="date" value="<?php echo e(old('Date Depart')); ?>" data-language="en" class="form-control datepicker-here  form-control-lg" placeholder="<?php echo app('translator')->get('Date Depart'); ?>" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="website"><?php echo app('translator')->get('Date Arrivée'); ?></label>
                            <input type="text" name="date_arrivee" value="<?php echo e(old('Date Depart')); ?>" data-language="en" class="form-control datepicker-here  form-control-lg" placeholder="<?php echo app('translator')->get('Date Arrivée'); ?>" required="">
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="website"><?php echo app('translator')->get('Armarteur'); ?></label>
                            <input type="text" name="armateur" value="<?php echo e(old('Armarteur')); ?>" data-language="en" class="form-control form-control-lg" placeholder="<?php echo app('translator')->get('Armarteur'); ?>" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="website"><?php echo app('translator')->get('Numero Conteneur'); ?></label>
                            <input type="text" name="numero" value="<?php echo e(old('Numero Conteneur')); ?>" data-language="en" class="form-control form-control-lg" placeholder="<?php echo app('translator')->get('Numero Conteneur'); ?>" required="">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="inputMessage"><?php echo app('translator')->get('Observation'); ?></label>
                            <textarea name="message" id="observation" rows="6" class="form-control form-control-lg" placeholder="<?php echo app('translator')->get('Observation ou Note'); ?>"><?php echo e(old('message')); ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6">
                            <label for="priority"><?php echo app('translator')->get('Destination'); ?></label>
                            <select name="desti_id" class="form-control form-control-lg">
                                <?php $__currentLoopData = $branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                    </div>


                    <div class="form-group">
                        <button type="submit" class="btn btn--primary btn-block" id="recaptcha"><i class="fa fa-fw fa-paper-plane"></i> <?php echo app('translator')->get('Enregistrer'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.back','data' => ['route' => ''.e(url()->previous()).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => ''.e(url()->previous()).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-lib'); ?>
<script src="<?php echo e(asset('assets/viseradmin/js/vendor/datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/viseradmin/js/vendor/datepicker.en.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>s
<script>
    $(document).ready(function() {

        $('#country_name').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "<?php echo e(route('staff.mission.fetch')); ?>",
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#countryList').fadeIn();
                        $('#countryList').html(data);
                    }
                });
            }
        });

        $(document).on('click', 'li', function() {
            $('#country_name').val($(this).text());
            $('#countryList').fadeOut();
        });

    });
    (function($) {
        "use strict";
        if (!$('.datepicker-here').val()) {
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/container/create.blade.php ENDPATH**/ ?>