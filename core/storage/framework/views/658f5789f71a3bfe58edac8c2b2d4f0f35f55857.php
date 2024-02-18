<?php $__env->startSection('panel'); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table">
                        <thead>
                            <tr>
                                <th>
                                    <?php if($colis_dispo->count() > 0): ?>
                                    <input type="checkbox" class="checkAll" id="chk_all_multiple">
                                    <?php endif; ?>
                                </th>
                                <th><?php echo app('translator')->get('Date'); ?></th>
                                <th><?php echo app('translator')->get('Reference Colis'); ?></th>
                                <th><?php echo app('translator')->get('Nb Colis'); ?></th>
                                <th><?php echo app('translator')->get('Nb Chargé'); ?>
                                <th><?php echo app('translator')->get('Expediteur'); ?></th>
                                <th><?php echo app('translator')->get('Contact'); ?></th>
                                <!-- <th><?php echo app('translator')->get('Choisir'); ?></th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $colis_dispo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php if($rdv->transfertDetail->count() > 0): ?>
                            <tr>
                                <td data-label="<?php echo app('translator')->get('Selection'); ?>">
                                    <input type="checkbox"  data-id="<?php echo e($rdv->id); ?>" name="ids[]" value="<?php echo e($rdv->id); ?>" class="checkboxmultiple childCheckBox" id="chk<?php echo e($rdv->id); ?>" onclick='checkcheckboxmultiple();'>
                                </td>
                                <td data-label="<?php echo app('translator')->get('Date'); ?>">
                                    <span><?php echo e(date('d-m-Y', strtotime($rdv->created_at))); ?></span>
                                </td>
                                <td data-label="<?php echo app('translator')->get('Reference Colis'); ?>">
                                <span class="badge badge--primary"> <?php echo e($rdv->reftrans); ?>    </span>
                                </td>
                                <td data-label="<?php echo app('translator')->get('Nb Colis'); ?>">
                                <span> <?php echo e($rdv->transfertDetail->count()); ?>    </span>
                                </td>
                                <td data-label="<?php echo app('translator')->get('Nb Colis Charge'); ?>">
                                    <?php if($rdv->transfertDetail->count() > 1): ?>
                                    <input value="" name="<?php echo e($rdv->id); ?>" id="<?php echo e($rdv->id); ?>" type="number"/>
                                    <?php else: ?>
                                    <input type="hidden" name="<?php echo e($rdv->id); ?>" id="<?php echo e($rdv->id); ?>" data-nb="<?php echo e($rdv->id); ?>" value="1"/>
                                    <?php endif; ?>
                                </td>
                                <td data-label="<?php echo app('translator')->get('Expediteur'); ?>">
                                    <span><?php echo e($rdv->sender->nom); ?></span>
                                </td>
                                <td data-label="<?php echo app('translator')->get('Contact'); ?>">
                                    <?php echo e($rdv->sender->contact); ?>


                                </td>
                                <!-- <td data-label="<?php echo app('translator')->get('Choisir'); ?>">
                                    <a href="javascript:void(0)" class="icon-btn btn--primary ml-1 editBrach" data-idmission="<?php echo e($mission->idcontainer); ?>" data-idrdv="<?php echo e($rdv->id); ?>" data-idchauf="<?php echo e($mission->chauffeur_idchauffeur); ?>"><i class="las la-edit"></i></a>
                                </td> -->
                            </tr>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                            </tr>
                            <?php endif; ?>
                            <tr class="d-none dispatch">
                                    <td colspan="8">
                                        <button class="btn btn-sm btn--primary h-45 w-100 " id="dispatch_all"> <i
                                                class="las la-arrow-circle-right "></i> <?php echo app('translator')->get('Ajouter Au Conteneur'); ?></button>
                                    </td>
                            </tr>

                        </tbody>
                        <!-- <tfoot>
                            <tr>
                                <th>
                                    <?php if($colis_dispo->count() > 0): ?>
                                    <a href="javascript:void(0)" id="bulk_multiple" data-toggle="modal" data-target="#bulkModalmultiple" disabled class="icon-btn btn--primary ml-1 "><i class="las la-edit"></i></a> <?php endif; ?>
                                </th>
                        </tfoot> -->
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                <?php echo e(paginateLinks($colis_dispo)); ?>

            </div>
        </div>
    </div>
</div>

