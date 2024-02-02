<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two  white-space-wrap" id="customer">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('Date Creation'); ?></th>
                                <th><?php echo app('translator')->get('Nom Prenom'); ?></th>
                                <th><?php echo app('translator')->get('Contact'); ?></th>
                                
                                <th><?php echo app('translator')->get('Objet'); ?></th>
                                <th><?php echo app('translator')->get('Action'); ?></th>
                              
                                <th><?php echo app('translator')->get(''); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                            <td data-label="<?php echo app('translator')->get('Date Creation'); ?>">
                                <span> <?php echo e(date('d-m-Y', strtotime($client->created_at))); ?></span>
                                </td>
                                    <td data-label="<?php echo app('translator')->get('Nom Prenom'); ?>">
                                    <span><?php echo e(__($client->client->nom)); ?></span><br>
                                  
                                </td>

                                <td data-label="<?php echo app('translator')->get('Contact'); ?>">
                                    <span>
                                    <?php echo e($client->client->contact); ?>

                                    </span>
                                </td>
                                 <td data-label="<?php echo app('translator')->get('Observation'); ?>">
                                 <span><?php echo e($client->observation); ?></span>
                                </td>
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                 <span><?php echo e($client->action); ?></span>
                                </td>
                                <td data-label="<?php echo app('translator')->get('Option'); ?>">
                                  
                                   <a href="<?php echo e(route('staff.prospect.editprospect', encrypt($client->id))); ?>" title="" class="icon-btn btn--priamry ml-1"><?php echo app('translator')->get('Details'); ?></a>
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
<a href="<?php echo e(route('staff.prospect.create')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small addUnit"><i class="fa fa-fw fa-paper-plane"></i><?php echo app('translator')->get('Ajouter Prospect'); ?></a>

<form action="<?php echo e(route('staff.customer.search')); ?>" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="<?php echo app('translator')->get('Contact Client'); ?>" value="<?php echo e($search ?? ''); ?>">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/customer/prosp.blade.php ENDPATH**/ ?>