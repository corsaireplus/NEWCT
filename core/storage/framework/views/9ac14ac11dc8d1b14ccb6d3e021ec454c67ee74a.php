<?php $__env->startSection('panel'); ?>
<div class="row">
<div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
    <table class="table table--light style--two custom-data-table white-space-wrap">
        <thead>
            <tr>
            
                                
                                <th><?php echo app('translator')->get('Date'); ?></th>
                                <th>Reference</th>
                                <th><?php echo app('translator')->get('Destinataire'); ?></th>
                                <th><?php echo app('translator')->get('Description'); ?></th>
                                <th><?php echo app('translator')->get('Envoye'); ?></th>
                                <th><?php echo app('translator')->get('Contact'); ?></th>
                                <th><?php echo app('translator')->get('Agent Livré'); ?></th>
                                <th><?php echo app('translator')->get('Action'); ?></th>
            </tr>
        </thead>
        <tbody>
                          <?php $__empty_1 = true; $__currentLoopData = $transferts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdvliste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td data-label="<?php echo app('translator')->get('Date'); ?>"><?php echo e(date('d-m-Y', strtotime($rdvliste->created_at))); ?></td>
                                <td data-label="<?php echo app('translator')->get('Reference'); ?>">
                                <?php if($rdvliste->transfert->paymentInfo->status == 0 ): ?>
                                    <span class="badge badge--danger"><a href="<?php echo e(route('staff.transfert.detail', encrypt($rdvliste->transfert->id))); ?>" title="" ><?php echo e($rdvliste->transfert->reference_souche); ?></a></span>
                                    <?php elseif($rdvliste->transfert->paymentInfo->status == 1 ): ?>
                                    <span class="badge badge--warning"><a href="<?php echo e(route('staff.transfert.detail', encrypt($rdvliste->transfert->id))); ?>" title="" ><?php echo e($rdvliste->transfert->reference_souche); ?></a></span>

                                    <?php elseif($rdvliste->transfert->paymentInfo->status == 2): ?>
                                    <span class="badge badge--success"><a href="<?php echo e(route('staff.transfert.detail', encrypt($rdvliste->transfert->id))); ?>" title="" ><?php echo e($rdvliste->transfert->reference_souche); ?></a></span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="<?php echo app('translator')->get('Destinataire'); ?>"><?php echo e($rdvliste->transfert->receiver->nom); ?></td>
                                <td data-label="<?php echo app('translator')->get('Description'); ?>"><?php if($rdvliste->description != NULL): ?><?php echo e($rdvliste->description); ?><?php else: ?> N/A <?php endif; ?></td>                               
                                <td data-label="<?php echo app('translator')->get('Envoye'); ?>"><?php echo e($rdvliste->nom); ?></td>

                                <td data-label="<?php echo app('translator')->get('Contact Envoye'); ?>"><?php echo e($rdvliste->telephone); ?></td>

                                <td data-label="<?php echo app('translator')->get('Agent'); ?>"><?php echo e($rdvliste->livreur->username); ?></td>

                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                     <?php if(($rdvliste->transfert->container_id != 2 || $rdvliste->transfert->container_id == NULL) && $rdvliste->transfert->paymentInfo->status == 2 ): ?>
                                    <a href="<?php echo e(route('staff.transfert.livraison', encrypt($rdvliste->transfert->id))); ?>" title="" class="icon-btn btn--priamry ml-1"><?php echo app('translator')->get('Livrer'); ?></a>
                                    <?php elseif($rdvliste->transfert->container_id == 2  ): ?>
                                    <span class="badge badge--success"><?php echo app('translator')->get('Dejà Livré'); ?></span>

                                    <?php endif; ?>
                                    <!-- <a href="<?php echo e(route('staff.transfert.edit', encrypt($rdvliste->id))); ?>" title="" class="icon-btn btn--success ml-1"><?php echo app('translator')->get('Editer'); ?></a> -->

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
                <?php echo e(paginateLinks($transferts)); ?>

            </div>
</div></div></div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('breadcrumb-plugins'); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
<form action="<?php echo e(route('staff.transfert.searchdelivery')); ?>" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="<?php echo app('translator')->get('Rechercher'); ?>" value="<?php echo e($search ?? ''); ?>">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

    <!-- <form action="<?php echo e(route('staff.transfert.date.search')); ?>" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="<?php echo app('translator')->get('Min date - Max date'); ?>" autocomplete="off" value="<?php echo e(@$dateSearch); ?>">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form> -->
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-lib'); ?>
  <script src="<?php echo e(asset('assets/staff/js/vendor/datepicker.min.js')); ?>"></script>
  <script src="<?php echo e(asset('assets/staff/js/vendor/datepicker.en.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>


<script type="text/javascript">

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/transfert/delivery.blade.php ENDPATH**/ ?>