<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two  white-space-wrap" id="customer">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('Nom Prenom'); ?></th>
                                <th><?php echo app('translator')->get('Contact'); ?></th>
                                <th><?php echo app('translator')->get('Email'); ?></th>
                           
                                <th><?php echo app('translator')->get('Date Creation'); ?></th>
                              
                                <th><?php echo app('translator')->get('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $clients->sortByDesc('transfert_count'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <tr>
                                    <td data-label="<?php echo app('translator')->get('Nom Prenom'); ?>">
                                    <span><?php echo e(__($client->nom)); ?></span><br>
                                  
                                </td>

                                <td data-label="<?php echo app('translator')->get('Contact'); ?>">
                                    <span>
                                    <?php echo e($client->contact); ?>

                                    </span>
                                </td>

                                <td data-label="<?php echo app('translator')->get('Email'); ?>">
                                   
                                    <span> <?php echo e($client->email); ?></span>
                                </td>

                               
                                <td data-label="<?php echo app('translator')->get('Date Creation'); ?>">
                                <span> <?php echo e(date('d-m-Y', strtotime($client->created_at))); ?></span>
                                </td>

                                
                            
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                   <?php if($client->transfert->count() > 0): ?>
                                       <a href="<?php echo e(route('staff.customer.factures', encrypt($client->id))); ?>" title="" class="icon-btn bg--10 ml-1"> <?php echo e($client->transfert->count()); ?> <?php echo app('translator')->get('Factures'); ?></a>
                                       <?php endif; ?>
                                   <a href="<?php echo e(route('staff.customer.edit', encrypt($client->id))); ?>" title="" class="icon-btn btn--priamry ml-1"><?php echo app('translator')->get('Details'); ?></a>
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
                <?php echo e(paginateLinks($clients)); ?>

             </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
  <?php $__env->startPush('breadcrumb-plugins'); ?>
 
    <form action="<?php echo e(route('staff.client.export_list')); ?>" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append ">
            <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="<?php echo app('translator')->get('Min date - Max date'); ?>" autocomplete="off" value="<?php echo e(@$dateSearch); ?>">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
<form action="<?php echo e(route('staff.customer.search')); ?>" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="<?php echo app('translator')->get('Contact Client'); ?>" value="<?php echo e($search ?? ''); ?>">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-lib'); ?>
  <script src="<?php echo e(asset('assets/admin/js/vendor/datepicker.min.js')); ?>"></script>
  <script src="<?php echo e(asset('assets/admin/js/vendor/datepicker.en.js')); ?>"></script>
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
<script>
    (function($){
        "use strict";
        if(!$('.datepicker-here').val()){
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
  </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/customer/index.blade.php ENDPATH**/ ?>