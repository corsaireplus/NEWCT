<?php $__env->startSection('panel'); ?>


 <div class="row mt-30">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div id="impri" class="table-responsive--sm  table-responsive">
                    
                         <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Date'); ?></th>
                                    <th><?php echo app('translator')->get('Reference'); ?></th>
                                    <th><?php echo app('translator')->get('Nb colis'); ?></th>
                                    <th><?php echo app('translator')->get('Chargé'); ?></th>
                                    <th><?php echo app('translator')->get('Client'); ?></th>
                                    <th><?php echo app('translator')->get('Contact'); ?></th>
                                    <th><?php echo app('translator')->get('Reste à Payer'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                           
                            <?php $__empty_1 = true; $__currentLoopData = $rdv_chauf->sortBy('transaction.reftrans'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php if($miss->transaction->status != 2): ?>   
                            
                                <tr>
                               
                                    <td data-label="<?php echo app('translator')->get('Date'); ?>">
                                        <span class="font-weight-bold"><?php echo e(date('d-m-Y', strtotime($miss->transaction->created_at))); ?></span>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Reference'); ?>">
                                    <?php if($miss->transaction->status == 0 ): ?>
                                        <span class="badge badge--danger"><?php echo e($miss->transaction->reftrans); ?></span>
                                        <?php elseif($miss->transaction->status == 1 ): ?>
                                        <span class="badge badge--warning"><?php echo e($miss->transaction->reftrans); ?></span>
                                        <?php elseif($miss->transaction->status == 2): ?>
                                        <span class="badge badge--success"><?php echo e($miss->transaction->reftrans); ?></span>
                                        <?php endif; ?>

                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Nb transaction'); ?>">
                                        <span><?php echo e($miss->transaction->transfertDetail->count()); ?></span>
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Chargé'); ?>">
                                        
                                        <span><?php echo e($miss->nb_colis); ?></span>
                                        
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Client'); ?>">
                                    <?php echo e($miss->transaction->sender->nom); ?>

                                      
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Contact'); ?>">
                                    <?php echo e($miss->transaction->sender->contact); ?>

                                    </td>
                                    <td><?php echo e(getAmount($miss->transaction->paymentInfo->sender_amount - $miss->payer)); ?> <?php echo e(auth()->user()->branch->currencie); ?></td>
                                 
                                    <td data-label="<?php echo app('translator')->get('Status Paiement'); ?>"> 
                                    <?php if($miss->transaction->status == 0 ): ?>
                                    <span class="badge badge--danger"><?php echo app('translator')->get('Non Payé'); ?></span>
                                    <?php elseif($miss->transaction->status == 1 ): ?>
                                    <span class="badge badge--warning"><?php echo app('translator')->get('Partiel'); ?></span>
                                    <?php elseif($miss->transaction->status == 2): ?>
                                    <span class="badge badge--success"><?php echo app('translator')->get('Payé'); ?></span>
                                    <?php endif; ?>
                                  </td>
                                   
                                    
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

<!-- <a href="<?php echo e(route('staff.conteneurs.printcharge',encrypt($mission->idcontainer))); ?>"><button class="btn btn-outline--primary m-1">
                            <i class="las la-download"></i><?php echo app('translator')->get('Imprimer'); ?>
                        </button></a>  -->
<?php if(auth()->user()->branch->country == 'FRA'): ?>
 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.back','data' => ['route' => ''.e(url()->previous()).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => ''.e(url()->previous()).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
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

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/container/listenonpaye.blade.php ENDPATH**/ ?>