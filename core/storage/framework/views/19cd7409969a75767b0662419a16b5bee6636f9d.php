<?php $__env->startSection('panel'); ?>
    <div class="card">
        <div class="card-body">
            <div id="printInvoice">
                <div class="content-header">
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">
                            <?php echo app('translator')->get('Invoice Number'); ?>:
                            <small>#<?php echo e($courierInfo->invoice_id); ?></small>
                            <br>
                            <?php echo app('translator')->get('Date'); ?>:
                            <?php echo e(showDateTime($courierInfo->created_at, 'd M Y')); ?>

                            <br>
                            <?php echo app('translator')->get('Estimate Delivery Date'); ?>:
                            <?php echo e(showDateTime($courierInfo->estimate_date, 'd M Y')); ?>

                        </div>
                        <div>
                        </div>
                    </div>
                </div>

                <div class="invoice">
                    <div class="d-flex justify-content-between mt-3">
                        <div class="text-center">
                            <?php
                                echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($courierInfo->code, 'C128') . '" alt="barcode" />';
                            ?>
                            <br>
                            <span><?php echo e($courierInfo->code); ?></span>
                        </div>
                        <div>
                            <b><?php echo app('translator')->get('Order Id'); ?>:</b> <?php echo e($courierInfo->code); ?><br>
                            <b><?php echo app('translator')->get('Payment Status'); ?>:</b>
                            <?php if($courierInfo->payment->status == Status::PAID): ?>
                                <span class="badge badge--success"><?php echo app('translator')->get('Paid'); ?></span>
                            <?php else: ?>
                                <span class="badge badge--danger"><?php echo app('translator')->get('Unpaid'); ?></span>
                            <?php endif; ?>
                            <br>
                            <b><?php echo app('translator')->get('Sender Branch'); ?>:</b> <?php echo e(__($courierInfo->senderBranch->name)); ?><br>
                            <b><?php echo app('translator')->get('Receiver Branch'); ?>:</b> <?php echo e(__($courierInfo->receiverBranch->name)); ?>

                        </div>
                    </div>
                    <hr>
                    <div class="invoice-info d-flex justify-content-between">
                        <div>
                            <?php echo app('translator')->get('From'); ?>
                            <address>
                                <strong><?php echo e(__(@$courierInfo->senderCustomer->fullname)); ?></strong><br>
                                <?php echo app('translator')->get('City'); ?>: <?php echo e(__(@$courierInfo->senderCustomer->city)); ?><br>
                                <?php echo app('translator')->get('State'); ?>: <?php echo e(__(@$courierInfo->senderCustomer->state)); ?><br>
                                <?php echo app('translator')->get('Address'); ?>: <?php echo e(__($courierInfo->senderCustomer->address)); ?><br>
                                <?php echo app('translator')->get('Phone'); ?>: <?php echo e(@$courierInfo->senderCustomer->mobile); ?><br>
                                <?php echo app('translator')->get('Email'); ?>: <?php echo e(@$courierInfo->senderCustomer->email); ?>

                            </address>
                        </div>
                        <div>
                            <?php echo app('translator')->get('To'); ?>
                            <address>
                                <strong><?php echo e(__(@$courierInfo->receiverCustomer->fullname)); ?></strong><br>
                                <?php echo app('translator')->get('City'); ?>: <?php echo e(__(@$courierInfo->receiverCustomer->city)); ?><br>
                                <?php echo app('translator')->get('State'); ?>: <?php echo e(__(@$courierInfo->receiverCustomer->state)); ?><br>
                                <?php echo app('translator')->get('Address'); ?>: <?php echo e(__(@$courierInfo->receiverCustomer->address)); ?><br>
                                <?php echo app('translator')->get('Phone'); ?>: <?php echo e(@$courierInfo->receiverCustomer->mobile); ?><br>
                                <?php echo app('translator')->get('Email'); ?>: <?php echo e(@$courierInfo->receiverCustomer->email); ?>

                            </address>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo app('translator')->get('Courier Type'); ?></th>
                                        <th><?php echo app('translator')->get('Price'); ?></th>
                                        <th><?php echo app('translator')->get('Qty'); ?></th>
                                        <th><?php echo app('translator')->get('Subtotal'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $courierInfo->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courierProductInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e(__(@$courierProductInfo->type->name)); ?></td>
                                            <td><?php echo e($general->cur_sym); ?><?php echo e(showAmount($courierProductInfo->fee)); ?></td>
                                            <td><?php echo e($courierProductInfo->qty); ?> <?php echo e(__(@$courierProductInfo->type->unit->name)); ?></td>
                                            <td><?php echo e($general->cur_sym); ?><?php echo e(showAmount($courierProductInfo->fee)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-30 mb-none-30">
                        <div class="col-lg-12 mb-30">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th><?php echo app('translator')->get('Subtotal'); ?>:</th>
                                            <td><?php echo e($general->cur_sym); ?><?php echo e(showAmount($courierInfo->payment->amount)); ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo app('translator')->get('Discount'); ?>:</th>
                                            <td><?php echo e($general->cur_sym); ?><?php echo e(showAmount($courierInfo->payment->discount)); ?>

                                                <small class="text--danger">
                                                    (<?php echo e(getAmount($courierInfo->payment->percentage)); ?>%)
                                                </small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo app('translator')->get('Total'); ?>:</th>
                                            <td><?php echo e($general->cur_sym); ?><?php echo e(showAmount($courierInfo->payment->final_amount)); ?>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row no-print">
                <div class="col-sm-12">
                    <div class="float-sm-end">
                        <?php if(!$courierInfo->paymentInfo): ?>
                            <td><?php echo app('translator')->get('Unpaid'); ?></td>
                        <?php else: ?>
                            <?php if($courierInfo->status == Status::UNPAID && $courierInfo->paymentInfo->status == Status::UNPAID): ?>
                                <button type="button" class="btn btn-outline--success m-1 payment"
                                    data-code="<?php echo e($courierInfo->code); ?>">
                                    <i class="fa fa-credit-card"></i> <?php echo app('translator')->get('Make Payment'); ?>
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>

                        <button class="btn btn-outline--primary m-1 printInvoice">
                            <i class="las la-download"></i><?php echo app('translator')->get('Print'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="paymentBy" tabindex="-1" role="dialog" a>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="" lass="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('Payment Confirmation'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal">
                        <i class="las la-times"></i> </button>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $('.printInvoice').click(function() {
                $("#printInvoice").printThis();
            });
            $('.payment').on('click', function() {
                var modal = $('#paymentBy');
                modal.find('input[name=code]').val($(this).data('code'))
                modal.modal('show');
            });
        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/invoice.blade.php ENDPATH**/ ?>