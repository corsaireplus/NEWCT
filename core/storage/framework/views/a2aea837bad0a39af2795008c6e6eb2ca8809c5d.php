<?php $__env->startSection('panel'); ?>
    <div class="row mb-none-30">
        <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="mb-20 text-muted"><?php echo app('translator')->get('Staff'); ?></h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold"><?php echo e(__($courierInfo->senderStaff->fullname)); ?></span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold"><?php echo e(__($courierInfo->senderStaff->email)); ?></span>
                        </li>

                       

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Status'); ?>
                            <?php if($courierInfo->senderStaff->status == 1): ?>
                                <span class="badge badge-pill bg--success"><?php echo app('translator')->get('Active'); ?></span>
                            <?php elseif($courierInfo->senderStaff->status == 0): ?>
                                <span class="badge badge-pill bg--danger"><?php echo app('translator')->get('Banned'); ?></span>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>

            <?php if($courierInfo->receiver_staff_id): ?>
                <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
                    <div class="card-body">
                        <h5 class="mb-20 text-muted"><?php echo app('translator')->get('Receiver Staff'); ?></h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo app('translator')->get('Fullname'); ?>
                                <span class="font-weight-bold"><?php echo e(__($courierInfo->receiverStaff->fullname)); ?></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo app('translator')->get('Email'); ?>
                                <span class="font-weight-bold"><?php echo e(__($courierInfo->receiverStaff->email)); ?></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo app('translator')->get('Branch'); ?>
                                <span class="font-weight-bold"><?php echo e(__($courierInfo->receiverBranch->name)); ?></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo app('translator')->get('Status'); ?>
                                <?php if($courierInfo->receiverStaff->status == 1): ?>
                                    <span class="badge badge-pill bg--success"><?php echo app('translator')->get('Active'); ?></span>
                                <?php elseif($courierInfo->receiverStaff->status == 0): ?>
                                    <span class="badge badge-pill bg--danger"><?php echo app('translator')->get('Banned'); ?></span>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12 mt-10">
            <div class="row mb-30">
                <div class="col-lg-6 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Information Client'); ?></h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  <?php echo app('translator')->get('Client'); ?>
                                  <span><?php echo e(__($courierInfo->client->nom)); ?></span>
                                </li>


                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  <?php echo app('translator')->get('Contact'); ?>
                                    <span><?php echo e(__($courierInfo->client->contact)); ?></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  <?php echo app('translator')->get('Adresse'); ?>
                                  <span><?php echo e(__($courierInfo->adresse->adresse)); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  <?php echo app('translator')->get('Code Postal'); ?>
                                  <span><?php echo e(__($courierInfo->adresse->code_postal)); ?></span>
                                </li>
                                
                               
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Paiement Information'); ?></h5>
                        <div class="card-body">
                            <ul class="list-group">
                               
                            <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  <?php echo app('translator')->get('Chauffeur'); ?>
                                  <?php if($courierInfo->mission): ?>
                                  <span><?php echo e($courierInfo->mission->chauffeur->firstname); ?></span>
                                  <?php else: ?>
                                  <span>Aucun Assigné</span>
                                  <?php endif; ?>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  <?php echo app('translator')->get('Date Paiement'); ?>
                                    <?php if(!empty($courierInfo->paymentInfo->date)): ?>
                                        <span><?php echo e(showDateTime($courierInfo->paymentInfo->date, 'd M Y')); ?></span>
                                    <?php else: ?>
                                        <span><?php echo app('translator')->get('N/A'); ?></span>
                                    <?php endif; ?>
                                </li>

                                 <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  <?php echo app('translator')->get('Montant à Payer'); ?>
                                  <span><?php echo e(getAmount($courierInfo->paymentInfo->amount + $courierInfo->paymentInfo->recup_amount)); ?> <?php echo e($general->cur_text); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo app('translator')->get('Status'); ?>
                            <?php if($courierInfo->status == 0): ?>
                                <span class="badge badge-pill bg--success"><?php echo app('translator')->get('En cours'); ?></span>
                            <?php elseif($courierInfo->status  == 1): ?>
                                <span class="badge badge-pill bg--danger"><?php echo app('translator')->get('Banned'); ?></span>
                            <?php endif; ?>
                        </li>
                                <!-- <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                  <?php echo app('translator')->get('Status'); ?>
                                    <?php if($courierInfo->paymentInfo->status == 2): ?>
                                        <span class="badge badge--success"><?php echo app('translator')->get('Payé'); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge--danger"><?php echo app('translator')->get('Non Payé'); ?></span>
                                    <?php endif; ?>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
              
            </div>
         
            <div class="row mb-30">
                <div class="col-lg-12">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Details Rdv'); ?></h5>
                        <div class="card-body">
                            <div class="table-responsive--md  table-responsive">
                                <table class="table table--light style--two">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?php echo app('translator')->get('Type'); ?></th>
                                            <th scope="col"><?php echo app('translator')->get('Produit'); ?></th>
                                            <th scope="col"><?php echo app('translator')->get('Qté'); ?></th>
                                            <th scope="col"><?php echo app('translator')->get('PU'); ?></th>
                                            <th scope="col"><?php echo app('translator')->get('Total'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $courierInfo->courierDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                        
                                            <?php if($courier->rdv_type_id == 1): ?>
                                            <td data-label="<?php echo app('translator')->get('Type'); ?>">
                                           RECUP
                                           </td>
                                           <?php elseif($courier->rdv_type_id == 2): ?>
                                           <td data-label="<?php echo app('translator')->get('Type'); ?>">
                                           DEPOT
                                            </td>
                                            <?php elseif($courier->rdv_type_id == 0): ?>
                                            <td data-label="<?php echo app('translator')->get('Type'); ?>">
                                           FRAIS
                                            </td>
                                            <?php endif; ?>
                                        
                                            <td data-label="<?php echo app('translator')->get('Description'); ?>">
                                                <?php echo e($courier->type->name); ?>

                                            </td>
                                            <td data-label="<?php echo app('translator')->get('Qté'); ?>"><?php echo e($courier->qty); ?></td>
                                            <td data-label="<?php echo app('translator')->get('Frais'); ?>"><?php echo e(getAmount($courier->fee/$courier->qty)); ?></td>
                                            <td data-label="<?php echo app('translator')->get('Frais'); ?>"><?php echo e(getAmount($courier->fee)); ?> <?php echo e($general->cur_text); ?></td>
                                           
                                            
                                           
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <!-- <?php if($courierInfo->paymentInfo->status != 0 ): ?>
                        <div class="table-responsive--md  table-responsive">
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th scope="col"><?php echo app('translator')->get('Date'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Agent'); ?></th>
                                        <th scope="col"><?php echo app('translator')->get('Montant Payé'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    ?>
                                    <?php $__currentLoopData = $courierInfo->paiement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="<?php echo app('translator')->get('Date Paiement'); ?>">
                                            <?php echo e($payment->date_paiement); ?>

                                        </td>
                                        <td data-label="<?php echo app('translator')->get('Agent'); ?>"><?php echo e($payment->agent->firstname); ?></td>
                                        <td data-label="<?php echo app('translator')->get('Montant Payé'); ?>"><?php echo e(getAmount($payment->sender_payer)); ?> <?php echo e(auth()->user()->branch->currencie); ?></td>

                                    </tr>
                                    <?php
                                    $total += $payment->sender_payer;
                                    ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <td></td>
                                    <td>Total Payé</td>
                                    <td data-label="<?php echo app('translator')->get('Total Payé'); ?>"><?php echo e(getAmount($total)); ?> <?php echo e(auth()->user()->branch->currencie); ?></td>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i><?php echo app('translator')->get('Retour'); ?></a>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/rdv/details.blade.php ENDPATH**/ ?>