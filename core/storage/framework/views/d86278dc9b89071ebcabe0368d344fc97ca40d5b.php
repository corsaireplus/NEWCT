<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table white-space-wrap">
                        <thead>
                            <tr>
                                <th><?php echo app('translator')->get('Date'); ?></th>
                                <th><?php echo app('translator')->get('Chauffeur - Chargeur'); ?></th>
                                <th><?php echo app('translator')->get('Nb RDV'); ?></th>
                                <th><?php echo app('translator')->get('M. Prevu -M. Encaissé'); ?></th>
                                <th><?php echo app('translator')->get('Status'); ?></th>
                                <th><?php echo app('translator')->get('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $missions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $mission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(date('d-m-Y', strtotime($mission->date))); ?></td>
                                <td><span>
                                    <?php echo e($mission->chauffeur->firstname); ?>

                                        </span>
                                   <br>
                                   <?php echo e($mission->chargeur->firstname); ?>

                                </td>

                               
                               

                                <td data-label="<?php echo app('translator')->get('Nb RDV'); ?>"><?php echo e($mission->rdvs->count()); ?></td>
                                        <td><span class="fw-bold d-block">
                                             <?php echo e(getAmount($mission->rdvs->sum('montant'))); ?><?php echo e($general->cur_text); ?> </span>
                                             <?php if($mission->rdvs->sum('encaisse') > 0 ): ?><?php echo e(getAmount( ($mission->rdvs->sum('encaisse') - ($mission->depenses) ))); ?><?php echo e($general->cur_text); ?> <?php endif; ?>
                                            </td>
                                    <td>
                                    <?php if($mission->status == 0): ?>
                                    <a href="<?php echo e(route('staff.mission.edit', encrypt($mission->idmission))); ?>"><span class="badge badge--success"><?php echo app('translator')->get('En Cours'); ?></span></a>
                                    <?php elseif($mission->status == 1): ?>
                                    <a href="javascript:void(0)" class=" open-modal-btn" data-code="reopen" data-idmission="<?php echo e($mission->idmission); ?>"><span class="badge badge--danger"><?php echo app('translator')->get('Terminé'); ?></span></a>
                                    <?php elseif($mission->status == 2): ?>
                                    <a href="<?php echo e(route('staff.mission.edit', encrypt($mission->idmission))); ?>"><span class="badge badge--danger"><?php echo app('translator')->get('Terminé'); ?></span></a>
                                    <?php endif; ?>
                                </td>
                                <td>

                                    <?php if($mission->status == 0): ?>
                                    <a href="<?php echo e(route('staff.mission.assigne', encrypt($mission->idmission))); ?>" title="" data-code="<?php echo e($mission->idmission); ?>"class="btn btn-sm btn-outline--info"><i
                                                    class="las la-file-invoice"></i> Ajouter <?php echo app('translator')->get('RDV'); ?></a>
                                    <?php if($mission->status == 0 && $mission->rdvs->count() == 0): ?>
                                    <a href="javascript:void(0)"  class="icon-btn btn--danger ml-1 open-modal-btn" data-code="delete" data-idmission="<?php echo e($mission->idmission); ?>"><i class="las la-trash"></i></a> 
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if($mission->rdvs->count() > 0 && $mission->status == 0 ): ?>
                                    <a href="<?php echo e(route('staff.mission.detailmission', encrypt($mission->idmission))); ?>" title="" class="icon-btn btn-outline--success" data-code="<?php echo e($mission->idmission); ?>"><?php echo app('translator')->get('Liste RDV'); ?></a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-outline--secondary open-modal-btn" data-code="sms" data-idmission="<?php echo e(encrypt($mission->idmission)); ?>"><i class="las la-phone"></i><?php echo app('translator')->get('Sms'); ?></a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-outline--primary open-modal-btn"  data-code="depense" data-idmission="<?php echo e($mission->idmission); ?>"><i class="las la-pen"></i><?php echo app('translator')->get('Depenses'); ?></a>
                                    <a href="javascript:void(0)" title="" class="icon-btn btn--danger ml-1 open-modal-btn" data-code="fin" data-idmission="<?php echo e($mission->idmission); ?>"><?php echo app('translator')->get('Finir'); ?></a>
                                    <?php endif; ?>
                                    
                                    <?php if($mission->status == 1): ?>
                                    <a href="<?php echo e(route('staff.mission.bilan', encrypt($mission->idmission))); ?>"  class="btn btn-sm btn-outline--primary "><i class="las la-file-invoice"></i> Bilan </a>
                                    <a href="<?php echo e(route('staff.mission.detailmissionend', encrypt($mission->idmission))); ?>" title="" class="icon-btn btn--success ml-1 " data-code="<?php echo e($mission->idmission); ?>"><?php echo app('translator')->get('Details'); ?></a>
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

<!-- Ajoutez un bouton ou un lien avec une classe "open-modal-btn" -->
<!-- <button class="btn btn-primary open-modal-btn" data-code="votre_code">Ouvrir le Modal</button> -->

<!-- Placez la balise vide pour le modal à la fin de votre fichier Blade -->
<div class="modal fade" id="dynamicModal" tabindex="-1" role="dialog" aria-labelledby="dynamicModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dynamicModalLabel">Programme</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
            </div>
            <div class="modal-body">
                <!-- Contenu du modal qui sera rempli dynamiquement par JavaScript -->
            </div>
            
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
<a href="<?php echo e(route('staff.mission.create')); ?>" >
<button type="button" class="btn btn-outline--primary m-1">
                                    <i class="fa la-plus"></i> <?php echo app('translator')->get('Creer Programme'); ?>
                                </button>
                                </a>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['placeholder' => 'Recherche...']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Recherche...']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.date-filter','data' => ['placeholder' => 'Date Debut - Date Fin']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('date-filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Date Debut - Date Fin']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-lib'); ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
<script>

$(document).ready(function() {
        // Assumez que vous avez un bouton ou un lien avec une classe "open-modal-btn"
        $('.open-modal-btn').on('click', function() {
            var code = $(this).data('code');
            var idmission = $(this).data('idmission');

            // Effectuez une requête AJAX pour récupérer les données du modal
            $.post('<?php echo e(route('staff.open-modal')); ?>', { code: code, _token: "<?php echo e(csrf_token()); ?>",idmission:idmission }, function(response) {
                // Ajoutez le contenu au modal
                $('#dynamicModal .modal-body').html(response);

                // Ouvrez le modal
                $('#dynamicModal').modal('show');
            });
        });
    });
//     (function($) {
  
//     $('.depense').on('click', function() {
//         var modal = $('#depenseBy');
//         modal.find('input[name=idmission]').val($(this).data('idmission'))
//         // modal.modal('show');
//         $('#depenseBy').modal('show');
//     });
//     $('.payment').on('click', function() {
//         var modal = $('#paymentBy');
//         modal.find('input[name=code]').val($(this).data('code'))
//         // modal.modal('show');
//         $('#paymentBy').modal('show');
//     });
//     $('.reopen').on('click', function() {
//         var modal = $('#ropenBy');
//         modal.find('input[name=code]').val($(this).data('code'))
//         // modal.modal('show');
//         $('#ropenBy').modal('show');
//     });
//     $('.deletePaiement').on('click', function() {
//         var modal = $('#branchModel');
//         modal.find('input[name=idmission]').val($(this).data('idmission'))
//         modal.modal('show');
//     });

//     $('.envoiSms').off('click').on('click', function() {
//         var modal = $('#envoiSms');
//         modal.find('input[name=mission]').val($(this).data('mission'))
//         modal.find('input[name=contact]').val($(this).data('contact'))
//         $('#envoiSms').modal('show');
//     });
    
//   })(jQuery)
</script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/missions/index.blade.php ENDPATH**/ ?>