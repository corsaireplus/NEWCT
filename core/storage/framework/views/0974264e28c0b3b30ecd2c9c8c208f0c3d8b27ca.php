<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="row mt-30">
            <div class="col-lg-12">
                <div class="card b-radius--10 ">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm table-responsive">
                            <table class="table table--light style--two custom-data-table white-space-wrap">
                                <thead>
                                    <tr>
                                        <th><?php echo app('translator')->get('Date'); ?></th>
                                        <th><?php echo app('translator')->get('Staff'); ?></th>
                                        <th><?php echo app('translator')->get('Categorie'); ?></th>
                                        <th><?php echo app('translator')->get('Montant'); ?></th>
                                        <th><?php echo app('translator')->get('Description'); ?></th>
                                        <th><?php echo app('translator')->get('Action'); ?></th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $depenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trans): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                                    <tr>
                                        <td data-label="<?php echo app('translator')->get('Date'); ?>">
                                            <span><?php echo e(showDateTime($trans->created_at, 'd M Y')); ?></span><br>
                                            <!-- <span><?php echo e(diffForHumans($trans->created_at)); ?></span> -->
                                        </td>
                                        <td data-label="<?php echo app('translator')->get('Staff'); ?>">

                                            <?php echo e(__($trans->staff->fullname)); ?>

                                        </td>

                                        <td data-label="<?php echo app('translator')->get('Categorie'); ?>">
                                            <?php if($trans->categorie): ?>
                                            <span>
                                                <?php echo e(__($trans->categorie->nom)); ?>

                                                <?php else: ?>
                                                <span>N/A</span>

                                                <?php endif; ?>

                                        </td>
                                        <td data-label="<?php echo app('translator')->get('Montant'); ?>">
                                            <span class="font-weight-bold">
                                                <?php echo e(getAmount($trans->montant)); ?> <?php echo e(auth()->user()->branch->currencie); ?>

                                            </span>
                                        </td>
                                        <td><?php echo e($trans->description); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('staff.transaction.get_depense', encrypt($trans->id))); ?>"><span class="badge badge--primary"><?php echo app('translator')->get('modifier'); ?></span></a>
                                            <a href="javascript:void(0)" class="icon-btn btn--danger ml-1 deletePaiement" data-refpaiement="<?php echo e($trans->id); ?>"><i class="las la-trash"></i></a>
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
                        <?php echo e(paginateLinks($depenses)); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo app('translator')->get('SUPPRIMER DEPENSE'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?php echo e(route('staff.transaction.delete_depense')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="refpaiement" id="refpaiement">
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Êtes vous sûr de vouloir Supprimer cette depense ?'); ?></p>
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
<form action="<?php echo e(route('staff.expense.date.search')); ?>" method="GET" class="form-inline float-sm-right bg--white">
    <div class="input-group has_append ">
        <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="<?php echo app('translator')->get('Min date - Max date'); ?>" autocomplete="off" value="<?php echo e(@$dateSearch); ?>">
        <div class="input-group-append">
            <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>
<a href="<?php echo e(route('staff.transaction.create_depense')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small addUnit"><i class="fa fa-fw fa-paper-plane"></i><?php echo app('translator')->get('Ajouter Depense'); ?></a>
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
    (function($) {
        "use strict";
        if (!$('.datepicker-here').val()) {
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/bilan/expense_list.blade.php ENDPATH**/ ?>