<?php $__env->startSection('panel'); ?>
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <form action="<?php echo e(route('staff.courier.update',encrypt($courierInfo->id))); ?>" method="POST">
                <div class="card-body">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-6 form-group">
                            <label for=""><?php echo app('translator')->get('Estimate Date'); ?></label>
                            <div class="input-group">
                                <input name="estimate_date" value="<?php echo e(showDateTime($courierInfo->estimate_date,'Y-m-d')); ?>" type="text" autocomplete="off"  class="form-control date" placeholder="Estimate Delivery Date" required>
                                <span class="input-group-text"><i class="las la-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-6 form-group">
                            <label for=""><?php echo app('translator')->get('Payment Status'); ?></label>
                            <div class="input-group">
                                <select class="form-control" required name="payment_status">
                                    <?php if(!$courierInfo->paymentInfo): ?>
                                        <option value="0" selected><?php echo app('translator')->get('UNPAID'); ?></option>
                                    <?php else: ?>
                                        <option value="0" <?php if($courierInfo->payment->status == Status::UNPAID): echo 'selected'; endif; ?>><?php echo app('translator')->get('UNPAID'); ?></option>
                                        <option value="1" <?php if($courierInfo->payment->status == Status::PAID): echo 'selected'; endif; ?>><?php echo app('translator')->get('PAID'); ?></option>
                                    <?php endif; ?>
                                </select>
                                <span class="input-group-text"><i class="las la-money-bill-wave-alt"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white"><?php echo app('translator')->get('Sender Information'); ?></h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Email'); ?></label>
                                            <input type="email" class="form-control" name="sender_customer_email" value="<?php echo e(@$courierInfo->senderCustomer->email); ?>" required>
                                        </div>
                                        <div class=" form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Phone'); ?></label>
                                            <input type="text" class="form-control" value="<?php echo e(@$courierInfo->senderCustomer->mobile); ?>" name="sender_customer_phone" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('First Name'); ?></label>
                                            <input type="text" class="form-control" name="sender_customer_firstname" value="<?php echo e($courierInfo->senderCustomer->firstname); ?>" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Last Name'); ?></label>
                                            <input type="text" class="form-control" name="sender_customer_lastname" value="<?php echo e($courierInfo->senderCustomer->lastname); ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('City'); ?></label>
                                            <input type="text" class="form-control" name="sender_customer_city"
                                                value="<?php echo e(@$courierInfo->senderCustomer->city); ?>" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('State'); ?></label>
                                            <input type="text" class="form-control" name="sender_customer_state"
                                                value="<?php echo e(@$courierInfo->senderCustomer->state); ?>" required>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label><?php echo app('translator')->get('Address'); ?></label>
                                            <input type="text" class="form-control" name="sender_customer_address"
                                                value="<?php echo e($courierInfo->senderCustomer->address); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white"><?php echo app('translator')->get('Receiver Information'); ?></h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Email'); ?></label>
                                            <input type="email" class="form-control" name="receiver_customer_email"
                                                value="<?php echo e(@$courierInfo->receiverCustomer->email); ?>" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Phone'); ?></label>
                                            <input type="text" class="form-control" name="receiver_customer_phone"
                                                value="<?php echo e(@$courierInfo->receiverCustomer->mobile); ?>" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('First Name'); ?></label>
                                            <input type="text" class="form-control" name="receiver_customer_firstname"
                                                value="<?php echo e($courierInfo->receiverCustomer->firstname); ?>" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Last Name'); ?></label>
                                            <input type="text" class="form-control" name="receiver_customer_lastname"
                                                value="<?php echo e($courierInfo->receiverCustomer->lastname); ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('City'); ?></label>
                                            <input type="text" class="form-control" name="receiver_customer_city"
                                                value="<?php echo e(@$courierInfo->receiverCustomer->city); ?>" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('State'); ?></label>
                                            <input type="text" class="form-control" name="receiver_customer_state"
                                                value="<?php echo e(@$courierInfo->receiverCustomer->state); ?>" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Address'); ?></label>
                                            <input type="text" class="form-control" name="receiver_customer_address"
                                                value="<?php echo e(@$courierInfo->receiverCustomer->address); ?>" required>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Select Branch'); ?></label>
                                            <select class="form-control" name="branch" required>
                                                <option value><?php echo app('translator')->get('Select One'); ?></option>
                                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($branch->id); ?>" <?php if($courierInfo->receiver_branch_id==$branch->id): echo 'selected'; endif; ?>><?php echo e(__($branch->name)); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary text-white"><?php echo app('translator')->get('Courier Information'); ?>
                                    <button type="button" class="btn btn-sm btn-outline-light float-end addUserData"><i
                                            class="la la-fw la-plus"></i><?php echo app('translator')->get('Add New One'); ?>
                                    </button>
                                </h5>
                                <div class="card-body">
                                    <div class="row" id="addedField">
                                        <?php $__currentLoopData = $courierInfo->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="row single-item gy-2">
                                                <div class="col-md-2">
                                                    <select class="form-control selected_type" name="items[<?php echo e($loop->index); ?>][type]" required>
                                                        <option disabled selected value=""><?php echo app('translator')->get('Select Courier/Parcel Type'); ?></option>
                                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($type->id); ?>" <?php if($item->type->id==$type->id): echo 'selected'; endif; ?>
                                                                data-unit="<?php echo e($type->unit->name); ?>" data-price="<?php echo e(getAmount($type->price)); ?>"  >
                                                                <?php echo e(__($type->name)); ?>

                                                            </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control" placeholder="<?php echo app('translator')->get('Courier/Parcel Name'); ?>"
                                                            name="items[<?php echo e($loop->index); ?>][name]" value="<?php echo e($item->parcel_name); ?>">
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control quantity" value="<?php echo e($item->qty); ?>"  name="items[<?php echo e($loop->index); ?>][quantity]"  required>
                                                        <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <input type="text"  class="form-control single-item-amount" value="<?php echo e(getAmount($item->fee)); ?>"  name="items[<?php echo e($loop->index); ?>][amount]" required readonly>
                                                        <span class="input-group-text"><?php echo e(__($general->cur_text)); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
 						                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <div class="border-line-area">
                                        <h6 class="border-line-title"><?php echo app('translator')->get('Summary'); ?></h6>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <span class="input-group-text"><?php echo app('translator')->get('Discount'); ?></span>
                                                <?php if(!$courierInfo->paymentInfo): ?>
                                                    <p><?php echo app('translator')->get('Unpaid'); ?></p>
                                                <?php else: ?>
                                                    <input type="number" name="discount"  class="form-control bg-white text-dark discount" value="<?php echo e($courierInfo->payment->percentage); ?>">
                                                    <span class="input-group-text">%</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" d-flex justify-content-end mt-2">
                                        <div class="col-md-3  d-flex justify-content-between">
                                            <span class="fw-bold"><?php echo app('translator')->get('Subtotal'); ?>:</span>
                                            <div><?php echo e($general->cur_sym); ?><span class="subtotal"><?php echo e(showAmount(@$courierInfo->payment->amount)); ?></span></div>
                                        </div>
                                    </div>
                                    <div class=" d-flex justify-content-end mt-2">
                                        <div class="col-md-3  d-flex justify-content-between">
                                            <span class="fw-bold"><?php echo app('translator')->get('Total'); ?>:</span>
                                            <div> <?php echo e($general->cur_sym); ?><span class="total"><?php echo e(showAmount(@$courierInfo->payment->final_amount)); ?></span></div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn--primary h-45 w-100 Submitbtn"> <?php echo app('translator')->get('Submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/viseradmin/js/vendor/datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/viseradmin/js/vendor/datepicker.en.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link  rel="stylesheet" href="<?php echo e(asset('assets/viseradmin/css/vendor/datepicker.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
    "use strict";
    (function ($) {


        $('.addUserData').on('click', function () {
            let length=$("#addedField").find('.single-item').length;
            let html = `
            <div class="row single-item gy-2">
                <div class="col-md-2">
                    <select class="form-control selected_type" name="items[${length}][type]" required>
                        <option disabled selected value=""><?php echo app('translator')->get('Select Courier/Parcel Type'); ?></option>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type->id); ?>" data-unit="<?php echo e($type->unit->name); ?>" data-price=<?php echo e(getAmount($type->price)); ?> ><?php echo e(__($type->name)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="<?php echo app('translator')->get('Courier/Parcel Name'); ?>"  name="items[${length}][name]">
                </div>
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <input type="number" class="form-control quantity" placeholder="<?php echo app('translator')->get('Quantity'); ?>" disabled name="items[${length}][quantity]"  required>
                        <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text"  class="form-control single-item-amount" placeholder="<?php echo app('translator')->get('Enter Price'); ?>" name="items[${length}][amount]" required readonly>
                        <span class="input-group-text"><?php echo e(__($general->cur_text)); ?></span>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>`;
            $('#addedField').append(html)
        });

        $('#addedField').on('change', '.selected_type', function (e) {
            let unit = $(this).find('option:selected').data('unit');
            let parent = $(this).closest('.single-item');
            $(parent).find('.quantity').attr('disabled', false);
            $(parent).find('.unit').html(`${unit || '<i class="las la-balance-scale"></i>'}`);
            calculation();
        });

        $('#addedField').on('click', '.removeBtn', function (e) {
            let length=$("#addedField").find('.single-item').length;
            if(length <= 1){
                notify('warning',"<?php echo app('translator')->get('At least one item required'); ?>");
            }else{
                $(this).closest('.single-item').remove();
            }
            $('.discount').trigger('change');
            calculation();
        });

        let discount=0;

        $('.discount').on('input change',function (e) {
            this.value = this.value.replace(/^\.|[^\d\.]/g, '');
             discount=parseFloat($(this).val() || 0);
             if(discount >=100){
                discount=100;
                notify('warning',"<?php echo app('translator')->get('Discount can not bigger than 100 %'); ?>");
                $(this).val(discount);
             }
            calculation();
        });

        $('#addedField').on('input', '.quantity', function (e) {
            this.value = this.value.replace(/^\.|[^\d\.]/g, '');

            let quantity = $(this).val();
            if (quantity <= 0) {
                quantity = 0;
            }
            quantity=parseFloat(quantity);

            let parent   = $(this).closest('.single-item');
            let price    = parseFloat($(parent).find('.selected_type option:selected').data('price') || 0);
            let subTotal = price*quantity;

            $(parent).find('.single-item-amount').val(subTotal.toFixed(2));


            calculation()
        });

        function calculation ( ) {
            let items    = $('#addedField').find('.single-item');
            let subTotal = 0;

            $.each(items, function (i, item) {
                let price = parseFloat($(item).find('.selected_type option:selected').data('price') || 0);
                let quantity = parseFloat($(item).find('.quantity').val() || 0);
                subTotal+=price*quantity;
            });

            subTotal=parseFloat(subTotal);

            let discountAmount = (subTotal/100)*discount;
            let total          = subTotal-discountAmount;

            $('.subtotal').text(subTotal.toFixed(2));
            $('.total').text(total.toFixed(2));
        };

        $('.date').datepicker({
            language  : 'en',
            dateFormat: 'yyyy-mm-dd',
            minDate   : new Date()
        });

    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .border-line-area {
            position: relative;
            text-align: center;
            z-index: 1;
        }
        .border-line-area::before {
            position: absolute;
            content: '';
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #e5e5e5;
            z-index: -1;
        }
        .border-line-title {
            display: inline-block;
            padding: 3px 10px;
            background-color: #fff;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/courier/edit.blade.php ENDPATH**/ ?>