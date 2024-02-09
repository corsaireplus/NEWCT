<?php $__env->startSection('panel'); ?>
<div class="row mt-50 mb-none-30">

<div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--3 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-sms"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount"><?php echo e($smsrdv[0]->smsrdv); ?></span>
                    </div>
                    <div class="desciption">
                        <span><?php echo app('translator')->get('Total Sms RDV ce mois-ci '); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--6 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-wallet"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount"><?php echo e($smscont[0]->smscont); ?></span>
                    </div>
                    <div class="desciption">
                        <span><?php echo app('translator')->get('Total Sms Conteneur ce mois-ci '); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--12 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount"><?php echo e($smscontAbj[0]->smsabj); ?></span>
                    </div>
                    <div class="desciption">
                        <span><?php echo app('translator')->get('Total Sms Abidjan ce mois-ci '); ?></span>
                    </div>
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
                                <th><?php echo app('translator')->get('Date'); ?></th>
                                <th><?php echo app('translator')->get('Conteneur / RDV'); ?></th>
                                <th><?php echo app('translator')->get('Agent'); ?></th>
                                <th><?php echo app('translator')->get('Details'); ?></th>
                                <th><?php echo app('translator')->get('Message'); ?></th>                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $sms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $smsbip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                            
                                <td data-label="<?php echo app('translator')->get('Date'); ?>"><?php echo e(date('d-m-Y', strtotime($smsbip->date))); ?></td>
                                <?php if(str_starts_with($smsbip->rdv_cont, 'R')): ?>
                                <td data-label="<?php echo app('translator')->get('Rdv'); ?>">Rendez-vous</td>
                                <?php else: ?>
                                <td data-label="<?php echo app('translator')->get('Conteneur'); ?>">Conteneur</td>
                                <?php endif; ?>
                                <td data-label="<?php echo app('translator')->get('Agent'); ?>"><?php echo e($smsbip->user->fullname); ?></td>
                                <?php if($smsbip->details): ?>
                                <td><?php echo e($smsbip->details->count()); ?></td>
                                <?php else: ?>
                                <td></td>
                                <?php endif; ?>
                                <?php if($smsbip->message !== NULL): ?>
                                <td data-label="<?php echo app('translator')->get('Message'); ?>"><?php echo e($smsbip->message); ?></td>
                                <?php else: ?> <td data-label="<?php echo app('translator')->get('Message'); ?>">N/A</td> <?php endif; ?>
                               

                               
                              
                               
                              
                                
                                
                                

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
                <?php echo e(paginateLinks($sms)); ?>

            </div>
        </div>
    </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('breadcrumb-plugins'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/sms/index.blade.php ENDPATH**/ ?>