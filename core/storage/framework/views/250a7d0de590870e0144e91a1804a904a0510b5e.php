<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('ID'); ?></th>
                                    <th><?php echo app('translator')->get('Date'); ?></th>
                                    <th><?php echo app('translator')->get('Income'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $branchIncomeLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branchIncome): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold"><?php echo e($loop->iteration); ?></span>
                                        </td>
                                        <td>
                                            <span class="fw-bold"><?php echo e(showDateTime($branchIncome->date, 'd M Y')); ?></span>
                                        </td>
                                        <td>
                                            <span class="fw-bold"><?php echo e(showAmount($branchIncome->totalAmount)); ?>

                                                <?php echo e(__($general->cur_text)); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if($branchIncomeLists->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($branchIncomeLists)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/courier/cash.blade.php ENDPATH**/ ?>