<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
          <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('Action'); ?></th>
                                <th><?php echo app('translator')->get('Date RDV'); ?></th>
                                <th><?php echo app('translator')->get('Observation'); ?></th>
                                <th><?php echo app('translator')->get('Client'); ?></th>
                                <th><?php echo app('translator')->get('Contact'); ?></th>
                                <th><?php echo app('translator')->get('Code Postal'); ?></th>
                                <th><?php echo app('translator')->get('Adresse'); ?></th>
                                <th><?php echo app('translator')->get('Status'); ?></th>

                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $rdv; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdvliste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                            <td>
                                    <!-- <a href="<?php echo e(route('staff.rdv.details', encrypt($rdvliste->idrdv))); ?>" title="" class="icon-btn btn--success ml-1"><i class="las la-edit"></i></a> -->

                                    <a href="<?php echo e(route('staff.rdv.details', encrypt($rdvliste->idrdv))); ?>"
                                                class="btn btn-sm btn-outline--primary">
                                                <i class="las la-pen"></i><?php echo app('translator')->get('Edit'); ?>
                                            </a>
                                    <a href="javascript:void(0)"  class="icon-btn btn--danger ml-1 deletePaiement" data-refpaiement="<?php echo e($rdvliste->idrdv); ?>"><i class="las la-trash"></i></a>

                                <!-- <a href="<?php echo e(route('staff.rdv.edit', encrypt($rdvliste->idrdv))); ?>" title="Annuler RDV" class="icon-btn btn--danger ml-1"><?php echo app('translator')->get('Annuler'); ?></a> -->

                                </td>
                                <td ><?php echo e(date('d-m-Y', strtotime($rdvliste->date))); ?></td>
                                <?php if($rdvliste->observation !== NULL): ?>
                                <td ><?php echo e($rdvliste->observation); ?></td>
                                <?php else: ?> <td></td> <?php endif; ?>
                                <td ><?php echo e($rdvliste); ?></td>
                                <td ><?php echo e($rdvliste->client->contact); ?></td>
                                <?php if($rdvliste->adresse): ?>
                                <td ><?php echo e($rdvliste->adresse->code_postal); ?></td>
                                
                                <?php else: ?>
                                <td >N/A</td>
                             
                                <?php endif; ?>
                                <?php if($rdvliste->adresse): ?>
                                <td ><?php echo e($rdvliste->adresse->adresse); ?></td>
                                <?php else: ?>
                                <td >N/A</td>
                                <?php endif; ?>
                                <td > <?php if($rdvliste->status == 0 && $rdvliste->chauffeur ): ?>
                                    <span class="badge badge--primary"><?php echo app('translator')->get('En Cours'); ?></span>
                                    <?php elseif($rdvliste->status == 0 && !$rdvliste->chauffeur ): ?>
                                    <span class="badge badge--danger"><?php echo app('translator')->get('Non Assigné'); ?></span>
                                    <?php elseif($rdvliste->status == 1): ?>
                                    <span class="badge badge--success"><?php echo app('translator')->get('Delivery'); ?></span>
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
                <?php echo e(paginateLinks($rdv)); ?>

            </div>
        </div> 
    </div>
    
</div>
<div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('SUPPRIMER RDV'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
   
                <form action="<?php echo e(route('staff.rdv.delete')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="refpaiement"id="refpaiement" >
                    <div class="modal-body">
                    <p><?php echo app('translator')->get('Êtes vous sûr de vouloir Supprimer ce rdv ?'); ?></p>
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
<a href="<?php echo e(route('staff.rdv.create')); ?>" >
<button type="button" class="btn btn-outline--primary m-1 payment">
                                    <i class="fa la-plus"></i> <?php echo app('translator')->get('Creer RDV'); ?>
                                </button>
                                </a>
<!-- <form action="<?php echo e(route('staff.rdv.search')); ?>" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
    <div class="input-group has_append  ">
        <input type="text" name="search" class="form-control" placeholder="<?php echo app('translator')->get('Contact Client'); ?>" value="<?php echo e($search ?? ''); ?>">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form> -->
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
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/rdv/index.blade.php ENDPATH**/ ?>