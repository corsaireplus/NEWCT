<?php $__env->startSection('panel'); ?>
 <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div id="impri" class="table-responsive--sm custom-data-table table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Date'); ?></th>
                                    <th><?php echo app('translator')->get('Code Postal'); ?></th>
                                    <th><?php echo app('translator')->get('Adresse'); ?></th>
                                    <th><?php echo app('translator')->get('Client'); ?></th>
                                    <th><?php echo app('translator')->get('Contact'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $rdv_chauf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                             
                                <tr>
                               
                                    <td data-label="<?php echo app('translator')->get('Date'); ?>">
                                        <span class="font-weight-bold"><?php echo e(date('d-m-Y', strtotime($rdv->date))); ?></span>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Code Postal'); ?>">
                                        <?php if($rdv->adresse->code_postal): ?>
                                        <span><?php echo e($rdv->adresse->code_postal); ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Adresse'); ?>">
                                        <span><?php echo e($rdv->adresse->adresse); ?></span>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Client'); ?>">
                                    <?php echo e($rdv->client->nom); ?>

                                      
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Contact'); ?>">
                                    <?php echo e($rdv->client->contact); ?>

                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                        <?php if($rdv->transfert): ?>
                                        <?php if($rdv->transfert->paymentInfo->status == 0 ): ?>
                                        <a href="<?php echo e(route('staff.transfert.detail', encrypt($rdv->transfert->id))); ?>" title="" > <span class="badge badge--danger"><?php echo e($rdv->transfert->reference_souche); ?></span></a>
                                    <?php elseif($rdv->transfert->paymentInfo->status == 1 ): ?>
                                    <a href="<?php echo e(route('staff.transfert.detail', encrypt($rdv->transfert->id))); ?>" title="" > <span class="badge badge--warning"><?php echo e($rdv->transfert->reference_souche); ?></span></a>
                                    <?php elseif($rdv->transfert->paymentInfo->status == 2): ?>
                                    <a href="<?php echo e(route('staff.transfert.detail', encrypt($rdv->transfert->id))); ?>" title="" > <span class="badge badge--success"><?php echo e($rdv->transfert->reference_souche); ?></span></a>
                                    <?php endif; ?>
                                        <?php endif; ?>
                                         <?php if($rdv->transaction): ?>
                                        <?php if($rdv->transaction->status == 0 ): ?>
                                        <a href="<?php echo e(route('staff.transactions.details', encrypt($rdv->transaction->id))); ?>" title="" > <span class="badge badge--danger"><?php echo e(isset($rdv->transaction->reftrans) ? $rdv->transaction->reftrans : $rdv->transaction->trans_id); ?></span></a>
                                    <?php elseif($rdv->transaction->status == 1 ): ?>
                                    <a href="<?php echo e(route('staff.transactions.details', encrypt($rdv->transaction->id))); ?>" title="" > <span class="badge badge--warning"><?php echo e(isset($rdv->transaction->reftrans) ? $rdv->transaction->reftrans : $rdv->transaction->trans_id); ?></span></a>
                                    <?php elseif($rdv->transaction->status == 2): ?>
                                    <a href="<?php echo e(route('staff.transactions.details', encrypt($rdv->transaction->id))); ?>" title="" > <span class="badge badge--success"><?php echo e(isset($rdv->transaction->reftrans) ? $rdv->transaction->reftrans : $rdv->transaction->trans_id); ?></span></a>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                        <?php if($rdv->depot): ?>
                                        <span class="badge badge--primary"> Depot <?php echo e($rdv->depot->refpaiement); ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                       
                                    <a href="<?php echo e(route('staff.rdv.detail', encrypt($rdv->idrdv))); ?>" title="" class="icon-btn btn--info ml-1 delivery" data-code="<?php echo e($rdv->idrdv); ?>"> Detail</a>
                                    <span class="badge badge-pill bg--success"><?php echo app('translator')->get('Terminé'); ?></span> 
                                   
                                    
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
                <?php echo e(paginateLinks($rdv_chauf)); ?>

                </div>
            </div>
        </div>
     </div>
</div>
    <?php $__env->stopSection(); ?>
<?php $__env->startPush('breadcrumb-plugins'); ?>
<!-- <button  class="btn btn-primary m-1"><i class="fa fa-download"></i><?php echo app('translator')->get('Print'); ?></button>-->
 <a href="<?php echo e(route('staff.mission.index')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> <?php echo app('translator')->get('Retour'); ?></a>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
<script>
    "use strict";
    $('.printInvoice').click(function () { 
        var divContents = document.getElementById("impri").innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<body > <h1>Div contents are <br>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
            
    });

    $('.payment').on('click', function () {
        var modal = $('#paymentBy');
        modal.find('input[name=code]').val($(this).data('code'))
        modal.modal('show');
    });
</script>
<script type="text/javascript" language="javascript">
    function printDiv() {
            var divContents = document.getElementById("impri").innerHTML;
            var a = window.open('', '', 'height=500, width=500');
            a.document.write('<html>');
            a.document.write('<body > <h1>Div contents are <br>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
        }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/missions/details_mission_end.blade.php ENDPATH**/ ?>