<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Subject'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Priority'); ?></th>
                                    <th><?php echo app('translator')->get('Last Reply'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $supports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $support): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td> <a href="<?php echo e(route('staff.ticket.view', $support->ticket)); ?>" class="fw-bold">
                                                [<?php echo app('translator')->get('Ticket'); ?>#<?php echo e($support->ticket); ?>] <?php echo e(__($support->subject)); ?> </a>
                                        </td>
                                        <td>
                                            <?php echo $support->statusBadge; ?>
                                        </td>
                                        <td>
                                            <?php if($support->priority == Status::PRIORITY_LOW): ?>
                                                <span class="badge badge--dark"><?php echo app('translator')->get('Low'); ?></span>
                                            <?php elseif($support->priority == Status::PRIORITY_MEDIUM): ?>
                                                <span class="badge  badge--warning"><?php echo app('translator')->get('Medium'); ?></span>
                                            <?php elseif($support->priority == Status::PRIORITY_HIGH): ?>
                                                <span class="badge badge--danger"><?php echo app('translator')->get('High'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td> <?php echo e(diffForHumans($support->last_reply)); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('staff.ticket.view', $support->ticket)); ?>"
                                                class="btn btn-sm btn-outline--primary">
                                                <i class="las la-desktop"></i><?php echo app('translator')->get('Details'); ?>
                                            </a>
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

                <?php if($supports->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($supports)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('breadcrumb-plugins'); ?>
    <a href="<?php echo e(route('staff.ticket.open')); ?>" class="btn btn-sm btn-outline--primary">
        <i class="las la-plus"></i><?php echo app('translator')->get('Create Ticket'); ?>
     </a>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/support/index.blade.php ENDPATH**/ ?>