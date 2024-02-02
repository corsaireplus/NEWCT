<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div id="impri" class="table-responsive--sm  table-responsive">
                    <table class="table table--light style--two" id="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><?php echo app('translator')->get('Date'); ?></th>
                                <th><?php echo app('translator')->get('Observation'); ?></th>
                                <th><?php echo app('translator')->get('Code Postal'); ?></th>
                                <th><?php echo app('translator')->get('Adresse'); ?></th>
                                <th><?php echo app('translator')->get('Client'); ?></th>
                                <th><?php echo app('translator')->get('Contact'); ?></th>
                                <th><?php echo app('translator')->get('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody id="tablecontents">
                            <?php $__empty_1 = true; $__currentLoopData = $rdv_chauf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                            <tr class="row1" data-id="<?php echo e($rdv->idrdv); ?>">
                                <td class="pl-3"><i class="fa fa-sort"></i></td>
                                <td data-label="<?php echo app('translator')->get('Date'); ?>">
                                    <span class="font-weight-bold"><?php echo e(date('d-m-Y', strtotime($rdv->date))); ?></span>
                                </td>
                                <?php if($rdv->observation !== NULL): ?>
                                <td data-label="<?php echo app('translator')->get('Observation'); ?>"><?php echo e($rdv->observation); ?></td>
                                <?php else: ?> <td data-label="<?php echo app('translator')->get('Observation'); ?>"></td> <?php endif; ?>
                                <td data-label="<?php echo app('translator')->get('Code Postal'); ?>">
                                    <?php if(isset($rdv->adresse->code_postal)): ?>
                                    <span><?php echo e($rdv->adresse->code_postal); ?></span>
                                    <?php endif; ?>
                                </td>

                                <td data-label="<?php echo app('translator')->get('Adresse'); ?>">
                                <?php if(isset($rdv->adresse->adresse)): ?>

                                    <span><?php echo e($rdv->adresse->adresse); ?></span>
                                    <?php endif; ?>
                                </td>

                                <td data-label="<?php echo app('translator')->get('Client'); ?>">
                                    <?php echo e($rdv->client->nom); ?>


                                </td>

                                <td data-label="<?php echo app('translator')->get('Contact'); ?>">
                                    <?php echo e($rdv->client->contact); ?>

                                </td>

                                <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                    <?php if($rdv->status <= 2 ): ?> 
                                         <a href="<?php echo e(route('staff.mission.validatemission', encrypt($rdv->idrdv))); ?>" title="" class="icon-btn btn--success ml-1 delivery" data-code="<?php echo e($rdv->idrdv); ?>"> Valider <?php echo app('translator')->get('Rdv'); ?></a>
                                        <a href="<?php echo e(route('staff.rdv.missioncancel', encrypt($rdv->idrdv))); ?>" title="" class="icon-btn btn--danger ml-1 delivery" data-code="<?php echo e($rdv->idrdv); ?>"> Annuler</a>
                                    <?php else: ?>
                                        <?php if($rdv->transfert): ?>
                                                <?php if($rdv->transfert->paymentInfo->status == 0 ): ?>
                                                <a href="<?php echo e(route('staff.transfert.edit', encrypt($rdv->transfert->id))); ?>" title="" > <span class="badge badge--danger"><?php echo e($rdv->transfert->reference_souche); ?></span></a>
                                                <?php elseif($rdv->transfert->paymentInfo->status == 1 ): ?>
                                                <a href="<?php echo e(route('staff.transfert.edit', encrypt($rdv->transfert->id))); ?>" title="" > <span class="badge badge--warning"><?php echo e($rdv->transfert->reference_souche); ?></span></a>
                                                 <?php elseif($rdv->transfert->paymentInfo->status == 2): ?>
                                                 <a href="<?php echo e(route('staff.transfert.edit', encrypt($rdv->transfert->id))); ?>" title="" > <span class="badge badge--success"><?php echo e($rdv->transfert->reference_souche); ?></span></a>
                                                 <?php endif; ?>
                                        
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('staff.rdv.detail', encrypt($rdv->idrdv))); ?>" title="" class="icon-btn btn--info ml-1 delivery" data-code="<?php echo e($rdv->idrdv); ?>"> Detail</a>
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
                
            </div>
        </div>
    </div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('breadcrumb-plugins'); ?>
<!-- <a href="javascript:void(0)" class="btn btn-sm btn--secondary box--shadow1 text--small sendSms" onclick="sendSms(<?php echo e(encrypt($mission->idmission)); ?>,<?php echo e($mission->contact); ?>)" data-idmission="<?php echo e(encrypt($mission->idmission)); ?>" data-contact="<?php echo e($mission->contact); ?>"><i class="las la-phone"></i><?php echo app('translator')->get('Sms'); ?></a> -->

<!-- <a href="<?php echo e(route('staff.mission.send_sms',encrypt($mission->idmission))); ?>" class="btn btn-sm btn--secondary box--shadow1 text--small"><i class="las la-phone"></i> <?php echo app('translator')->get('Envoyer SMS'); ?></a> -->
<a href="<?php echo e(route('staff.mission.print',encrypt($mission->idmission))); ?>" class="btn btn-sm btn--secondary box--shadow1 text--small"><i class="las la-printer"></i> <?php echo app('translator')->get('Imprimer'); ?></a> <a href="<?php echo e(route('staff.mission.index')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> <?php echo app('translator')->get('Retour'); ?></a>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
<script>
    "use strict";
    $('.printInvoice').click(function() {
        var divContents = document.getElementById("impri").innerHTML;
        var a = window.open('', '', 'height=500, width=500');
        a.document.write('<html>');
        a.document.write('<body > <h1>Div contents are <br>');
        a.document.write(divContents);
        a.document.write('</body></html>');
        a.document.close();
        a.print();

    });

    $('.payment').on('click', function() {
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
    $(function() {

        $("#table").DataTable();

        $("#tablecontents").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                sendOrderToServer();
            }
        });
    });

    function sendOrderToServer() {

        var order = [];
        var token = $('meta[name="csrf-token"]').attr('content');

        $('tr.row1').each(function(index, element) {
            order.push({
                id: $(this).attr('data-id'),
                position: index + 1
            });
        });
       
 
        $.ajax({
         url:"<?php echo e(route('staff.mission.order_list')); ?>"+'?_token=' + '<?php echo e(csrf_token()); ?>',
         method:"POST",
         dataType: "json",
         data:{order:order, token:token},
         success:function(response){
            
                if (response.status == "success") {
                    console.log(response);
                } else {
                    console.log(response);
                }
            }
        });

    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/missions/details_mission.blade.php ENDPATH**/ ?>