<div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo app('translator')->get('ajouter Colis Au Conteneur'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('staff.conteneurs.storeone')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="idrdv" id="idrdv">
                <input type="hidden" name="idchauf" id="idchauf">
                <input type="hidden" name="idmission" id="idmission">
                <input type="hidden" name="nbcolis" id="nbcolis">
 

                <div class="modal-footer">
                    <button type="button" class="btn btn--secondary" data-dismiss="modal"><?php echo app('translator')->get('Annuler'); ?></button>
                    <button type="submit" class="btn btn--success"><i class="fa fa-fw fa-paper-plane"></i><?php echo app('translator')->get('Ajouter Colis'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="bulkModalmultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo app('translator')->get('ajouter liste colis au conteneur'); ?></h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
            </div>
            <form action="<?php echo e(route('staff.conteneurs.storemulti')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div id="bulk_multi_hidden"></div>

                <input type="hidden" name="idmission" id="idmission" value="<?php echo e($mission->idcontainer); ?>">
                <input type="hidden" name="idchauf" id="idchauf" value="<?php echo e($mission->chauffeur_idchauffeur); ?>">


                <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Ajouter'); ?></button>
              </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('breadcrumb-plugins'); ?>
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
     <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.back','data' => ['route' => ''.e(route('staff.conteneurs.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => ''.e(route('staff.conteneurs.index')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
    "use strict";
    $('.editBrach').on('click', function() {
        var modal = $('#branchModel');
        var id = $(this).data('idrdv');
        var inp =  $('#'+id).val();
        console.log(inp);
        modal.find('input[id=idrdv]').val($(this).data('idrdv'));
        modal.find('input[id=idchauf]').val($(this).data('idchauf'));
        modal.find('input[id=idmission]').val($(this).data('idmission'));
        modal.find('input[id=nbcolis]').val(inp);
        $('#branchModel').modal('show');
    });


    $('#bulk_multiple').on('click', function() {
        // console.log($( "input[name='ids[]']:checked" ).length);
        if ($("input[name='ids[]']:checked").length == 0) {
            $('#bulk_multiple').prop('type', 'button');
            new PNotify({
                title: 'Failed!',
                text: "<?php echo app('translator')->get('fleet.delete_error'); ?>",
                type: 'error'
            });
            $('#bulk_multiple').attr('disabled', true);
        }
        if ($("input[name='ids[]']:checked").length > 0) {
            // var favorite = [];
            $.each($("input[name='ids[]']:checked"), function() {
                // favorite.push($(this).val());
                var inp =  $('#'+$(this).val()).val();
                $("#bulk_multi_hidden").append('<input type=hidden name=ids[] value=' + $(this).val() + '>');
                $("#bulk_multi_hidden").append('<input type=hidden name=nbcolis[] value=' + inp + '>');

            });
            // console.log(favorite);
        }
    });


    $('#chk_all').on('click', function() {
        if (this.checked) {
            $('.checkbox').each(function() {
                $('.checkbox').prop("checked", true);
            });
        } else {
            $('.checkbox').each(function() {
                $('.checkbox').prop("checked", false);
            });
        }
    });
    $('#chk_all_multiple').on('click', function() {
        if (this.checked) {
            $('.checkboxmultiple').each(function() {
                $('.checkboxmultiple').prop("checked", true);
            });
        } else {
            $('.checkboxmultiple').each(function() {
                $('.checkboxmultiple').prop("checked", false);
            });
        }
    });
    // Checkbox checked
    function checkcheckbox() {
        // Total checkboxes
        var length = $('.checkbox').length;
        // Total checked checkboxes
        var totalchecked = 0;
        $('.checkbox').each(function() {
            if ($(this).is(':checked')) {
                totalchecked += 1;
            }
        });
        // console.log(length+" "+totalchecked);
        // Checked unchecked checkbox
        if (totalchecked == length) {
            $("#chk_all").prop('checked', true);
        } else {
            $('#chk_all').prop('checked', false);
        }
    }

    function checkcheckboxmultiple() {
        // Total checkboxes
        var length = $('.checkboxmultiple').length;
        // Total checked checkboxes
        var totalchecked = 0;
        $('.checkboxmultiple').each(function() {
            if ($(this).is(':checked')) {
                totalchecked += 1;
            }
        });
        // console.log(length+" "+totalchecked);
        // Checked unchecked checkbox
        if (totalchecked == length) {
            $("#chk_all_multiple").prop('checked', true);
        } else {
            $('#chk_all_multiple').prop('checked', false);
        }
    }
</script>
<script>
        (function($) {
            "use strict";
            $(".childCheckBox").on('change', function(e) {
                let totalLength = $(".childCheckBox").length;
                let checkedLength = $(".childCheckBox:checked").length;
                if (totalLength == checkedLength) {
                    $('.checkAll').prop('checked', true);
                } else {
                    $('.checkAll').prop('checked', false);
                }
                if (checkedLength) {
                    $('.dispatch').removeClass('d-none')
                } else {
                    $('.dispatch').addClass('d-none')
                }
            });

            $('.checkAll').on('change', function() {
                if ($('.checkAll:checked').length) {
                    $('.childCheckBox').prop('checked', true);
                } else {
                    $('.childCheckBox').prop('checked', false);
                }
                $(".childCheckBox").change();
            });
            $('#dispatch_all').on('click', function() {
            
                        if ($("input[name='ids[]']:checked").length == 0) {
                        $('#bulk_multiple').prop('type', 'button');
                        new PNotify({
                            title: 'Failed!',
                            text: "<?php echo app('translator')->get('fleet.delete_error'); ?>",
                            type: 'error'
                        });
                        $('#bulk_multiple').attr('disabled', true);
                        }
                    if ($("input[name='ids[]']:checked").length > 0) {
                        // var favorite = [];
                        $.each($("input[name='ids[]']:checked"), function() {
                            // favorite.push($(this).val());
                            var inp =  $('#'+$(this).val()).val();
                            $("#bulk_multi_hidden").append('<input type=hidden name=ids[] value=' + $(this).val() + '>');
                            $("#bulk_multi_hidden").append('<input type=hidden name=nbcolis[] value=' + inp + '>');

                        });
                         }
                var modal = $('#bulkModalmultiple');
                $('#bulkModalmultiple').modal('show');
                // let ids = [];
                // let nbs = [];
                // $('.childCheckBox:checked').each(function() {
                //     ids.push($(this).attr('data-id'))
                // })
                // let id = ids.join(',')
                // $.ajax({
                //     type: "POST",
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     url: "<?php echo e(route('staff.courier.dispatch.all')); ?>",
                //     data: {
                //         id: id
                //     },
                //     success: function(data) {
                //         notify('success', 'Colis ajouté avec succès')
                //         location.reload();
                //     }
                // })
            });

        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/container/assign.blade.php ENDPATH**/ ?>