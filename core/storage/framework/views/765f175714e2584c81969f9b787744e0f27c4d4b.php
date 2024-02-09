<?php $__env->startSection('panel'); ?>
    <div class="row gy-4">
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--purple has-link box--shadow2">
                <a href="<?php echo e(route('staff.courier.sent.queue')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-hourglass-start f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get(' RDV en Cours'); ?></span>
                            <h2 class="text-white"><?php echo e($sentInQueue); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--cyan has-link box--shadow2">
                <a href="<?php echo e(route('staff.transactions.index')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-history f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Colis en Entrepot'); ?></span>
                            <h2 class="text-white"><?php echo e($upcomingCourier); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--primary has-link overflow-hidden box--shadow2">
                <a href="<?php echo e(route('staff.courier.dispatch')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-dolly f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Prochain RDV'); ?></span>
                            <h2 class="text-white"><?php echo e($sentInNext); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->





        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--pink has-link box--shadow2">
                <a href="<?php echo e(route('staff.courier.delivery.queue')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="lab la-accessible-icon f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get(' Delivery in Queue'); ?></span>
                            <h2 class="text-white"><?php echo e($deliveryInQueue); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--green has-link box--shadow2">
                <a href="<?php echo e(route('staff.courier.manage.sent.list')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-check-double f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Total sent'); ?></span>
                            <h2 class="text-white"><?php echo e($totalSent); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--deep-purple has-link box--shadow2">
                <a href="<?php echo e(route('staff.courier.manage.delivered')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las  la-list-alt f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Total Delivered'); ?></span>
                            <h2 class="text-white"><?php echo e($totalDelivery); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--lime has-link box--shadow2">
                <a href="<?php echo e(route('staff.branch.index')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-university f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get(' Total Agences'); ?></span>
                            <h2 class="text-white"><?php echo e($branchCount); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--orange has-link box--shadow2">
                <a href="<?php echo e(route('staff.cash.courier.income')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-money-bill-wave f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Total Cash Collection'); ?></span>
                            <h2 class="text-white"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($cashCollection)); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-4 col-sm-6">
            <div class="card bg--teal has-link box--shadow2">
                <a href="<?php echo e(route('staff.courier.manage.list')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las  la-shipping-fast f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('All Courier'); ?></span>
                            <h2 class="text-white"><?php echo e($totalCourier); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

    </div><!-- row end-->
    <div class="row mt-30 ">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-header mb-1">
                    <h6><?php echo app('translator')->get('Upcomming Courier'); ?></h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Sender Branch - Staff'); ?></th>
                                    <th><?php echo app('translator')->get('Receiver Branch - Staff'); ?></th>
                                    <th><?php echo app('translator')->get('Amount - Order Number'); ?></th>
                                    <th><?php echo app('translator')->get('Creations Date'); ?></th>
                                    <th><?php echo app('translator')->get('Payment Status'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $courierDelivery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courierInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                                            <span class="fw-bold"><?php echo e(getAmount($courierInfo->paymentInfo->final_amount)); ?>

                                                <?php echo e(__($general->cur_text)); ?></span><br>
                                            <span><?php echo e($courierInfo->code); ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo e(showDateTime($courierInfo->created_at, 'd M Y')); ?></span><br>
                                            <span><?php echo e(diffForHumans($courierInfo->created_at)); ?></span>
                                        </td>
                                        <td>
                                            <?php if(!$courierInfo->paymentInfo): ?>
                                                <span class="badge badge--danger"><?php echo app('translator')->get('Unpaid'); ?></span>
                                            <?php else: ?>
                                                <?php if($courierInfo->paymentInfo->status == Status::PAID): ?>
                                                    <span class="badge badge--success"><?php echo app('translator')->get('Paid'); ?></span>
                                                <?php elseif($courierInfo->paymentInfo->status == Status::UNPAID): ?>
                                                    <span class="badge badge--danger"><?php echo app('translator')->get('Unpaid'); ?></span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($courierInfo->status == Status::COURIER_QUEUE): ?>
                                                <span class="badge badge--primary"><?php echo app('translator')->get('Received'); ?></span>
                                            <?php elseif($courierInfo->status == Status::COURIER_DISPATCH): ?>
                                                <span class="badge badge--"><?php echo app('translator')->get('Sent'); ?></span>
                                            <?php elseif($courierInfo->status == Status::COURIER_UPCOMING): ?>
                                                <span class="badge badge--warning"><?php echo app('translator')->get('Upcomming'); ?></span>
                                            <?php elseif($courierInfo->status == Status::COURIER_DELIVERED): ?>
                                                <span class="badge badge--success"><?php echo app('translator')->get('Delivered'); ?></span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php if($courierInfo->status == Status::COURIER_DELIVERYQUEUE &&
                                                $courierInfo->paymentInfo->status == Status::COURIER_UPCOMING): ?>
                                                <a href="javascript:void(0)" title=""
                                                    class="btn btn-sm btn-outline--secondary  delivery"
                                                    data-code="<?php echo e($courierInfo->code); ?>"><i class="las la-truck"></i>
                                                    <?php echo app('translator')->get('Delivery'); ?></a>
                                            <?php endif; ?>
                                            <?php if($courierInfo->status == Status::COURIER_DELIVERYQUEUE &&
                                                $courierInfo->paymentInfo->status == Status::COURIER_QUEUE): ?>
                                                <a href="javascript:void(0)" title=""
                                                    class="btn btn-sm btn-outline--success  payment"
                                                    data-code="<?php echo e($courierInfo->code); ?>"><i
                                                        class="las la-credit-card"></i>
                                                    <?php echo app('translator')->get('Payment'); ?></a>
                                            <?php endif; ?>
                                            <a href="<?php echo e(route('staff.courier.invoice', encrypt($courierInfo->id))); ?>"
                                                title="" class="btn btn-sm btn-outline--info "><i
                                                    class="las la-file-invoice"></i> <?php echo app('translator')->get('Invoice'); ?></a>
                                            <a href="<?php echo e(route('staff.courier.details', encrypt($courierInfo->id))); ?>"
                                                title="" class="btn btn-sm btn-outline--primary "> <i
                                                    class="las la-info-circle"></i><?php echo app('translator')->get('Details'); ?></a>
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
            </div>
        </div>
    </div>


    <div class="modal fade" id="paymentBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="" lass="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('Payment Confirmation'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('staff.courier.payment')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('POST'); ?>
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p><?php echo app('translator')->get('Are you sure to collect this amount?'); ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php echo app('translator')->get('No'); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Yes'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deliveryBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="" lass="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('Delivery Confirmation'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
                </div>
                <form action="<?php echo e(route('staff.courier.delivery')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('POST'); ?>
                    <input type="hidden" name="code">
                    <div class="modal-body">
                        <p><?php echo app('translator')->get('Are you sure to delivery this courier?'); ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Confirm'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('breadcrumb-plugins'); ?>
    <div class="d-flex flex-wrap justify-content-end">
        <h3><?php echo e(__(auth()->user()->branch->name)); ?></h3>
    </div>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        (function() {
            'use strict';
            $('.payment').on('click', function() {
                var modal = $('#paymentBy');
                modal.find('input[name=code]').val($(this).data('code'))
                modal.modal('show');
            });

            $('.delivery').on('click', function() {
                var modal = $('#deliveryBy');
                modal.find('input[name=code]').val($(this).data('code'))
                modal.modal('show');
            });
        })(jQuery())
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/dashboard.blade.php ENDPATH**/ ?>