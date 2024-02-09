<?php $__env->startSection('panel'); ?>
    <div class="card">
        <div class="card-body">
            <div id="printInvoice">
                <div class="content-header">
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">
                        <address class="m-t-5 m-b-5">
                            <strong class="text-inverse">CHALLENGE TRANSIT</strong><br>
                           
                            90 Rue Edouard Branly Montreuil<br>
                            Tél: 0179751616 - 0619645428<br>
                            Abidjan Cocody<br>
                            Tél:(+225) 0141652222-0141652323<br>   
                        </address>
                            <!-- <?php echo app('translator')->get('Facture Numéro'); ?>:
                            <small>#<?php echo e($courierInfo->trans_id); ?></small>
                            <br>
                            <?php echo app('translator')->get('Date'); ?>:
                            <?php echo e(showDateTime($courierInfo->created_at, 'd M Y')); ?>

                            <br> -->
                            <!-- <?php echo app('translator')->get('Estimate Delivery Date'); ?>:
                            <?php echo e(showDateTime($courierInfo->estimate_date, 'd M Y')); ?> -->
                        </div>
                        <div class="fw-bold">
                         <b>FACTURE </b><br>
                            <?php echo app('translator')->get('Facture Numéro'); ?>:
                            <small>#<?php echo e($courierInfo->trans_id); ?></small>
                            <br>
                            <?php echo app('translator')->get('Date'); ?>:
                            <?php echo e(showDateTime($courierInfo->created_at, 'd M Y')); ?>

                            <br>
                            <b><?php echo app('translator')->get('Agence Expediteur'); ?>:</b> <?php echo e(__($courierInfo->senderBranch->name)); ?><br>
                            <?php if($courierInfo->reftrans): ?>
                            <b><?php echo app('translator')->get('Agence Destination'); ?>:</b> <?php echo e(__($courierInfo->receiverBranch->name)); ?>

                            <?php endif; ?>
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
                           
                            <b><?php echo app('translator')->get('Transaction Id'); ?>:</b> <?php echo e($courierInfo->code); ?><br>
                            <b><?php echo app('translator')->get('Paiement Status'); ?>:</b>
                            <?php if($courierInfo->status == 2): ?>
                                <span class="badge badge--success"><?php echo app('translator')->get('Payé'); ?></span>
                            <?php else: ?>
                                <span class="badge badge--danger"><?php echo app('translator')->get('Non Payé'); ?></span>
                            <?php endif; ?>
                          
                        </div>
                    </div>
                    <hr>
                    <div class="invoice-info d-flex justify-content-between">
                        <div>
                            <?php echo app('translator')->get('A'); ?>
                            <address>
                                <strong><?php echo e(__(@$courierInfo->sender->nom)); ?></strong><br>
                                <?php echo app('translator')->get('Phone'); ?>: <?php echo e(@$courierInfo->sender->contact); ?><br>

                                <!-- <?php echo app('translator')->get('City'); ?>: <?php echo e(__(@$courierInfo->sender->city)); ?><br> -->
                                <?php echo app('translator')->get('Code Postal'); ?>: <?php echo e(__(@$courierInfo->sender->code_postal)); ?><br>
                                <!-- <?php echo app('translator')->get('Email'); ?>: <?php echo e(@$courierInfo->senderCustomer->email); ?> -->
                            </address>
                        </div>
                        <?php if($courierInfo->reftrans): ?>
                        <div>
                            <?php echo app('translator')->get('Destinataire'); ?>
                            <address>
                                <strong><?php echo e(__(@$courierInfo->receiver->nom)); ?></strong><br>
                                <!-- <?php echo app('translator')->get('City'); ?>: <?php echo e(__(@$courierInfo->receiverCustomer->city)); ?><br> -->
                                <!-- <?php echo app('translator')->get('State'); ?>: <?php echo e(__(@$courierInfo->receiverCustomer->state)); ?><br> -->
                                <!-- <?php echo app('translator')->get('Address'); ?>: <?php echo e(__(@$courierInfo->receiverCustomer->address)); ?><br> -->
                                <?php echo app('translator')->get('Phone'); ?>: <?php echo e(@$courierInfo->receiver->contact); ?><br>
                                <!-- <?php echo app('translator')->get('Email'); ?>: <?php echo e(@$courierInfo->receiverCustomer->email); ?> -->
                            </address>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo app('translator')->get('Description'); ?></th>
                                        <th><?php echo app('translator')->get('Qté'); ?></th>
                                        <th><?php echo app('translator')->get('Prix'); ?></th>
                                        <th><?php echo app('translator')->get('Sous-total'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $courierInfo->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courierProductInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e(__(@$courierProductInfo->type->name)); ?></td>
                                            <td><?php echo e($courierProductInfo->qty); ?> <?php echo e(__(@$courierProductInfo->type->unit->name)); ?></td>
                                            <td><?php echo e(showAmount($courierProductInfo->fee/$courierProductInfo->qty )); ?> <?php echo e($general->cur_sym); ?></td>
                                            <td><?php echo e(showAmount($courierProductInfo->fee)); ?> <?php echo e($general->cur_sym); ?></td>
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
                                            <th><?php echo app('translator')->get('Sous-total'); ?>:</th>
                                            <td><?php echo e(showAmount($courierInfo->paymentInfo->amount)); ?> <?php echo e($general->cur_sym); ?>

                                            </td>
                                        </tr>
                                  
                                        <tr>
                                            <th><?php echo app('translator')->get('Total'); ?>:</th>
                                            <td><?php echo e(showAmount($courierInfo->paymentInfo->final_amount)); ?> <?php echo e($general->cur_sym); ?>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="invoice-footer">
            <p class="text-center m-b-5 f-w-600">
                MERCI DE VOTRE CONFIANCE            </p>
            <p class="text-center">
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> challenge-transit.com</span>
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> Tel:(+33)0179751616 - (+225)0141652222</span>
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i>challengetransit@gmail.com</span>
            </p>
         </div>
                </div>
            </div>

            <div class="row no-print">
                <div class="col-sm-12">
                    <div class="float-sm-end">
                        <?php if(!$courierInfo->paymentInfo): ?>
                            <td><?php echo app('translator')->get('Non Payé'); ?></td>
                        <?php else: ?>
                            <?php if($courierInfo->status <= 1 ): ?>
                                <button type="button" class="btn btn-outline--success m-1 payment"
                                    data-code="<?php echo e($courierInfo->trans_id); ?>">
                                    <i class="fa fa-credit-card"></i> <?php echo app('translator')->get('Ajouter Paiement'); ?>
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>

                        <button class="btn btn-outline--primary m-1 printInvoice">
                            <i class="las la-download"></i><?php echo app('translator')->get('Imprimer'); ?>
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
                    <h5 class="" lass="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('Ajouter Paiement'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal">
                        <i class="las la-times"></i> </button>
                </div>

               <form action="<?php echo e(route('staff.transactions.payment')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('POST'); ?>
                <div class="modal-body">
                    <input type="hidden" name="code">
                    <p><?php echo app('translator')->get('Entrer les Informations de paiement'); ?></p>
                    <div class="form-group">
                        <div class="form-group col-lg-6">
                            <select class="form-control form-control-lg" id="mode" name="mode">
                                <option><?php echo app('translator')->get('Choisir Mode'); ?></option>
                                <option value="1">ESPECE</option>
                                <option value="2">CHEQUE</option>
                                <option value="3">CARTE BANCAIRE</option>
                                <option value="4">VIREMENT</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <input type="numeric" class="form-control form-control-lg" name="montant_payer" id="montant_payer" placeholder="Montant Payer">
                        </div>

                    </div>
                   <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php echo app('translator')->get('Annuler'); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Payer'); ?></button>
                    </div>
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

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/transactions/invoice.blade.php ENDPATH**/ ?>