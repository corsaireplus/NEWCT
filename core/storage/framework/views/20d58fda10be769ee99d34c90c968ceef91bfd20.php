<?php $__env->startSection('panel'); ?>
    <div class="card">
        <div class="card-body">
            <div id="printInvoice">
                <div class="content-header">
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">
                        <address class="m-t-5 m-b-5">
                            <strong class="text-inverse">BILAN PROGRAMME</strong><br>
                        </address>
                           
                        </div>
                        
                    </div>
                </div>

                <div class="invoice">
                    <div class="d-flex justify-content-between mt-3">
                       
                        
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo app('translator')->get('Client'); ?></th>
                                        <th><?php echo app('translator')->get('Montant Prevu'); ?></th>
                                        <th><?php echo app('translator')->get('Montant Encaissé'); ?></th>
                                        <th><?php echo app('translator')->get('Methode Paiement'); ?></th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__empty_1 = true; $__currentLoopData = $rdv_chauf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($rdv->client->nom); ?></td>
                                    <td><?php echo e(showAmount($rdv->montant)); ?></td>
                                    <td><?php echo e(showAmount($rdv->encaisse)); ?></td>
                                    <?php
                                    if($rdv->transaction){

                                    
                                    $premierPaiement='';
                                    $mode ='N/A';
                                     if ($rdv->transaction->paiement) {
                                      $premierPaiement = $rdv->transaction->paiement->first();
                                       if ($premierPaiement) {
                                        $mode=$premierPaiement->mode_paiement;
                                       }
                                     }
                                    }else{
                                    $premierPaiement='';
                                    $mode ='N/A';
                                     if ($rdv->transfert->paiement) {
                                      $premierPaiement = $rdv->transfert->paiement->first();
                                       if ($premierPaiement) {
                                        $mode=$premierPaiement->mode_paiement;
                                       }
                                     }
                                     }
                                    ?>
                                   <?php if($mode ==1): ?>
                                    <td>ESPECES</td>
                                   <?php elseif($mode == 2): ?>
                                    <td>CHEQUE</td>
                                   <?php elseif($mode ==3 ): ?>
                                    <td>CARTE BANCAIRE</td>
                                   <?php elseif($mode == 4): ?>
                                    <td>VIREMENT</td>
                                   <?php else: ?>
                                    <td><?php echo e($mode); ?></td>
                                   <?php endif; ?>
                                   
                                    

                                    </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                </tr>
                          
                            <?php endif; ?>
                            <tr><td>#</td><td>Total</td><td><?php echo e($rdv_chauf->sum('montant') ?? 0); ?></td><td><?php echo e($rdv_chauf->sum('encaisse') ?? 0); ?></td><td></td></tr>
    
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
                                            <th><?php echo app('translator')->get('Total Prevu'); ?>:</th>
                                            <td><?php echo e($rdv_chauf->sum('montant')); ?><?php echo e($general->cur_sym); ?>

                                            </td>
                                        </tr>
                                  
                                        <tr>
                                            <th><?php echo app('translator')->get('Total Encaissé'); ?>:</th>
                                            <td><?php echo e($rdv_chauf->sum('encaisse')); ?><?php echo e($general->cur_sym); ?>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            <div class="border-line-area">
                                        <h6 class="border-line-title"><?php echo app('translator')->get('Depenses'); ?></h6>
                                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo app('translator')->get('Satff'); ?></th>
                                        <th><?php echo app('translator')->get('Categorie'); ?></th>
                                        <th><?php echo app('translator')->get('Montant'); ?></th>
                                        <th><?php echo app('translator')->get('Description'); ?></th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $depenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($dep->staff->username); ?></td>
                                <td><?php echo e($dep->categorie->nom); ?></td>
                                <td><?php echo e($dep->montant); ?></td>
                                <td><?php echo e($dep->description); ?></td>
                                </tr>
                               
                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                </tr>
                          
                            <?php endif; ?>
                             <tr><td>#</td><td></td><td>Total</td><td><?php echo e($depenses->sum('montant') ?? 0); ?></td><td></td></tr>
                                   
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
                                            <th><?php echo app('translator')->get('Total Depense'); ?>:</th>
                                            <td> <?php echo e($depenses->sum('montant')); ?><?php echo e($general->cur_sym); ?>

                                            </td>
                                        </tr>
                                  
                                        <tr>
                                            <th><?php echo app('translator')->get('Total Versé'); ?>:</th>
                                            <td><?php echo e($rdv_chauf->sum('encaisse') - $depenses->sum('montant')); ?><?php echo e($general->cur_sym); ?>

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
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/missions/bilan_mission.blade.php ENDPATH**/ ?>