<?php $__env->startSection('panel'); ?>
<div class="row">
<div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
    <table class="table table--light style--two  white-space-wrap">
        <thead>
            <tr>
            
                                <th><?php echo app('translator')->get('Action'); ?></th>
                                <th><?php echo app('translator')->get('Date'); ?></th>
                                <th>Reference</th>
                                <th><?php echo app('translator')->get('Expediteur'); ?></th>
                                <th><?php echo app('translator')->get('Contact'); ?></th>
                                <th><?php echo app('translator')->get('Paiement'); ?></th>
                                <th><?php echo app('translator')->get('Frais'); ?></th>
                                <th><?php echo app('translator')->get('Reste à Payer'); ?></th>
                                
                                
                                <!-- <th><?php echo app('translator')->get('Action'); ?></th> -->
            </tr>
        </thead>
        <tbody>
                          <?php $__empty_1 = true; $__currentLoopData = $transferts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdvliste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                          <?php if($rdvliste->paymentInfo->sender_amount != 0 && $rdvliste->paymentInfo->sender_amount>0 ): ?>
                            <tr>
                            <td data-label="<?php echo app('translator')->get('Action'); ?>"> 
                                <?php if(auth()->user()->username == 'bagate' || auth()->user()->username == 'mouna' || auth()->user()->username == 'kanga' ): ?> 
                                <a href="<?php echo e(route('staff.transfert.edit', encrypt($rdvliste->id))); ?>"  class="icon-btn btn--primary "><i class="las la-edit"></i></a>
                                <?php endif; ?>
                                <?php if($rdvliste->paymentInfo->status == 0 && (auth()->user()->username == 'bagate')): ?> 
                                <a href="javascript:void(0)"  class="icon-btn btn--danger ml-1 deletePaiement" data-refpaiement="<?php echo e($rdvliste->id); ?>"><i class="las la-trash"></i></a>                                    <?php else: ?>
                                <?php endif; ?>
                               </td>
                                <td data-label="<?php echo app('translator')->get('Date'); ?>"><?php echo e(date('d-m-Y', strtotime($rdvliste->created_at))); ?></td>
                                <td data-label="<?php echo app('translator')->get('Reference'); ?>"><span class="font-weight-bold"><a href="<?php echo e(route('staff.transfert.detail', encrypt($rdvliste->id))); ?>" title="" class="icon-btn btn--priamry ml-1"><?php echo e($rdvliste->reference_souche); ?></a></span></td>
                                <td data-label="<?php echo app('translator')->get('Expediteur'); ?>"><?php echo e($rdvliste->sender->nom); ?></td>
                                <td data-label="<?php echo app('translator')->get('Contact'); ?>"><?php echo e($rdvliste->sender->contact); ?></td>
                                <td data-label="<?php echo app('translator')->get('Status Paiement'); ?>"> 
                                    <?php if($rdvliste->paymentInfo->status == 0 ): ?>
                                    <span class="badge badge--danger"><?php echo app('translator')->get('Non Payé'); ?></span>
                                    <?php elseif($rdvliste->paymentInfo->status == 1 ): ?>
                                    <span class="badge badge--warning"><?php echo app('translator')->get('Partiel'); ?></span>
                                    <?php elseif($rdvliste->paymentInfo->status == 2): ?>
                                    <span class="badge badge--success"><?php echo app('translator')->get('Payé'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <?php if($rdvliste->sender_branch_id == $user->branch_id): ?>
                                <td data-label="<?php echo app('translator')->get('Frais'); ?>"><span class="font-weight-bold"><?php echo e(getAmount($rdvliste->paymentInfo->sender_amount)); ?> <?php echo e($user->branch->currencie); ?></span></td>
                                <?php else: ?>
                                <td data-label="<?php echo app('translator')->get('Frais'); ?>"><span class="font-weight-bold"><?php echo e(getAmount($rdvliste->paymentInfo->receiver_amount)); ?> <?php echo e($user->branch->currencie); ?></span></td>
                                <?php endif; ?>
                                
                                <td data-label="<?php echo app('translator')->get('Reste à Payer'); ?>"><?php echo e(getAmount($rdvliste->paymentInfo->sender_amount -$rdvliste->payer)); ?> € </td>
                               
                                
                                <!-- <td data-label="<?php echo app('translator')->get('Action'); ?>">

                                    <a href="<?php echo e(route('staff.transfert.detail', encrypt($rdvliste->id))); ?>" title="" class="icon-btn btn--priamry ml-1"><?php echo app('translator')->get('Details'); ?></a> 
                                    <a href="<?php echo e(route('staff.transfert.invoice', encrypt($rdvliste->id))); ?>" title="" class="icon-btn btn--primary ml-1"><?php echo app('translator')->get('Facture'); ?></a>

                                </td> -->
                                

                            </tr>
                            <?php endif; ?>
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
                <?php echo e(paginateLinks($transferts)); ?>

            </div>
</div></div></div>
<div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('SUPPRIMER ENVOI'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
   
                <form action="<?php echo e(route('staff.transfert.delete')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="refpaiement"id="refpaiement" >
                    <div class="modal-body">
                    <p><?php echo app('translator')->get('Êtes vous sûr de vouloir Supprimer cet envoi ?'); ?></p>
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
<!--form action="<?php echo e(route('staff.transfert.search')); ?>" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="<?php echo app('translator')->get('Rechercher'); ?>" value="<?php echo e($search ?? ''); ?>">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form-->
   
    <!--form action="<?php echo e(route('staff.transfert.date.search')); ?>" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="<?php echo app('translator')->get('Min date - Max date'); ?>" autocomplete="off" value="<?php echo e(@$dateSearch); ?>">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form-->
    
 
  

<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-lib'); ?>
  <script src="<?php echo e(asset('assets/staff/js/vendor/datepicker.min.js')); ?>"></script>
  <script src="<?php echo e(asset('assets/staff/js/vendor/datepicker.en.js')); ?>"></script>
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

<script type="text/javascript">

  $(function () {
    
    var table = $('.transfertable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?php echo e(route('staff.transfert.list')); ?>",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'created_at', name: 'date'},
            {data: 'sender.nom', name: 'expediteur'},
            {data: 'sender.contact', name: 'contact'},
            {data: 'receiver.nom', name: 'destinataire'},
            {data: 'transferts.paymentInfo.status', name: 'paymentInfo.status'},
            {data: 'status', name: 'status'},
           
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });
</script>
<script>
    (function($){
        "use strict";
        if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
  </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/transfert/nonpaye.blade.php ENDPATH**/ ?>