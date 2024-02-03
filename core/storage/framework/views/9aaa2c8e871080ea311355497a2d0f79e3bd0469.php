<?php $__env->startSection('panel'); ?>
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted"><?php echo app('translator')->get('Agent'); ?></h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Nom Complet'); ?>
                            <span><?php echo e(__($courierInfo->senderStaff->fullname)); ?></span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Email'); ?>
                            <span><?php echo e(__($courierInfo->senderStaff->email)); ?></span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Agence'); ?>
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
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Expediteur Information'); ?></h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Name'); ?>
                                    <span><?php echo e(__(@$courierInfo->sender->nom)); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Phone'); ?>
                                    <span><?php echo e(__(@$courierInfo->sender->contact)); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Transaction Numero'); ?>
                                    <span class="fw-bold"><?php echo e($courierInfo->trans_id); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if($courierInfo->reftrans): ?>
                <div class="col-lg-6 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Destinataire Information'); ?></h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Name'); ?>
                                    <span><?php echo e(__(@$courierInfo->receiver->nom)); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Phone'); ?>
                                    <span><?php echo e(@$courierInfo->receiver->contact); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Reference Colis'); ?>
                                    <span class="badge badge--primary fw-bold"><?php echo e(__(@$courierInfo->reftrans)); ?></span>
                                    
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
           
            <div class="row mb-30">
                <div class="col-lg-12">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Transaction Details'); ?></h5>
                        <div class="card-body">
                            <div class="table-responsive--md  table-responsive">
                                <table class="table table--light style--two">
                                    <thead>
                                        <tr>
                                            <th><?php echo app('translator')->get('Description'); ?></th>
                                            <th><?php echo app('translator')->get('Frais'); ?></th>
                                            <th><?php echo app('translator')->get('Qté'); ?></th>
                                            <th><?php echo app('translator')->get('Sous-total'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $courierInfo->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courierProductInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e(__($courierProductInfo->type->name)); ?></td>
                                                <td><?php echo e(showAmount($courierProductInfo->fee)); ?> <?php echo e($general->cur_sym); ?></td>
                                                <td><?php echo e($courierProductInfo->qty); ?>

                                                    <?php echo e(__(@$courierProductInfo->type->unit->name)); ?></td>
                                                <td><?php echo e(showAmount($courierProductInfo->fee)); ?> <?php echo e($general->cur_sym); ?></td>
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
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Facture Information'); ?></h5>
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

                                            <small class="text--danger">(<?php echo e(getAmount($courierInfo->paymentInfo->percentage)); ?>%)</small>
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
            <div class="row mb-30">
                <div class="col-lg-12 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Paiement Information'); ?></h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Sous-total'); ?>
                                    <?php if(!$courierInfo->paymentInfo): ?>
                                        <p><?php echo app('translator')->get('Unpaid'); ?></p>
                                    <?php else: ?>
                                        <span><?php echo e(showAmount($courierInfo->paymentInfo->amount)); ?> <?php echo e(__($general->cur_text)); ?></span>
                                    <?php endif; ?>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Remise'); ?>
                                    <?php if(!$courierInfo->paymentInfo): ?>
                                        <p><?php echo app('translator')->get('Unpaid'); ?></p>
                                    <?php else: ?>
                                        <span>
                                            <?php echo e(showAmount($courierInfo->paymentInfo->discount)); ?>

                                            <?php echo e(__($general->cur_text)); ?>

                                            <small class="text--danger">(<?php echo e(getAmount($courierInfo->paymentInfo->percentage)); ?>%)</small>
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
                                <?php echo app('translator')->get('Reste à Payer'); ?>
                                <?php if($userInfo->branch_id == $courierInfo->branch_id ): ?>
                                <span class="badge badge--danger"><?php echo e(getAmount($courierInfo->paymentInfo->sender_amount - $deja_payer_sender )); ?> <?php echo e($userInfo->branch->currencie); ?></span>
                                <?php else: ?>
                                <span class="badge badge--danger"><?php echo e(getAmount($courierInfo->paymentInfo->receiver_amount - $deja_payer_receiver)); ?> <?php echo e($userInfo->branch->currencie); ?></span>
                                <?php endif; ?>
                              </li>


                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo app('translator')->get('Status'); ?>
                                    <?php if(!$courierInfo->paymentInfo): ?>
                                        <p><?php echo app('translator')->get('Unpaid'); ?></p>
                                    <?php else: ?>
                                        <?php if($courierInfo->status == 2): ?>
                                            <span class="badge badge--success"><?php echo app('translator')->get('Payé'); ?></span>
                                        <?php elseif($courierInfo->status == 1): ?>
                                        <span class="badge badge--warning"><?php echo app('translator')->get('Partiel'); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge--danger"><?php echo app('translator')->get('Non Payé'); ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </li>
                            </ul>
                           
                        <div class="card-body">
                            <div class="table-responsive--md  table-responsive">
                                <table class="table table--light style--two">
                                    <thead>
                                        <tr>
                                            <th><?php echo app('translator')->get('Date'); ?></th>
                                            <th><?php echo app('translator')->get('Agent'); ?></th>
                                            <th><?php echo app('translator')->get('Montant  payé'); ?></th>
                                            <th><?php echo app('translator')->get('Mode'); ?></th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $total = 0;
                                    ?>
                                    <?php $__currentLoopData = $courierInfo->paiement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr>
                                        <td>
                                            <?php echo e(date('d-m-Y', strtotime($payment->date_paiement))); ?>

                                        </td>
                                        <td><?php echo e($payment->agent->firstname); ?></td>
                                        <?php if($userInfo->branch_id == $courierInfo->branch_id ): ?>
                                        <td><?php echo e(getAmount($payment->sender_payer)); ?> <?php echo e(auth()->user()->branch->currencie); ?></td>
                                        <?php else: ?>
                                        <td><?php echo e(getAmount($payment->receiver_payer)); ?> <?php echo e(auth()->user()->branch->currencie); ?></td>

                                        <?php endif; ?>
                                        <?php if($payment->modepayer): ?>
                                        <td><?php echo e($payment->modepayer->nom); ?></td>
                                        <?php else: ?>
                                        <td>N/A</td>
                                        <?php endif; ?>
                                        <td>                                            <a href="<?php echo e(route('staff.transaction.recu', encrypt($payment->refpaiement))); ?>"><span class="badge badge--primary"><?php echo app('translator')->get('reçu'); ?></span></a>

                                    </tr>

                                    <?php if($userInfo->branch_id == $courierInfo->sender_branch_id): ?>
                                    <?php
                                    $total += $payment->sender_payer;
                                    ?>
                                    <?php else: ?>
                                    <?php
                                    $total += $payment->receiver_payer;
                                    ?>
                                    <?php endif; ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <!-- <tr>
                                                <td><?php echo e(__($courierProductInfo->type->name)); ?></td>
                                                <td><?php echo e(showAmount($courierProductInfo->fee)); ?> <?php echo e($general->cur_sym); ?></td>
                                                <td><?php echo e($courierProductInfo->qty); ?>

                                                    <?php echo e(__(@$courierProductInfo->type->unit->name)); ?></td>
                                                <td><?php echo e(showAmount($courierProductInfo->fee)); ?> <?php echo e($general->cur_sym); ?></td>
                                            </tr>
-->
                                    </tbody>
                                </table>
                            </div>
                     
                    </div>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.back','data' => ['route' => ''.e(route('staff.transactions.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => ''.e(route('staff.transactions.index')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <a href="<?php echo e(route('staff.transactions.invoice', encrypt($courierInfo->id))); ?>" title=""
        class="btn btn-sm btn-outline--info">
        <i class="las la-file-invoice"></i>
        <?php echo app('translator')->get('Facture'); ?>
    </a>

    <!-- <?php if($courierInfo->status <= 1 ): ?>
        <button class="btn btn-sm btn-outline--info delivery"
            data-code="<?php echo e($courierInfo->code); ?>"><i class="las la-truck"></i>
            <?php echo app('translator')->get('Delivery'); ?></button>
    <?php endif; ?> -->

    <?php if($courierInfo->status <= 1 ): ?>
            <button class="btn btn-sm btn-outline--success payment"
                data-code="<?php echo e($courierInfo->code); ?>"><i class="las la-credit-card"></i>
                <?php echo app('translator')->get('Payer'); ?></button>
    <?php endif; ?>

    <!-- <?php if($courierInfo->status == Status::COURIER_QUEUE || $courierInfo->status == Status::COURIER_DISPATCH): ?>
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
    <?php endif; ?> -->
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

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/transactions/details.blade.php ENDPATH**/ ?>