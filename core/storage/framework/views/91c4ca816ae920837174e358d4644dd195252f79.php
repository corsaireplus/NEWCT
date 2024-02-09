<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table white-space-wrap">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('Date Creation'); ?></th>
                                <th><?php echo app('translator')->get('Arrivée'); ?></th>
                                <th><?php echo app('translator')->get('Numero'); ?></th>
                                <th><?php echo app('translator')->get('Armarteur'); ?></th>
                                <th><?php echo app('translator')->get('Status'); ?></th>
                                <th><?php echo app('translator')->get('Nb Colis'); ?></th>
                            
                                <th><?php echo app('translator')->get('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $missions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td data-label="<?php echo app('translator')->get('Date'); ?>"><?php echo e(date('d-m-Y', strtotime($mission->date))); ?></td>
                                <td data-label="<?php echo app('translator')->get('Destination'); ?>"><?php echo e(date('d-m-Y', strtotime($mission->date_arrivee))); ?></td>
                                <td data-label="<?php echo app('translator')->get('Numero'); ?>"><?php echo e($mission->numero); ?></td>
                                <td data-label="<?php echo app('translator')->get('Armateur'); ?>"><?php echo e($mission->armateur); ?></td>

                                <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                    <?php if($mission->status == 0): ?>
                                    <span class="badge badge--success py-2 px-3"><?php echo app('translator')->get('En Cours Chargement'); ?></span>
                                    <?php elseif($mission->status == 1): ?>
                                    <?php if(auth()->user()->username == 'bagate' || auth()->user()->username == 'aminata'|| auth()->user()->username == 'mouna'): ?>
                                    <span class="badge badge--warning py-2 px-3"><a href="javascript:void(0)" title="" class="reopen" data-code="<?php echo e($mission->idcontainer); ?>"><?php echo app('translator')->get('En Route'); ?></a></span>
                                    <?php else: ?>
                                    <span class="badge badge--warning py-2 px-3"><?php echo app('translator')->get('En Route'); ?></span>
                                    <?php endif; ?>
                                    <?php elseif($mission->status == 2): ?>
                                    <?php if(auth()->user()->username == 'bagate' || auth()->user()->username == 'aminata'|| auth()->user()->username == 'mouna'): ?>
                                    <span class="badge badge--warning py-2 px-3"><a href="javascript:void(0)" title="" class="reopen" data-code="<?php echo e($mission->idcontainer); ?>"><?php echo app('translator')->get('Arrivé à Destination'); ?></a></span>
                                    <?php else: ?>
                                    <span class="badge badge--warning py-2 px-3"><?php echo app('translator')->get('Arrivé à Destination'); ?></span>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td data-label="<?php echo app('translator')->get('Nb Colis'); ?>"><?php echo e($mission->envois->count()); ?></td>
                             
                                <td data-label="<?php echo app('translator')->get('Action'); ?>">

                                    <?php if($mission->status == 0): ?>
                                    <a href="<?php echo e(route('staff.container.assigne', encrypt($mission->idcontainer))); ?>" title="" class="icon-btn btn--info ml-1 delivery" data-code="<?php echo e($mission->idcontainer); ?>"><?php echo app('translator')->get('Ajouter Colis'); ?></a>

                                    <?php endif; ?>
                                    <?php if($mission->envois->count() > 0): ?>
                                    <a href="<?php echo e(route('staff.container.detailcontainer', encrypt($mission->idcontainer))); ?>" title="" class="icon-btn btn--success ml-1 " data-code="<?php echo e($mission->idcontainer); ?>"><?php echo app('translator')->get('Liste Colis'); ?></a>
                                    <?php endif; ?>
                                    <?php if($mission->status == 0 && $mission->envois->count() > 0): ?>
                                    <a href="javascript:void(0)" title="" class="icon-btn btn--success ml-1 payment" data-code="<?php echo e($mission->idcontainer); ?>"><?php echo app('translator')->get('Chargé'); ?></a>
                                    <?php endif; ?>
                                    <?php if($mission->status > 0 && $mission->envois->count() > 0): ?>
                                    <a href="javascript:void(0)" class="btn btn-sm btn--secondary box--shadow1 text--small sendSms"  data-container_id="<?php echo e(encrypt($mission->idcontainer)); ?>"><i class="las la-phone"></i><?php echo app('translator')->get('Sms'); ?></a>

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
                <?php echo e(paginateLinks($missions)); ?>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ropenBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('Rouvrir Conteneur'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?php echo e(route('staff.container.reopen')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('POST'); ?>
                <input type="hidden" name="code">
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Etes Vous sûr de rouvrir le conteneur?'); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal"><?php echo app('translator')->get('Annuler'); ?></button>
                    <button type="submit" class="btn btn--success"><?php echo app('translator')->get('Confirmer'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="paymentBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="" lass="modal-title" id="exampleModalLabel"><?php echo app('translator')->get('Chargé Conteneur'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?php echo e(route('staff.container.end')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('POST'); ?>
                <input type="hidden" name="code">
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Etes Vous sûr de terminer le chargement du conteneur?'); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal"><?php echo app('translator')->get('Annuler'); ?></button>
                    <button type="submit" class="btn btn--success"><?php echo app('translator')->get('Confirmer'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="smsModel" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo app('translator')->get('ENVOYER SMS AUX CLIENTS DU CONTENEUR'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="<?php echo e(route('staff.container.sms')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="container_id" id="container_id">
                <input type="hidden" name="contact" id="contact">
                <div class="modal-body">
                      <div class="form-group">
                        
                            <label for="inputMessage"><?php echo app('translator')->get('Entrer Message'); ?></label>
                            <textarea name="message" id="message" rows="4" class="form-control form-control-lg" placeholder="<?php echo app('translator')->get('Entrer Message'); ?>"><?php echo e(old('message')); ?></textarea>
                        
                        </div>

               
                    <p><?php echo app('translator')->get('Êtes vous sûr de vouloir envoyer les sms?'); ?></p>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal"><?php echo app('translator')->get('Annuler'); ?></button>
                    <button type="submit" class="btn btn--success"><i class="fa fa-fw fa-phone"></i><?php echo app('translator')->get('Envoyer'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
<a href="<?php echo e(route('staff.container.create')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small addUnit"><i class="fa fa-fw fa-paper-plane"></i><?php echo app('translator')->get('Ajouter Conteneur'); ?></a>
<!-- <form action="<?php echo e(route('staff.rdv.search')); ?>" method="GET" class="form-inline float-sm-right bg--white mb-2 ml-0 ml-xl-2 ml-lg-0">
        <div class="input-group has_append  ">
            <input type="text" name="search" class="form-control" placeholder="<?php echo app('translator')->get('Contact Client'); ?>" value="<?php echo e($search ?? ''); ?>">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form> -->
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
    "use strict";

    $('.payment').on('click', function() {
        var modal = $('#paymentBy');
        modal.find('input[name=code]').val($(this).data('code'))
        // modal.modal('show');
        $('#paymentBy').modal('show');
    });
    $('.sendSms').on('click', function() {
        var modal = $('#smsModel');
        modal.find('input[name=container_id]').val($(this).data('container_id'))
        modal.modal('show');
    });
    $('.reopen').on('click', function() {
        var modal = $('#ropenBy');
        modal.find('input[name=code]').val($(this).data('code'))
        // modal.modal('show');
        $('#ropenBy').modal('show');
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/chargement/index.blade.php ENDPATH**/ ?>