<?php $__env->startSection('panel'); ?>
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted"><?php echo app('translator')->get('Sender Staff'); ?></h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Fullname'); ?>
                            <span><?php echo e(__($courierInfo->senderStaff->fullname)); ?></span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Email'); ?>
                            <span><?php echo e(__($courierInfo->senderStaff->email)); ?></span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Branch'); ?>
                            <span><?php echo e(__($courierInfo->senderBranch->name)); ?></span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Status'); ?>
                            <?php if($courierInfo->senderStaff->status == Status::ENABLE): ?>
                                <span class="badge badge-pill badge--success"><?php echo app('translator')->get('Active'); ?></span>
                            <?php elseif($courierInfo->senderStaff->status == Status::DISABLE): ?>
                                <span class="badge badge-pill badge--danger"><?php echo app('translator')->get('Banned'); ?></span>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>

            <?php if($courierInfo->receiver_staff_id): ?>
                <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                    <div class="card-body">
                        <h5 class="mb-20 text-muted"><?php echo app('translator')->get('Receiver Staff'); ?></h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo app('translator')->get('Fullname'); ?>
                                <span><?php echo e(__($courierInfo->receiverStaff->fullname)); ?></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo app('translator')->get('Email'); ?>
                                <span><?php echo e(__($courierInfo->receiverStaff->email)); ?></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo app('translator')->get('Branch'); ?>
                                <span><?php echo e(__($courierInfo->receiverBranch->name)); ?></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo app('translator')->get('Status'); ?>
                                <?php if($courierInfo->receiverStaff->status == Status::ENABLE): ?>
                                    <span class="badge badge-pill badge--success"><?php echo app('translator')->get('Active'); ?></span>
                                <?php elseif($courierInfo->receiverStaff->status == Status::DISABLE): ?>
                                    <span class="badge badge-pill badge--danger"><?php echo app('translator')->get('Banned'); ?></span>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12 mt-10">
            <div class="row mb-30">
                <div class="col-lg-6 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Sender Information'); ?></h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Name'); ?>
                                    <span><?php echo e(__(@$courierInfo->senderCustomer->fullname)); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Email'); ?>
                                    <span><?php echo e(__(@$courierInfo->senderCustomer->email)); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Phone'); ?>
                                    <span><?php echo e(__(@$courierInfo->senderCustomer->mobile)); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Address'); ?>
                                    <span><?php echo e(__($courierInfo->senderCustomer->address)); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('City'); ?>
                                    <span><?php echo e(__(@$courierInfo->senderCustomer->city)); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('State'); ?>
                                    <span><?php echo e(__(@$courierInfo->senderCustomer->state)); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Order Number'); ?>
                                    <span class="fw-bold"><?php echo e($courierInfo->code); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Receiver Information'); ?></h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Name'); ?>
                                    <span><?php echo e(__(@$courierInfo->receiverCustomer->fullname)); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Email'); ?>
                                    <span><?php echo e(@$courierInfo->receiverCustomer->email); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Phone'); ?>
                                    <span><?php echo e(@$courierInfo->receiverCustomer->mobile); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Address'); ?>
                                    <span><?php echo e(__(@$courierInfo->receiverCustomer->address)); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('City'); ?>
                                    <span><?php echo e(__(@$courierInfo->receiverCustomer->city)); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('State'); ?>
                                    <span><?php echo e(__(@$courierInfo->receiverCustomer->state)); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Status'); ?>
                                    <?php if($courierInfo->status != Status::COURIER_DELIVERED): ?>
                                        <span class="badge badge--primary fw-bold"><?php echo app('translator')->get('Waiting'); ?></span>
                                    <?php elseif($courierInfo->status == Status::COURIER_DELIVERED): ?>
                                        <span class="badge badge--success"><?php echo app('translator')->get('Delivery'); ?></span>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-30">
                <div class="col-lg-12">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Courier Details'); ?></h5>
                        <div class="card-body">
                            <div class="table-responsive--md  table-responsive">
                                <table class="table table--light style--two">
                                    <thead>
                                        <tr>
                                            <th><?php echo app('translator')->get('Courier Type'); ?></th>
                                            <th><?php echo app('translator')->get('Price'); ?></th>
                                            <th><?php echo app('translator')->get('Qty'); ?></th>
                                            <th><?php echo app('translator')->get('Subtotal'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $courierInfo->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courierProductInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(__($courierProductInfo->type->name)); ?></td>
                                                <td><?php echo e($general->cur_sym); ?><?php echo e(showAmount($courierProductInfo->fee)); ?></td>
                                                <td><?php echo e($courierProductInfo->qty); ?>

                                                    <?php echo e(__(@$courierProductInfo->type->unit->name)); ?></td>
                                                <td><?php echo e($general->cur_sym); ?><?php echo e(showAmount($courierProductInfo->fee)); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-30">
                <div class="col-lg-12 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Payment Information'); ?></h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Payment Received By '); ?>
                                    <?php if(!empty($courierInfo->paymentInfo->branch_id)): ?>
                                        <span><?php echo e(__(@$courierInfo->paymentInfo->branch->name)); ?></span>
                                    <?php else: ?>
                                        <span><?php echo app('translator')->get('N/A'); ?></span>
                                    <?php endif; ?>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Date'); ?>
                                    <?php if(!empty($courierInfo->paymentInfo->date)): ?>
                                        <span><?php echo e(showDateTime($courierInfo->date, 'd M Y')); ?></span>
                                    <?php else: ?>
                                        <span><?php echo app('translator')->get('N/A'); ?></span>
                                    <?php endif; ?>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Subtotal'); ?>
                                    <?php if(!$courierInfo->paymentInfo): ?>
                                        <p><?php echo app('translator')->get('Unpaid'); ?></p>
                                    <?php else: ?>
                                        <span><?php echo e(showAmount($courierInfo->paymentInfo->amount)); ?> <?php echo e(__($general->cur_text)); ?></span>
                                    <?php endif; ?>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Discount'); ?>
                                    <?php if(!$courierInfo->paymentInfo): ?>
                                        <p><?php echo app('translator')->get('Unpaid'); ?></p>
                                    <?php else: ?>
                                        <span>
                                            <?php echo e(showAmount($courierInfo->paymentInfo->discount)); ?>

                                            <?php echo e(__($general->cur_text)); ?>

                                            <small class="text--danger">(<?php echo e(getAmount($courierInfo->payment->percentage)); ?>%)</small>
                                        </span>
                                    <?php endif; ?>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Total'); ?>
                                    <?php if(!$courierInfo->paymentInfo): ?>
                                        <p><?php echo app('translator')->get('Unpaid'); ?></p>
                                    <?php else: ?>
                                        <span><?php echo e(showAmount($courierInfo->paymentInfo->final_amount)); ?>

                                            <?php echo e(__($general->cur_text)); ?>

                                        </span>
                                    <?php endif; ?>
                                </li>


                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Status'); ?>
                                    <?php if(!$courierInfo->paymentInfo): ?>
                                        <p><?php echo app('translator')->get('Unpaid'); ?></p>
                                    <?php else: ?>
                                        <?php if($courierInfo->paymentInfo->status == Status::PAID): ?>
                                            <span class="badge badge--success"><?php echo app('translator')->get('Paid'); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge--danger"><?php echo app('translator')->get('Unpaid'); ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b = $component; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ConfirmationModal::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b)): ?>
<?php $component = $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b; ?>
<?php unset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b); ?>
<?php endif; ?>

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
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.back','data' => ['route' => ''.e(route('staff.courier.manage.list')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => ''.e(route('staff.courier.manage.list')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <a href="<?php echo e(route('staff.courier.invoice', encrypt($courierInfo->id))); ?>" title=""
        class="btn btn-sm btn-outline--info">
        <i class="las la-file-invoice"></i>
        <?php echo app('translator')->get('Invoice'); ?>
    </a>

    <?php if($courierInfo->status == Status::COURIER_DELIVERYQUEUE && $courierInfo->paymentInfo->status == Status::PAID): ?>
        <button class="btn btn-sm btn-outline--info delivery"
            data-code="<?php echo e($courierInfo->code); ?>"><i class="las la-truck"></i>
            <?php echo app('translator')->get('Delivery'); ?></button>
    <?php endif; ?>

    <?php if(($courierInfo->status == Status::COURIER_DELIVERYQUEUE || $courierInfo->status == Status::COURIER_QUEUE) &&
                $courierInfo->paymentInfo->status == Status::UNPAID): ?>
            <button class="btn btn-sm btn-outline--success payment"
                data-code="<?php echo e($courierInfo->code); ?>"><i class="las la-credit-card"></i>
                <?php echo app('translator')->get('Payment'); ?></button>
    <?php endif; ?>

    <?php if($courierInfo->status == Status::COURIER_QUEUE || $courierInfo->status == Status::COURIER_DISPATCH): ?>
        <?php
            $class = '';
            if ($courierInfo->sender_branch_id == $staff->branch_id) {
                $icon = 'la-arrow-circle-right';
                $text = 'Dispatch';
                $route = route('staff.courier.dispatched', $courierInfo->id);
                $question = "Are you sure to despatched this courier";
                if($courierInfo->sender_branch_id == $staff->branch_id && $courierInfo->status == Status::COURIER_DISPATCH){
                    $class = 'd-none';
                }
            } else {
                $icon = 'la-check-circle';
                $text = 'Received';
                $route = route('staff.courier.receive', $courierInfo->id);
                $question = "Are you sure to receive this courier";
            }
        ?>

        <button type="button" class="btn btn-sm btn-outline--warning confirmationBtn <?php echo e($class); ?>"
            data-action="<?php echo e($route); ?>" data-question="<?php echo e(__($question)); ?>?">
            <i class="las <?php echo e($icon); ?>"></i>
            <?php echo app('translator')->get($text); ?>
        </button>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
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
        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/courier/details.blade.php ENDPATH**/ ?>