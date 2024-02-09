<?php $__env->startSection('panel'); ?>
    <div class="row mt-50 mb-none-30">
    <?php if(auth()->user()->branch->country == 'FRA'): ?>
        

        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--3 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount"> <?php echo e($rdvbranchSum); ?> <?php echo e(auth()->user()->branch->currencie); ?></span>
                    </div>
                    <div class="desciption">
                        <span><?php echo app('translator')->get('Total RDV Objet'); ?></span>
                    </div>
                    <!-- <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3"><?php echo app('translator')->get('Voir Tout'); ?></a> -->
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if(auth()->user()->branch->country != 'FRA'): ?>
        <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
    <?php else: ?>
    <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
    <?php endif; ?>

            <div class="dashboard-w1 bg--12 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-money-bill-alt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount"><?php echo e($transfertbranchCount); ?></span>
                    </div>
                    <div class="desciption">
                        <span><?php echo app('translator')->get('Total Transactions'); ?></span>
                    </div>
                    <!-- <a href="<?php echo e(route('staff.transaction.all_list')); ?>" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3"><?php echo app('translator')->get('Voir Tout'); ?></a> -->
                </div>
            </div>
        </div>
        
        <?php if(auth()->user()->branch->country == 'FRA'): ?>
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--6 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                  
                        <span class="amount"><?php echo e($Senderpaiment); ?> <?php echo e(auth()->user()->branch->currencie); ?></span>
                     

                   
                    </div>
                    <div class="desciption">
                        <span><?php echo app('translator')->get('Total Colis Chauffeur Payé'); ?></span>
                    </div>

                    <!-- <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3"><?php echo app('translator')->get('Voir Tout'); ?></a> -->
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if(auth()->user()->branch->country != 'FRA'): ?>
        <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
    <?php else: ?>
    <div class="col-xl-3 col-lg-6 col-sm-6 mb-30">
    <?php endif; ?>
            <div class="dashboard-w1 bg--3 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                  
                        <span class="amount"><?php echo e($Receiverpaiment); ?> <?php echo e(auth()->user()->branch->currencie); ?></span>
                   
                    </div>
                    <div class="desciption">
                        <span><?php echo app('translator')->get('Total Colis Bureau Payé'); ?></span>
                    </div>

                    <!-- <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3"><?php echo app('translator')->get('Voir Tout'); ?></a> -->
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-30">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two custom-data-table white-space-wrap">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Agence - Staff'); ?></th>
                                    <th><?php echo app('translator')->get('Client'); ?></th>
                                    <th><?php echo app('translator')->get('Type'); ?></th>
                                    <th><?php echo app('translator')->get('Montant Payé - Reference'); ?></th>
                                    <th><?php echo app('translator')->get('Date'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                   
                                   
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $branch_transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td data-label="<?php echo app('translator')->get('Agence - Staff'); ?>">
                                    <span><?php echo e(__($trans->branch->name)); ?></span><br>
                                    <?php echo e(__($trans->agent->fullname)); ?>

                                </td>

                                <td data-label="<?php echo app('translator')->get('Client'); ?>">
                                
                                    <?php if($trans->transfert): ?>
                                    <span>
                                    <?php echo e(__($trans->transfert->sender->nom)); ?>

                                   
                                    </span><br>
                                    <?php echo e(__($trans->transfert->sender->contact)); ?>

                                     <?php elseif($trans->rdv): ?>
                                     <span>
                                     <?php echo e(__($trans->rdv->sender->nom)); ?>

                                        </span><br>
                                        <?php echo e(__($trans->rdv->sender->contact)); ?>

                                      <?php else: ?>
                                        <?php echo e(__($trans->transaction->sender->nom)); ?>

                                    </span><br>
                                    <?php echo e(__($trans->transaction->sender->contact)); ?>

                                    <?php endif; ?>
                                    
                                </td>
                                <td data-label="<?php echo app('translator')->get('Type'); ?>">
                                   <?php if($trans->transaction): ?>
                                    <span>
                                    TRANSACTION
                                   </span><br>
                                    <?php echo e($trans->transaction->trans_id); ?>

                                    </span>
                                    <?php elseif($trans->transfert): ?>
                                    <span>
                                    TRANSFERT
                                    </span><br>
                                    <?php echo e($trans->transfert->reference_souche); ?>

                                    </span>
                                     <?php else: ?>
                                    <span>RDV DEPOT</span><br>
                                    <?php echo e($trans->rdv->code); ?>

                                    <?php endif; ?>
                                    
                                </td>

                                <td data-label="<?php echo app('translator')->get('Montant paye - Reference'); ?>">
                                 <?php if($trans->transfert ): ?>
                                    <?php if(auth()->user()->branch_id == $trans->transfert->sender_branch_id): ?>
                                    <span class="font-weight-bold"> <?php echo e(getAmount($trans->sender_payer)); ?> <?php echo e(auth()->user()->branch->currencie); ?></span><br>
                                        <?php else: ?>
                                        <span class="font-weight-bold"><?php echo e(getAmount($trans->receiver_payer)); ?> <?php echo e(auth()->user()->branch->currencie); ?></span><br>
                                        <?php endif; ?>
                                    <?php else: ?>
                                    <span class="font-weight-bold"> <?php echo e(getAmount($trans->sender_payer)); ?> <?php echo e(auth()->user()->branch->currencie); ?></span><br>
<?php endif; ?>
                                    <span><?php echo e($trans->refpaiement); ?></span>
                                </td>

                                 <td data-label="<?php echo app('translator')->get('Date'); ?>">
                                    <span><?php echo e(showDateTime($trans->created_at, 'd M Y')); ?></span><br>
                                    <span><?php echo e(diffForHumans($trans->created_at)); ?></span>
                                </td>

                                    <td data-label="<?php echo app('translator')->get('Status Paiement'); ?>">
                                    <?php if($trans->transfert): ?>
                                             <a href="<?php echo e(route('staff.transaction.recu', encrypt($trans->refpaiement))); ?>" class="icon-btn btn--warning ml-1"><i class="las la-print"></i></a>
                                            <a href="<?php echo e(route('staff.transaction.edit', encrypt($trans->refpaiement))); ?>"><span class="badge badge--primary"><?php echo app('translator')->get('modifier'); ?></span></a>
                                            <?php if(auth()->user()->username == 'bagate' || auth()->user()->username == 'mouna'): ?> <a href="javascript:void(0)"  class="icon-btn btn--danger ml-1 deletePaiement" data-refpaiement="<?php echo e($trans->refpaiement); ?>"><i class="las la-trash"></i></a><?php endif; ?> 
                                         <?php else: ?>
                                    <span class="badge badge--success"><?php echo app('translator')->get('payé'); ?></span>
                                    <?php endif; ?>
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
                <div class="card-footer py-4">
                <?php echo e(paginateLinks($branch_transactions)); ?>

            </div>
            </div>
        </div>
    </div>
    <div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('SUPPRIMER PAIEMENT'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
   
                <form action="<?php echo e(route('staff.transaction.delete_paiement')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="refpaiement"id="refpaiement" >
                    <div class="modal-body">
                    <p><?php echo app('translator')->get('Êtes vous sûr de vouloir Supprimer ce paiement ?'); ?></p>
                </div>

                   
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal"><?php echo app('translator')->get('Annuler'); ?></button>
                        <button type="submit" class="btn btn--danger"><i class="fa fa-fw fa-trash"></i><?php echo app('translator')->get('Supprimer'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('breadcrumb-plugins'); ?>
 

    <form action="<?php echo e(route('staff.transaction.date.search')); ?>" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="date"   data-language="fr" class="datepicker-here form-control" data-position='bottom right' placeholder="<?php echo app('translator')->get('Date'); ?>" autocomplete="off" value="<?php echo e(@$dateSearch); ?>">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
    "use strict";
    $('.deletePaiement').on('click', function() {
        var modal = $('#branchModel');
        modal.find('input[name=refpaiement]').val($(this).data('refpaiement'))
        modal.modal('show');
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/bilan/translist.blade.php ENDPATH**/ ?>