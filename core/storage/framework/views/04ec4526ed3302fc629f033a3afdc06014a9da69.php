<?php $__env->startSection('panel'); ?>
<div class="row mt-50 mb-none-30">

        <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--6 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                  
                        <span class="amount"> <?php echo e(getAmount($totalPartiel)); ?>   <?php echo e(auth()->user()->branch->currencie); ?></span>
                     

                   
                    </div>
                    <div class="desciption">
                        <span><?php echo app('translator')->get('Total Colis payé Abidjan'); ?></span>
                    </div>

                    <a href="<?php echo e(route('staff.container.listecolispayer', encrypt($mission->idcontainer))); ?>" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3"><?php echo app('translator')->get('Voir Tout'); ?></a>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--12 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-money-bill-alt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount"><?php echo e(getAmount($totalValeur - ($totalPaye))); ?> <?php echo e(auth()->user()->branch->currencie); ?></span>
                    </div>
                    <div class="desciption">
                        <span><?php echo app('translator')->get('Total restant à payer '); ?> </span>
                    </div>
                    <a href="<?php echo e(route('staff.container.listecolisrestapayer', encrypt($mission->idcontainer))); ?>" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3"><?php echo app('translator')->get('Voir Tout'); ?></a>
                </div>
            </div>
        </div>
</div>

 <div class="row mt-30">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div id="impri" class="table-responsive--sm custom-data-table table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Date'); ?></th>
                                    <th><?php echo app('translator')->get('Reference'); ?></th>
                                    <th><?php echo app('translator')->get('Nb Colis'); ?></th>
                                    <th><?php echo app('translator')->get('Chargé'); ?></th>
                                    <th><?php echo app('translator')->get('Client'); ?></th>
                                    <th><?php echo app('translator')->get('Contact'); ?></th>
                                    <th><?php echo app('translator')->get('Frais'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $rdv_chauf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                             
                           
                                <tr>
                               
                                    <td data-label="<?php echo app('translator')->get('Date'); ?>">
                                        <span class="font-weight-bold"><?php echo e(date('d-m-Y', strtotime($rdv->colis->created_at))); ?></span>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Reference'); ?>">
                                    <?php if($rdv->colis->paymentInfo->status == 0 ): ?>
                                        <span class="badge badge--danger"><a href="<?php echo e(route('staff.transfert.detail', encrypt($rdv->colis->id))); ?>" title="" ><?php echo e($rdv->colis->reference_souche); ?></a></span>
                                        <?php elseif($rdv->colis->paymentInfo->status == 1 ): ?>
                                        <span class="badge badge--warning"><a href="<?php echo e(route('staff.transfert.detail', encrypt($rdv->colis->id))); ?>" title="" ><?php echo e($rdv->colis->reference_souche); ?></a></span>
                                        <?php elseif($rdv->colis->paymentInfo->status == 2): ?>
                                        <span class="badge badge--success"><a href="<?php echo e(route('staff.transfert.detail', encrypt($rdv->colis->id))); ?>" title="" ><?php echo e($rdv->colis->reference_souche); ?></a></span>
                                        <?php endif; ?>

                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Nb Colis'); ?>">
                                        <span><?php echo e($rdv->colis->transfertDetail->count()); ?></span>
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Chargé'); ?>">
                                        
                                        <span><?php echo e($rdv->nb_colis); ?></span>
                                        
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Client'); ?>">
                                    <?php echo e($rdv->colis->sender->nom); ?>

                                      
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Contact'); ?>">
                                    <?php echo e($rdv->colis->sender->contact); ?>

                                    </td>
                                    <td><?php echo e(getAmount($rdv->colis->paymentInfo->receiver_amount)); ?> <?php echo e(auth()->user()->branch->currencie); ?></td>
                                 
                                    <td data-label="<?php echo app('translator')->get('Status Livraison'); ?>"> 
                                    <?php if($rdv->colis->container_id == NULL || empty($rdv->colis->container_id)  ): ?>
                                    <span class="badge badge--danger"><?php echo app('translator')->get('Non Livré'); ?></span>
                                    <?php elseif($rdv->colis->container_id == 1 ): ?>
                                    <span class="badge badge--warning"><?php echo app('translator')->get('Livraison Partiel'); ?></span>
                                    <!-- <?php elseif($rdv->colis->paymentInfo->status == 2): ?>
                                    <span class="badge badge--success"><?php echo app('translator')->get('Payé'); ?></span> -->
                                    <?php endif; ?>
                                </td>
                                    <?php if($rdv->status <= 2 ): ?>
                                    <!-- <a href="<?php echo e(route('staff.mission.validatemission', encrypt($rdv->idrdv))); ?>" title="" class="icon-btn btn--success ml-1 delivery" data-code="<?php echo e($rdv->idrdv); ?>"> Valider <?php echo app('translator')->get('Rdv'); ?></a> -->
                                    <!-- <a href="<?php echo e(route('staff.container.coliscancel',[encrypt($rdv->colis->id),encrypt($mission->idcontainer)])); ?>" title="" class="icon-btn btn--danger ml-1 delivery" data-contenaire="<?php echo e(encrypt($mission->idcontainer)); ?>" data-code="<?php echo e(encrypt($rdv->id)); ?>"> Annuler</a> -->
                                    <?php else: ?> 
                                    
                                    <a href="<?php echo e(route('staff.rdv.details', encrypt($rdv->idrdv))); ?>" title="" class="icon-btn btn--info ml-1 delivery" data-code="<?php echo e($rdv->idrdv); ?>"> Detail</a>
                                    <span class="badge badge-pill bg--success"><?php echo app('translator')->get('Terminé'); ?></span> 
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
                <?php echo e(paginateLinks($rdv_chauf)); ?>

                </div>
            </div>
        </div>
     </div>
</div>
    <?php $__env->stopSection(); ?>
<?php $__env->startPush('breadcrumb-plugins'); ?>
<!-- <button  class="btn btn-primary m-1"><i class="fa fa-download"></i><?php echo app('translator')->get('Print'); ?></button>-->
<?php if(auth()->user()->branch->country == 'FRA'): ?>
<a href="<?php echo e(route('staff.container.print.charge',encrypt($mission->idcontainer))); ?>" class="btn btn-sm btn--secondary box--shadow1 text--small"><i class="las la-printer"></i> <?php echo app('translator')->get('Imprimer'); ?></a> 
<a href="<?php echo e(route('staff.container.liste')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> <?php echo app('translator')->get('Retour'); ?></a>
<?php else: ?>
<a href="<?php echo e(route('staff.container.print.decharge',encrypt($mission->idcontainer))); ?>" class="btn btn-sm btn--secondary box--shadow1 text--small"><i class="las la-printer"></i> <?php echo app('translator')->get('Imprimer'); ?></a> 
<a href="<?php echo e(route('staff.container.liste_decharge')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> <?php echo app('translator')->get('Retour'); ?></a>

<?php endif; ?>
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
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/chargement/detail_decharge.blade.php ENDPATH**/ ?>