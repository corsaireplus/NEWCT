<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body">
                <form action="<?php echo e(route('staff.mission.store')); ?>" method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                       

                        <div class="form-group col-md-6">
                            <label><?php echo app('translator')->get('Date Programme'); ?></label>
                            <input type="date" name="date" value="<?php echo e(old('Date Programme')); ?>" data-language="en" class="form-control datepicker-here form-control-lg" placeholder="<?php echo app('translator')->get('Date Programme'); ?>" required="">
                        </div>
                        <div class="form-group col-md-4">
                            <label><?php echo app('translator')->get('Chauffeur'); ?></label>
                            <select name="id_chauffeur" class="form-control select3" required="">
                                <?php $__currentLoopData = $chauffeur; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>"><?php echo e($type->firstname); ?> <?php echo e($type->lastname); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label> </label>
                            <span class="btn addUnit chauffeur btn--primary btn-block">Ajouter chauffeur</span>
                        </div>
                       
                    </div>
                    <div class="row">
                       

                        <div class="form-group col-md-6">
                            <label for="website"><?php echo app('translator')->get('Camion'); ?></label>
                            <input type="text" name="camion" value="<?php echo e(old('Camion')); ?>" data-language="en" class="form-control form-control-lg" placeholder="<?php echo app('translator')->get('Camion'); ?>" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="priority"><?php echo app('translator')->get('Chargeur'); ?></label>
                            <select name="id_chargeur" class="form-control form-control-lg select3" required="">
                                <?php $__currentLoopData = $chargeur; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>"><?php echo e($type->firstname); ?> <?php echo e($type->lastname); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                       
                    </div>
                    <div class="row">
                    <div class="form-group col-md-6">
                            <label for="website"><?php echo app('translator')->get('Contact Chargeur'); ?></label>
                            <input type="text" name="contact" value="<?php echo e(old('contact')); ?>" data-language="en" class="form-control form-control-lg" placeholder="<?php echo app('translator')->get('Contact Chargeur'); ?>" required="">
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="row form-group">
                        <div class="form-group col-lg-12">
                            <label for="inputMessage"><?php echo app('translator')->get('Observation'); ?></label>
                            <textarea name="message" id="inputMessage" rows="6" class="form-control form-control-lg" placeholder="<?php echo app('translator')->get('Observation ou Note'); ?>"><?php echo e(old('message')); ?></textarea>
                        </div>
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

<div id="unitModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Ajouter Chauffeur'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('staff.mission.store_chauffeur')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="fname" class="form-control-label font-weight-bold"><?php echo app('translator')->get('Name'); ?></label>
                            <input type="text" class="form-control form-control-lg" name="fname" placeholder="<?php echo app('translator')->get("Nom"); ?>"  maxlength="40" required="">
                        </div>

                        <div class="form-group">
                            <label for="lname" class="form-control-label font-weight-bold"><?php echo app('translator')->get('Name'); ?></label>
                            <input type="text" class="form-control form-control-lg" name="lname" placeholder="<?php echo app('translator')->get("Prenom"); ?>"  maxlength="40" required="">
                        </div>

                        <div class="form-group">
                            <label for="price" class="form-control-label font-weight-bold"><?php echo app('translator')->get('Contact'); ?></label>
                            <div class="input-group mb-3">
                                  <input type="text" id="mobile" class="form-control form-control-lg" placeholder="<?php echo app('translator')->get('Contact'); ?>" name="mobile" aria-label="" aria-describedby="basic-addon2" required="">
                                  
                            </div>
                        </div>

                        

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn--primary"><i class="fa fa-fw fa-paper-plane"></i><?php echo app('translator')->get('Ajouter'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.back','data' => ['route' => ''.e(route('staff.mission.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => ''.e(route('staff.mission.index')).'']); ?>
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
<?php $__env->startPush('script'); ?>
<script>
    $(document).ready(function() {

        $('.select3').select2({
            allowClear: true,
            tags: true,
            placeholder: "Choisir Ajouter"
        });

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
        $('.addUnit').on('click', function() {
        $('#unitModel').modal('show');
            });
        if (!$('.datepicker-here').val()) {
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/missions/create.blade.php ENDPATH**/ ?>