<?php $__env->startSection('panel'); ?>
 <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <form action="<?php echo e(route('staff.transactions.livraison_validate')); ?>" method="POST">
                  <input type="hidden" name="colis_id" value="<?php echo e($courierInfo->id); ?>">
                    <input type="hidden" name="container_id" value="<?php echo e($ct); ?>">
                    <div class="card-body">
                        <?php echo csrf_field(); ?>
                       
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card border--primary mt-3">
                                    <h5 class="card-header bg--primary  text-white"><?php echo app('translator')->get('Livraison Information'); ?></h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label><?php echo app('translator')->get('Nom'); ?></label>
                                                <input type="text" class="form-control" name="nom"
                                                    value="<?php echo e(old('nom')); ?>" id="nom" required>
                                            </div>
                                            <div class=" form-group col-lg-6">
                                                <label><?php echo app('translator')->get('Telephone'); ?></label>
                                                <input type="text" class="form-control" name="telephone"
                                                    value="<?php echo e(old('telephone')); ?>" id="telephone" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label><?php echo app('translator')->get('Nature & Numero piece'); ?></label>
                                                <input type="text" class="form-control" name="piece_id"
                                                    value="<?php echo e(old('piece_id')); ?>" required>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label><?php echo app('translator')->get('Description'); ?></label>
                                                <input type="text" class="form-control" name="description"
                                                    value="<?php echo e(old('description')); ?>" required>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>

                            </div>
                        </div>

                        </div>
                        <button type="submit" class="btn btn--primary h-45 w-100 Submitbtn"> <?php echo app('translator')->get('Valider Livraison'); ?></button>

                </form>
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

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/transactions/livraison.blade.php ENDPATH**/ ?>