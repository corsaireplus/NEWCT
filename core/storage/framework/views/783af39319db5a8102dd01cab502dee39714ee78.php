<?php $__env->startSection('panel'); ?>
<div class="row mt-50 mb-none-30">
<div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--6 b-radius--10 box-shadow">
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount"><?php echo e(getAmount($totalValeur)); ?> <?php echo e(auth()->user()->branch->currencie); ?></span>
                    </div>
                    <div class="desciption">
                        <span><?php echo app('translator')->get('Total a Payer'); ?></span>
                    </div>
                </div>
            </div>
        </div>
<div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--3 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount"><?php echo e(getAmount($totalPaye)); ?> <?php echo e(auth()->user()->branch->currencie); ?></span>
                    </div>
                    <div class="desciption">
                        <span><?php echo app('translator')->get('Total colis payer'); ?></span>
                    </div>
                    <!-- <a href="#" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3"><?php echo app('translator')->get('Voir Tout'); ?></a> -->
                </div>
            </div>
        </div>
       
        <div class="col-xl-4 col-lg-6 col-sm-6 mb-30">
            <div class="dashboard-w1 bg--12 b-radius--10 box-shadow" >
                <div class="icon">
                    <i class="fa fa-money-bill-alt"></i>
                </div>
                <div class="details">
                    <div class="numbers">
                        <span class="amount"><?php echo e(getAmount($totalValeur - ( $totalPaye))); ?> <?php echo e(auth()->user()->branch->currencie); ?></span>
                    </div>
                    <div class="desciption">
                        <span><?php echo app('translator')->get('Total reste à payer'); ?> </span>
                    </div>
                </div>
            </div>
        </div>
