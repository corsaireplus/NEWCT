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
                                <label><?php echo app('translator')->get('Rechercher'); ?></label>
                                <input type="text" name="search" value="<?php echo e(request()->search); ?>" class="form-control">
                            </div>
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Staus'); ?></label>
                                <select name="ship_status" class="form-control">
                                    <option value=""><?php echo app('translator')->get('Tout'); ?></option>
                                    <option value="0"><?php echo app('translator')->get('Entrepot'); ?></option>
                                    <option value="1"><?php echo app('translator')->get('En Conteneur'); ?></option>
                                    <option value="11"><?php echo app('translator')->get('Chargé partiellement'); ?></option>
                                    <option value="2"><?php echo app('translator')->get('Colis à Destination'); ?></option>
                                    <option value="22"><?php echo app('translator')->get('Colis partiel à Destination'); ?></option>
                                     <option value="3"><?php echo app('translator')->get('Livré'); ?></option>
                                    <option value="33"><?php echo app('translator')->get('Livré partiellement'); ?></option>
                                </select>
                                <!-- 0 entrepot 1 chargé en conteneur 11 chargé partiellement 2 colis arrivé 22 colis partiellement arrivé 3 colis livré 33 colis partiellement livré 4 terminé -->
                            </div>
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Paiement Status'); ?></label>
                                <select name="status" class="form-control">
                                    <option value=""><?php echo app('translator')->get('Tout'); ?></option>
                                    <option value="2"><?php echo app('translator')->get('Payé'); ?></option>
                                    <option value="1"><?php echo app('translator')->get('Partiel'); ?></option>
                                    <option value="0"><?php echo app('translator')->get('Non Payé'); ?></option>
                                </select>
                            </div>
                            <div class="flex-grow-1">
                                <label><?php echo app('translator')->get('Date'); ?></label>
                                <input name="date" type="text" class="date form-control" placeholder="<?php echo app('translator')->get('Start date - End date'); ?>" autocomplete="off" value="<?php echo e(request()->date); ?>">
                            </div>
                            <div class="flex-grow-1 align-self-end">
                                <button class="btn btn--primary w-100 h-45"><i class="fas fa-filter"></i> <?php echo app('translator')->get('Filtrer'); ?></button>
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
                                    <!-- <th><?php echo app('translator')->get('Agence - Staff'); ?></th> -->
                                    <th><?php echo app('translator')->get('Expediteur - Contact'); ?></th>
                                    <th><?php echo app('translator')->get('Montant - Reference'); ?></th>
                                    <th><?php echo app('translator')->get('Creations Date'); ?></th>
                                    <th><?php echo app('translator')->get('Reste à Payer'); ?></th>
                                    <th><?php echo app('translator')->get('Paiement'); ?></th>
                                    <th><?php echo app('translator')->get('Status Envoi'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $courierLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courierInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <!-- <td>
                                            <span><?php echo e(__($courierInfo->senderBranch->name)); ?></span><br>
                                            <?php echo e(__($courierInfo->senderStaff->fullname)); ?>

                                        </td> -->
                                        <td>
                                            <span>
                                                <?php if($courierInfo->sender): ?>
                                                    <?php echo e(__($courierInfo->receiver->nom)); ?>

                                                <?php else: ?>
                                                    <?php echo app('translator')->get('N/A'); ?>
                                                <?php endif; ?>
                                            </span>
                                            <br>
                                            <?php if($courierInfo->sender): ?>
                                                <?php echo e(__($courierInfo->receiver->contact)); ?>

                                            <?php else: ?>
                                                <span><?php echo app('translator')->get('N/A'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="fw-bold d-block">
                                                <?php echo e(showAmount(@$courierInfo->paymentInfo->receiver_amount)); ?>

                                                <?php echo e(__('FCFA')); ?>

                                            </span>
                                            <span class="font-weight-bold"> <?php if($courierInfo->reftrans): ?><a href="#" title="" class="icon-btn btn--priamry ml-1"><?php echo e($courierInfo->reftrans); ?> </a><?php else: ?> <?php echo e($courierInfo->trans_id); ?> <?php endif; ?></span>
                                        </td>
                                        <td><?php echo e(showDateTime($courierInfo->created_at, 'd M Y')); ?></td>
                                        <td>  <span class="fw-bold d-block">
                                               <?php echo e(showAmount(@$courierInfo->paymentInfo->receiver_amount - $courierInfo->payer)); ?>

                                                <?php echo e(__('FCFA')); ?>

                                                </span>
                                        </td>
                                        <td>
                                            <?php if(@$courierInfo->status == 2): ?>
                                                <span class="badge badge--success"><?php echo app('translator')->get('Payé'); ?></span>
                                            <?php elseif(@$courierInfo->status == 1): ?>
                                                <span class="badge badge--warning"><?php echo app('translator')->get('Partiel'); ?></span>    
                                            <?php elseif(@$courierInfo->status == 0): ?>
                                                <span class="badge badge--danger"><?php echo app('translator')->get('Non Payé'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($courierInfo->reftrans): ?>
                                                <?php if($courierInfo->ship_status == 0): ?>
                                                    <span class="badge badge--danger"><?php echo app('translator')->get('En Entrepôt'); ?></span>
                                                <?php elseif($courierInfo->ship_status == 1): ?>
                                                  
                                                    <span class="badge badge--success"><?php echo app('translator')->get('Chargé'); ?></span>
                                                                                                    
                                                <?php elseif($courierInfo->ship_status ==  11): ?>
                                                    <span class="badge badge--warning"><?php echo app('translator')->get('Chargé partiellement'); ?></span>
                                                <?php elseif($courierInfo->ship_status ==  2): ?>
                                                    <span class="badge badge--success"><?php echo app('translator')->get('Arrivé a Destination'); ?></span>
                                                <?php elseif($courierInfo->ship_status ==  22): ?>
                                                    <span class="badge badge--warning"><?php echo app('translator')->get('Arrivé partiellement'); ?></span>
                                                <?php elseif($courierInfo->ship_status ==  3): ?>
                                                    <span class="badge badge--success"><?php echo app('translator')->get('Livré'); ?></span>
                                                <?php elseif($courierInfo->ship_status ==  33): ?>
                                                    <span class="badge badge--warning"><?php echo app('translator')->get('Livré partiellement'); ?></span>
                                                <?php endif; ?>
                                             <?php else: ?>
                                             <span class="badge badge--primary"><?php echo app('translator')->get('RDV'); ?></span>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('staff.transactions.invoice', encrypt($courierInfo->id))); ?>"
                                                title="" class="btn btn-sm btn-outline--info"><i
                                                    class="las la-file-invoice"></i> <?php echo app('translator')->get('Facture'); ?></a>
                                            <a href="<?php echo e(route('staff.transactions.details', encrypt($courierInfo->id))); ?>"
                                                title="" class="btn btn-sm btn-outline--primary"><i
                                                    class="las la-info-circle"></i> <?php echo app('translator')->get('Details'); ?></a>
                                            <?php if(auth()->user()->username == 'bagate' || auth()->user()->username == 'mouna'): ?> 
                                                <?php if($courierInfo->ship_status != -1): ?> 
                                              <a href="<?php echo e(route('staff.transactions.modifier', encrypt($courierInfo->id))); ?>"
                                                class="btn btn-sm btn-outline--primary">
                                                <i class="las la-pen"></i><?php echo app('translator')->get('Edit'); ?>
                                             </a>
                                                <?php endif; ?>
                                            <?php if($courierInfo->status  == 0 && (auth()->user()->username == 'bagate') && $courierInfo->ship_status != - 1): ?> 
                                              <a href="javascript:void(0)"  class="icon-btn btn--danger ml-1 deleteTransaction" data-refpaiement="<?php echo e($courierInfo->trans_id); ?>"><i class="las la-trash"></i></a>
                                    
                                              <?php endif; ?>
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

                <?php if($courierLists->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($courierLists)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('SUPPRIMER ENVOI'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
   
                <form action="<?php echo e(route('staff.transactions.delete')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="refpaiement" id="refpaiement" >
                    <div class="modal-body">
                    <p><?php echo app('translator')->get('Êtes vous sûr de vouloir Supprimer cet envoi ?'); ?></p>
                </div>

                   
                      <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php echo app('translator')->get('Annuler'); ?></button>
                        <button type="submit" class="btn btn--danger"><?php echo app('translator')->get('Supprimer'); ?></button>
                    </div>
                </form>
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
    "use strict";
    $('.deleteTransaction').on('click', function() {
        var modal = $('#branchModel');
        modal.find('input[name=refpaiement]').val($(this).data('refpaiement'))
        modal.modal('show');
    });
    
</script>
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
            if(url.get('ship_status') != undefined && url.get('ship_status') != ''){
                $('select[name=ship_status]').find(`option[value=${url.get('ship_status')}]`).attr('selected',true);
            }

        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/transactions/receive.blade.php ENDPATH**/ ?>