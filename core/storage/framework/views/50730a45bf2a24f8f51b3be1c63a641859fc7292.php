<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="show-filter mb-3 text-end">
                <button type="button" class="btn btn-outline--primary showFilterBtn btn-sm"><i class="las la-filter"></i> <?php echo app('translator')->get('Filter'); ?></button>
            </div>
            <div class="card responsive-filter-card b-radius--10 mb-3">
                <div class="card-body">
                    <form action="">
                        <div class="d-flex flex-wrap gap-4">
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Search'); ?></label>
                                <input type="text" name="search" value="<?php echo e(request()->search); ?>" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Staus'); ?></label>
                                <select name="status" class="form-control">
                                    <option value=""><?php echo app('translator')->get('All'); ?></option>
                                    <option value="0"><?php echo app('translator')->get('Queue'); ?></option>
                                    <option value="1"><?php echo app('translator')->get('Dispatch'); ?></option>
                                    <option value="1"><?php echo app('translator')->get('Upcomming'); ?></option>
                                    <option value="2"><?php echo app('translator')->get('Received'); ?></option>
                                    <option value="3"><?php echo app('translator')->get('Delevered'); ?></option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Payment Status'); ?></label>
                                <select name="payment_status" class="form-control">
                                    <option value=""><?php echo app('translator')->get('All'); ?></option>
                                    <option value="1"><?php echo app('translator')->get('Paid'); ?></option>
                                    <option value="0"><?php echo app('translator')->get('Unpaid'); ?></option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Date'); ?></label>
                                <input name="date" type="text" class="date form-control" placeholder="<?php echo app('translator')->get('Start date - End date'); ?>" autocomplete="off" value="<?php echo e(request()->date); ?>">
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> <?php echo app('translator')->get('Filter'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Sender Branch - Staff'); ?></th>
                                    <th><?php echo app('translator')->get('Receiver Branch - Staff'); ?></th>
                                    <th><?php echo app('translator')->get('Amount - Order Number'); ?></th>
                                    <th><?php echo app('translator')->get('Creations Date'); ?></th>
                                    <th><?php echo app('translator')->get('Estimate Delivery Date'); ?></th>
                                    <th><?php echo app('translator')->get('Payment Status'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $courierLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courierInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span><?php echo e(__($courierInfo->senderBranch->name)); ?></span><br>
                                            <?php echo e(__($courierInfo->senderStaff->fullname)); ?>

                                        </td>
                                        <td>
                                            <span>
                                                <?php if($courierInfo->receiver_branch_id): ?>
                                                    <?php echo e(__($courierInfo->receiverBranch->name)); ?>

                                                <?php else: ?>
                                                    <?php echo app('translator')->get('N/A'); ?>
                                                <?php endif; ?>
                                            </span>
                                            <br>
                                            <?php if($courierInfo->receiver_staff_id): ?>
                                                <?php echo e(__($courierInfo->receiverStaff->fullname)); ?>

                                            <?php else: ?>
                                                <span><?php echo app('translator')->get('N/A'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="fw-bold d-block">
                                                <?php echo e(showAmount(@$courierInfo->paymentInfo->final_amount)); ?>

                                                <?php echo e(__($general->cur_text)); ?>

                                            </span>
                                            <span><?php echo e($courierInfo->code); ?></span>
                                        </td>
                                        <td><?php echo e(showDateTime($courierInfo->created_at, 'd M Y')); ?></td>
                                        <td><?php echo e(showDateTime($courierInfo->estimate_date, 'd M Y')); ?></td>
                                        <td>
                                            <?php if(@$courierInfo->paymentInfo->status == Status::PAID): ?>
                                                <span class="badge badge--success"><?php echo app('translator')->get('Paid'); ?></span>
                                            <?php elseif(@$courierInfo->paymentInfo->status == Status::UNPAID): ?>
                                                <span class="badge badge--danger"><?php echo app('translator')->get('Unpaid'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($courierInfo->status == Status::COURIER_QUEUE): ?>
                                                <span class="badge badge--warning"><?php echo app('translator')->get('Sent in queue'); ?></span>
                                            <?php elseif($courierInfo->status == Status::COURIER_DISPATCH): ?>
                                                <?php if(auth()->user()->branch_id == $courierInfo->sender_branch_id): ?>
                                                    <span class="badge badge--warning"><?php echo app('translator')->get('Dispatch'); ?></span>
                                                <?php else: ?>
                                                    <span class="badge badge--primary"><?php echo app('translator')->get('Upcoming'); ?></span>
                                                <?php endif; ?>
                                            <?php elseif($courierInfo->status == Status::COURIER_DELIVERYQUEUE): ?>
                                                <span class="badge badge--danger"><?php echo app('translator')->get('Delivery in queue'); ?></span>
                                            <?php elseif($courierInfo->status == Status::COURIER_DELIVERED): ?>
                                                <span class="badge badge--success"><?php echo app('translator')->get('Delivery'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('staff.courier.invoice', encrypt($courierInfo->id))); ?>"
                                                title="" class="btn btn-sm btn-outline--info"><i
                                                    class="las la-file-invoice"></i> <?php echo app('translator')->get('Invoice'); ?></a>
                                            <a href="<?php echo e(route('staff.courier.details', encrypt($courierInfo->id))); ?>"
                                                title="" class="btn btn-sm btn-outline--primary"><i
                                                    class="las la-info-circle"></i> <?php echo app('translator')->get('Details'); ?></a>
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

                <?php if($courierLists->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($courierLists)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/viseradmin/css/vendor/datepicker.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/viseradmin/js/vendor/datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/viseradmin/js/vendor/datepicker.en.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $('.date').datepicker({
                maxDate:new Date(),
                range:true,
                multipleDatesSeparator:"-",
                language:'en'
            });

            let url=new URL(window.location).searchParams;
            if(url.get('status') != undefined && url.get('status') != ''){
                $('select[name=status]').find(`option[value=${url.get('status')}]`).attr('selected',true);
            }
            if(url.get('payment_status') != undefined && url.get('payment_status') != ''){
                $('select[name=payment_status]').find(`option[value=${url.get('payment_status')}]`).attr('selected',true);
            }

        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/courier/list.blade.php ENDPATH**/ ?>