</div>

 <div class="row mt-30">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div id="impri" class="table-responsive--sm  table-responsive">
                    <table class="table table-bordered " id="colis-table" name="colis-table">
       
                     </table>
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                           
                            <?php $__empty_1 = true; $__currentLoopData = $rdv_chauf->sortBy('colis.reference_souche'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php if($miss->colis): ?>   
                            
                                <tr>
                               
                                    <td data-label="<?php echo app('translator')->get('Date'); ?>">
                                        <span class="font-weight-bold"><?php echo e(date('d-m-Y', strtotime($miss->colis->created_at))); ?></span>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Reference'); ?>">
                                    <?php if($miss->colis->paymentInfo->status == 0 ): ?>
                                        <span class="badge badge--danger"><?php echo e($miss->colis->reference_souche); ?></span>
                                        <?php elseif($miss->colis->paymentInfo->status == 1 ): ?>
                                        <span class="badge badge--warning"><?php echo e($miss->colis->reference_souche); ?></span>
                                        <?php elseif($miss->colis->paymentInfo->status == 2): ?>
                                        <span class="badge badge--success"><?php echo e($miss->colis->reference_souche); ?></span>
                                        <?php endif; ?>

                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Nb Colis'); ?>">
                                        <span><?php echo e($miss->colis->transfertDetail->count()); ?></span>
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Chargé'); ?>">
                                        
                                        <span><?php echo e($miss->nb_colis); ?></span>
                                        
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Client'); ?>">
                                    <?php echo e($miss->colis->sender->nom); ?>

                                      
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Contact'); ?>">
                                    <?php echo e($miss->colis->sender->contact); ?>

                                    </td>
                                    <td><?php echo e(getAmount($miss->colis->paymentInfo->sender_amount)); ?> <?php echo e(auth()->user()->branch->currencie); ?></td>
                                 
                                    <td data-label="<?php echo app('translator')->get('Status Paiement'); ?>"> 
                                    <?php if($miss->colis->paymentInfo->status == 0 ): ?>
                                    <span class="badge badge--danger"><?php echo app('translator')->get('Non Payé'); ?></span>
                                    <?php elseif($miss->colis->paymentInfo->status == 1 ): ?>
                                    <span class="badge badge--warning"><?php echo app('translator')->get('Partiel'); ?></span>
                                    <?php elseif($miss->colis->paymentInfo->status == 2): ?>
                                    <span class="badge badge--success"><?php echo app('translator')->get('Payé'); ?></span>
                                    <?php endif; ?>
                                  </td>
                                    <?php if($miss->status <= 2 && auth()->user()->username == 'bagate' ): ?>
                                    <td>
                                     <!-- <a href="<?php echo e(route('staff.mission.validatemission', encrypt($miss->idrdv))); ?>" title="" class="icon-btn btn--success ml-1 delivery" data-code="<?php echo e($miss->idrdv); ?>"> Valider <?php echo app('translator')->get('Rdv'); ?></a>  -->
                                    <a href="<?php echo e(route('staff.container.coliscancel',[encrypt($miss->colis->id),encrypt($mission->idcontainer)])); ?>" title="" class="icon-btn btn--danger ml-1 delivery" data-contenaire="<?php echo e(encrypt($mission->idcontainer)); ?>" data-code="<?php echo e(encrypt($miss->id)); ?>"> Annuler</a>
                                    <?php else: ?> 
                                    
                                    <a href="<?php echo e(route('staff.rdv.details', encrypt($miss->idrdv))); ?>" title="" class="icon-btn btn--info ml-1 delivery" data-code="<?php echo e($miss->idrdv); ?>"> Detail</a>
                                    <span class="badge badge-pill bg--success"><?php echo app('translator')->get('Terminé'); ?></span> 
                                    <td>
                                    <?php endif; ?>
                                    
                                    </td>
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
                <?php echo e(paginateLinks($rdv_chauf)); ?>

                 </div>
            </div>
<!-- new table-->



        </div>
     </div>
</div>
    <?php $__env->stopSection(); ?>
<?php $__env->startPush('breadcrumb-plugins'); ?>
<!-- <button  class="btn btn-primary m-1"><i class="fa fa-download"></i><?php echo app('translator')->get('Print'); ?></button>--><form action="<?php echo e(route('staff.container.search.detailcolis')); ?>" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="<?php echo app('translator')->get('Reference Envoi'); ?>" value="<?php echo e($search ?? ''); ?>">
            <input type="hidden" name="id" value="<?php echo e(encrypt($mission->idcontainer)); ?>" >
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
</form>
<a href="<?php echo e(route('staff.container.print.charge',encrypt($mission->idcontainer))); ?>" class="btn btn-sm btn--secondary box--shadow1 text--small"><i class="las la-printer"></i> <?php echo app('translator')->get('Imprimer'); ?></a> 
<?php if(auth()->user()->branch->country == 'FRA'): ?>
<a href="<?php echo e(route('staff.container.liste')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> <?php echo app('translator')->get('Retour'); ?></a>
<?php else: ?>
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

<?php $__env->startPush('script-lib'); ?>
        
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src="//cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
<script>
    // $('#colis-table').DataTable({
    //     processing: true,
    //     serverSide: true,
    //     responsive: true,
    //     ajax: "<?php echo e(route('staff.container.listecolis',$ct)); ?>",
    //     columns: [
    //         {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
    //         {data:'colis.reference_souche',name:'reference_souche', orderable: false, searchable: false},
    //         {data:'nb_charge',name:'nb_charge'},
    //         {data:'nb_colis',name:'nb_colis'},
    //         {data: 'colis.sender.nom', name: 'nom', orderable: false, searchable: false},
    //         {data: 'colis.sender.contact', name: 'contact', orderable: false, searchable: false},
    //         {data:'frais',name:'frais'},
    //         {data: 'action', name: 'action', orderable: false, searchable: false}
            
    //     ],
    //     dom: 'lBfrtip',
        
    //     buttons: [
    //         'csv', 'excel', 'print','pdf'
    //     ],
    //     "lengthMenu": [ [10, 50, 100, -1], [10, 50, 100, "All"] ]

    // });
</script>
   


<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/chargement/detail.blade.php ENDPATH**/ ?>