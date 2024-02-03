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
                                <!-- <?php if($rdv_dispo->count() > 0): ?>
                            <input type="checkbox" id="chk_all_multiple">
                              <?php endif; ?> -->
                            
                                    <input type="checkbox" class="checkAll"> <?php echo app('translator')->get('Tout Choisir'); ?>
                                </th>
                            </th>
                                    <th><?php echo app('translator')->get('Date'); ?></th>
                                    <th><?php echo app('translator')->get('Observation'); ?></th>
                                    <th><?php echo app('translator')->get('RDV'); ?></th>
                                    <th><?php echo app('translator')->get('Adresse'); ?></th>
                                    <th><?php echo app('translator')->get('Code Postal'); ?></th>
                                    <th><?php echo app('translator')->get('Contact'); ?></th>
                                    <!-- <th><?php echo app('translator')->get('Contact'); ?></th> -->
                                    <!-- <th><?php echo app('translator')->get('RDV'); ?></th> -->
                                  <!-- <th><?php echo app('translator')->get('Montant'); ?></th> -->
                                    <!-- <th><?php echo app('translator')->get('Choisir'); ?></th> -->
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $rdv_dispo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                <td>
                                <input type="checkbox" name="ids[]" class="childCheckBox" data-id="<?php echo e($rdv->idrdv); ?>">
                                </td>
                                <!-- <td data-label="<?php echo app('translator')->get('Selection'); ?>">
                    <input type="checkbox" name="ids[]" value="<?php echo e($rdv->idrdv); ?>" class="checkboxmultiple" id="chk<?php echo e($rdv->idrdv); ?>" onclick='checkcheckboxmultiple();'>
                           </td> -->
                                    <td data-label="<?php echo app('translator')->get('Date'); ?>">
                                        <span class="font-weight-bold"><?php echo e(date('d-m-Y', strtotime($rdv->date))); ?></span>
                                    </td>
                                    <?php if($rdv->observation !== NULL): ?>
                                <td data-label="<?php echo app('translator')->get('Observation'); ?>"><?php echo e($rdv->observation); ?></td>
                                <?php else: ?> <td data-label="<?php echo app('translator')->get('Observation'); ?>"></td> <?php endif; ?>
                                    <td data-label="<?php echo app('translator')->get('RDV'); ?>">
                                        <?php $__currentLoopData = $rdv->rdvDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($detail->rdv_type_id == 2): ?>
                                      DEPOT <?php echo e($detail->qty); ?> <?php echo e($detail->type->name); ?>

                                      <?php elseif($detail->rdv_type_id == 1 ): ?>
                                      RECUP <?php echo e($detail->qty); ?> <?php echo e($detail->type->name); ?>

                                      <?php endif; ?>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Adresse'); ?>">
                                        <span><?php echo e(optional($rdv->adresse)->adresse ?? 'N/A'); ?></span>
                                    </td>
                                    <td data-label="<?php echo app('translator')->get('Code Postal'); ?>">
                                        <span><?php echo e(optional($rdv->adresse)->code_postal ?? 'N/A'); ?></span>
                                    </td>

                                    <td data-label="<?php echo app('translator')->get('Contact'); ?>">
                                    <?php echo e($rdv->client->contact); ?>

                                      
                                    </td>

                                   
                                <!-- <td data-label="<?php echo app('translator')->get('Choisir'); ?>">
                                    <a href="javascript:void(0)"  class="icon-btn btn--primary ml-1 editBrach"
                                          data-idmission="<?php echo e($mission->idmission); ?>"
                                            data-idrdv="<?php echo e($rdv->idrdv); ?>"
                                           
                                            data-idchauf="<?php echo e($mission->chauffeur_idchauffeur); ?>"
                                        ><i class="las la-edit"></i></a>
                                    </td>
                                </tr> -->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr class="d-none dispatch">
                                    <td colspan="8">
                                        <button class="btn btn-sm btn--primary h-45 w-100 " id="dispatch_all"> <i
                                                class="las la-arrow-circle-right "></i> <?php echo app('translator')->get('Ajouter Au Programme'); ?></button>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
              <tr>
                <th>
                <!-- <?php if($rdv_dispo->count() > 0): ?>
                <a href="javascript:void(0)" id="bulk_multiple" data-toggle="modal" data-target="#bulkModalmultiple" disabled class="icon-btn btn--primary ml-1 "><i class="las la-edit"></i></a>
                <?php endif; ?> -->
                </th>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                <?php echo e(paginateLinks($rdv_dispo)); ?>

                </div>
            </div>
       <!-- <table class="table table-bordered " id="rdvs-table" name="rdvs-table">
        <thead>
            <tr>
        
            <th><?php echo app('translator')->get('Date'); ?></th>
             <th><?php echo app('translator')->get('Observation'); ?></th>
            <th><?php echo app('translator')->get('RDV'); ?></th>
            <th><?php echo app('translator')->get('Adresse'); ?></th>
            <th><?php echo app('translator')->get('Code Postal'); ?></th>
            <th><?php echo app('translator')->get('Contact'); ?></th>
            </tr>
        </thead>
    </table> -->
        </div>
    </div>

    <div id="branchModel" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('ajouter RDV'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('staff.mission.storerdv')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="idrdv"id="idrdv" >
                    <input type="hidden" name="idchauf"id="idchauf" >
                    <input type="hidden" name="idmission"id="idmission" >

                   
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal"><?php echo app('translator')->get('Annuler'); ?></button>
                        <button type="submit" class="btn btn--success"><i class="fa fa-fw fa-paper-plane"></i><?php echo app('translator')->get('Ajouter RDV'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="bulkModalmultiple" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('ajouter liste RDV'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('staff.mission.storerdvmulti')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div id="bulk_multi_hidden"></div>
                  
                    <input type="hidden" name="idmission"id="idmission" value="<?php echo e($mission->idmission); ?>" >
                    <input type="hidden" name="idchauf"id="idchauf" value="<?php echo e($mission->chauffeur_idchauffeur); ?>" >

                   
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-dismiss="modal"><?php echo app('translator')->get('Annuler'); ?></button>
                        <button type="submit" class="btn btn--success"><i class="fa fa-fw fa-paper-plane"></i><?php echo app('translator')->get('Ajouter RDV'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.back','data' => ['route' => ''.e(route('staff.mission.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => ''.e(route('staff.mission.index')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
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
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <!-- App scripts -->
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        $('.editBrach').on('click', function() {
            var modal = $('#branchModel');
            modal.find('input[id=idrdv]').val($(this).data('idrdv'));
            modal.find('input[id=idchauf]').val($(this).data('idchauf'));
            modal.find('input[id=idmission]').val($(this).data('idmission'));
            $('#branchModel').modal('show');
        });
             
   
    $('#bulk_multiple').on('click',function(){
    // console.log($( "input[name='ids[]']:checked" ).length);
    if($( "input[name='ids[]']:checked" ).length == 0){
      $('#bulk_multiple').prop('type','button');
        new PNotify({
            title: 'Failed!',
            text: "<?php echo app('translator')->get('fleet.delete_error'); ?>",
            type: 'error'
          });
        $('#bulk_multiple').attr('disabled',true);
    }
    if($("input[name='ids[]']:checked").length > 0){
      // var favorite = [];
      $.each($("input[name='ids[]']:checked"), function(){
          // favorite.push($(this).val());
          $("#bulk_multi_hidden").append('<input type=hidden name=ids[] value='+$(this).val()+'>');
      });
      // console.log(favorite);
    }
  });


  $('#chk_all').on('click',function(){
    if(this.checked){
      $('.checkbox').each(function(){
        $('.checkbox').prop("checked",true);
      });
    }else{
      $('.checkbox').each(function(){
        $('.checkbox').prop("checked",false);
      });
    }
  });
  $('#chk_all_multiple').on('click',function(){
    if(this.checked){
      $('.checkboxmultiple').each(function(){
        $('.checkboxmultiple').prop("checked",true);
      });
    }else{
      $('.checkboxmultiple').each(function(){
        $('.checkboxmultiple').prop("checked",false);
      });
    }
  });
  // Checkbox checked
  function checkcheckbox(){
    // Total checkboxes
    var length = $('.checkbox').length;
    // Total checked checkboxes
    var totalchecked = 0;
    $('.checkbox').each(function(){
        if($(this).is(':checked')){
            totalchecked+=1;
        }
    });
    // console.log(length+" "+totalchecked);
    // Checked unchecked checkbox
    if(totalchecked == length){
        $("#chk_all").prop('checked', true);
    }else{
        $('#chk_all').prop('checked', false);
    }
  }
  function checkcheckboxmultiple(){
    // Total checkboxes
    var length = $('.checkboxmultiple').length;
    // Total checked checkboxes
    var totalchecked = 0;
    $('.checkboxmultiple').each(function(){
        if($(this).is(':checked')){
            totalchecked+=1;
        }
    });
    // console.log(length+" "+totalchecked);
    // Checked unchecked checkbox
    if(totalchecked == length){
        $("#chk_all_multiple").prop('checked', true);
    }else{
        $('#chk_all_multiple').prop('checked', false);
    }
  }
    </script>

<script>
    $('#rdvs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?php echo e(route('staff.mission.createassign',encrypt($mission->idmission))); ?>",
        columns: [
           
            {data: 'date', name: 'date'},
            {data: 'observation', name: 'observation'},
            {data: 'adresse', name: 'adresse'},
            {data: 'code_postal', name: 'code_'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
            
        ]
    });
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
                let ids = [];
                $('.childCheckBox:checked').each(function() {
                    ids.push($(this).attr('data-id'))
                })
                let id = ids.join(',')
                let idmission = "<?php echo e($mission->idmission); ?>";
                let idchauf = "<?php echo e($mission->chauffeur_idchauffeur); ?>";
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "<?php echo e(route('staff.mission.storerdvmulti')); ?>",
                    data: {
                        id: id,
                        idmission :idmission,
                        idchauf : idchauf
                    },
                    success: function(data) {
                        notify('success', 'Rdv Ajouté au programme!')
                        location.reload();
                    }
                })
            });

        })(jQuery)
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/missions/create_mission.blade.php ENDPATH**/ ?>