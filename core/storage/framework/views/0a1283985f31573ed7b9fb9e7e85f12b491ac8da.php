<?php $__env->startSection('panel'); ?>
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <form action="<?php echo e(route('staff.transactions.store',encrypt($courierInfo->id))); ?>" method="POST">
                <div class="card-body">
                    <?php echo csrf_field(); ?>
                    

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white"><?php echo app('translator')->get('Expediteur'); ?></h5>
                               
                                    <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">

                                    <span><?php echo e(__($courierInfo->client->nom)); ?></span>
                                    <input type="hidden" name="sender_id" id="sender_id" value="<?php echo e($courierInfo->client->id); ?>">
                                    </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">

                                    <span><?php echo e(__($courierInfo->client->contact)); ?></span>
                                </li>
                                <?php if($courierInfo->adresse): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                    <span><?php echo e(__($courierInfo->adresse->adresse)); ?></span>
                                </li>
                                <?php else: ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">

                                <span>N/A</span>
                                </li>
                                <?php endif; ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                    <?php if($courierInfo->adresse): ?>
                                    <span><?php echo e(__($courierInfo->adresse->code_postal)); ?></span>
                                    <?php else: ?>
                                    <span>Aucun Code Postal </span>
                                    <?php endif; ?>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                    <span>RDV Ref : <?php echo e(__($courierInfo->code)); ?></span>
                                    <input type="hidden" name="refrdv" id="refrdv" value="<?php echo e($courierInfo->code); ?>">

                                </li>
                            </ul>
                            </div>
                            </div>
                        </div>
            
                        <div class="col-lg-6">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white"><?php echo app('translator')->get('Destinataire'); ?></h5>
                                <div class="card-body">
                                      <div class="row">
                                            <div class="form-group col-lg-12">
                                               
                                                <input type="text" class="form-control" name="reference" id="reference" placeholder="<?php echo app('translator')->get(" Reference Souche"); ?>"
                                                 value="<?php echo e(old('reference')); ?>"   style="background-color : green; color: #ffffff"
                                                    >
                                            </div>
                                            <div class="form-group col-lg-12">
                                                
                                                <input type="text" class="form-control" id="receiver_phone" name="receiver_phone" placeholder="<?php echo app('translator')->get(" Téléphone"); ?>" 
                                                    value="<?php echo e(old('receiver_customer_phone')); ?>" id="receiver_phone">
                                            </div>
                                            <div class="form-group col-lg-12">
                                                
                                                <input type="text" class="form-control" id="receiver_name" name="receiver_name" value="<?php echo e(old('receiver_name')); ?>" placeholder="<?php echo app('translator')->get(" Nom Destinataire"); ?>" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            
                                            <div class="form-group col-lg-6">
                                                <input type="text" class="form-control"d="receiver_adresse" name="receiver_adrresse" value="<?php echo e(old('receiver_adresse')); ?>" placeholder="<?php echo app('translator')->get(" Adresse"); ?>" >
                                             </div>

                                                <div class="form-group col-lg-6">
                                                    <select class="form-control" name="branch" id="branch" required="">
                                                        <?php $__currentLoopData = $branchs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($branch->id); ?>"><?php echo e(__($branch->name)); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>  
                                                </div>
                                            </div>
                                  
                            
                                      </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary text-white"><?php echo app('translator')->get('Information Envoi'); ?>
                                    <button type="button" class="btn btn-sm btn-outline-light float-end addUserData"><i
                                            class="la la-fw la-plus"></i><?php echo app('translator')->get('Ajouter'); ?>
                                    </button>
                                </h5>
                                <div class="card-body">
                                    <div class="row" id="addedField">
                                        <?php $__currentLoopData = $courierInfo->courierDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="row single-item gy-2">
                                            <div class="col-md-2">
                                                    <select class="form-control " id="rdv_type_<?php echo e($item->id); ?>" name="items[<?php echo e($loop->index); ?>][rdvName]"  onChange="getType(this.value,<?php echo e($item->id); ?>);">
                                                        <option><?php echo app('translator')->get('Choisir'); ?></option>
                                                        <option value="1" <?php echo e($item->rdv_type_id == 1 ?  'selected' : ''); ?>>ENVOI</option>
                                                        <option value="2" <?php echo e($item->rdv_type_id == 2 ?  'selected' : ''); ?>>DEPOT</option>
                                                        <option value="0" <?php echo e($item->rdv_type_id == 0 ?  'selected' : ''); ?>>FRAIS</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-control selected_type" id="courier_type_<?php echo e($item->id); ?>" onchange="currierType(<?php echo e($item->id); ?>)" name="items[<?php echo e($loop->index); ?>][courierName]" required>
                                                        <option disabled selected value=""><?php echo app('translator')->get('Select Courier/Parcel Type'); ?></option>
                                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($type->id); ?>" <?php if($item->type->id==$type->id): echo 'selected'; endif; ?>
                                                                data-unit="<?php echo e($type->unit->name); ?>" data-price="<?php echo e(getAmount($type->price)); ?>"  >
                                                                <?php echo e(__($type->name)); ?>

                                                            </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                </div>
                                               
                                                <div class="col-md-3">
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control quantity currier_quantity_<?php echo e($item->id); ?>" value="<?php echo e($item->qty); ?>" onkeyup="courierQuantity(<?php echo e($item->id); ?>)"  name="items[<?php echo e($loop->index); ?>][quantity]"  required>
                                                        <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <input id="amount" type="text"  class="form-control single-item-amount currier_fee_<?php echo e($item->id); ?> montant" value="<?php echo e(getAmount($item->fee)); ?>"  name="items[<?php echo e($loop->index); ?>][amount]" required>
                                                        <span class="input-group-text"><?php echo e(__($general->cur_text)); ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
 						                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <div class="border-line-area">
                                        <h6 class="border-line-title"><?php echo app('translator')->get('Liste des Transactions'); ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary text-white"><?php echo app('translator')->get('Information Paiement'); ?>
                                   
                                </h5>
                                <div class="card-body">
                                <div class="row">
                    <div class="form-group col-lg-4">
                        <label><?php echo app('translator')->get('TOTAL A PAYER'); ?></label>
                        <input type="text" style="background-color :red; color :#ffffff" class="form-control" id="total_paye" value="<?php echo e(old('total_paye')); ?>" name="total_payer" placeholder="<?php echo app('translator')->get(" Total a Payer"); ?>" maxlength="40" required="">
                    </div>
                    <div class="form-group col-lg-4">
                        <label><?php echo app('translator')->get('MONTANT PAYER'); ?></label>
                        <input type="text" style="background-color : green; color :#ffffff" class="form-control" id="montant_payer" name="montant_payer" value="<?php echo e(old('montant_payer')); ?>" placeholder="<?php echo app('translator')->get(" Montant Payer "); ?>" maxlength="40" required="">
                    </div>
                    <div class="form-group col-lg-4">
                        <label><?php echo app('translator')->get('MODE PAIEMENT'); ?></label>
                        <select class="form-control" id="mode" name="mode" required>
                            <option value="1">ESPECE</option>
                            <option value="2">CHEQUE</option>
                            <option value="3">CARTE BANCAIRE</option>
                            <option value="3">VIREMENT</option>
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="inputMessage"><?php echo app('translator')->get('Note'); ?></label>
                        <textarea name="message" id="observation" rows="6" class="form-control form-control-lg" placeholder="<?php echo app('translator')->get('Observation ou Note'); ?>"><?php echo e(old('message')); ?></textarea>
                    </div>
                </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn--primary h-45 w-100 Submitbtn"> <?php echo app('translator')->get('Submit'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.back','data' => ['route' => ''.e(route('staff.mission.detailmission', encrypt($courierInfo->mission_id))).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => ''.e(route('staff.mission.detailmission', encrypt($courierInfo->mission_id))).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
 <?php $__env->stopPush(); ?>   
<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/viseradmin/js/vendor/datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/viseradmin/js/vendor/datepicker.en.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link  rel="stylesheet" href="<?php echo e(asset('assets/viseradmin/css/vendor/datepicker.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script>
    "use strict";
    $(document).ready(function() {
        var sum = 0;
        // or $( 'input[name^="ingredient"]' )
        $('.montant').each(function(i, e) {
            var v = parseInt($(e).val());
            if (!isNaN(v))
                sum += v;
            console.log('total ' + sum);
        });
        $("#total_paye").val(sum);
        $(document).on('click', '.removeBtnold', function() {
            $(this).closest('.user-data').remove();
        });
    });
    
    $('.montant').keyup(function() {
        var sum = 0;
        $('.montant').each(function(i, e) {
            var v = parseInt($(e).val());
            if (!isNaN(v))
                sum += v;
            console.log('montant modifie  ' + sum);
        });
        $("#total_paye").val(sum);
    });
    $('#receiver_phone').keyup(function() {
        var queryreciever = $(this).val();

        if (queryreciever != '' && queryreciever.length == 10) {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "<?php echo e(route('staff.rdv.fetchreceiver')); ?>",
                method: "POST",
                data: {
                    queryreciever: queryreciever,
                    _token: _token
                },
                success: function(response) {
                    console.log(response);
                    if (response) {
                        $("#receiver_name").val(response.nom);
                        $("#receiver_adresse").val(response.adresse);
                        // $("#sender_code_postal").val(response.code_postal);
                    }

                }
            });
        }
    });

     function currierType(id) {
        let unit = $("#courier_type_" + id).find(':selected').data('unit');
        let price = $("#courier_type_" + id).find(':selected').data('price');
        $("#unit_" + id).html(unit);

        if ($('#courier_type_' + id).val()) {
            $(".currier_quantity_" + id).removeAttr("disabled");
        }
    }

    function courierQuantity(id) {
        let quantity = $(".currier_quantity_" + id).val();
        let price = $("#courier_type_" + id).find(':selected').data('price');
        $(".currier_pu_" + id).val(price);
        $(".currier_fee_" + id).val(quantity * price);

        var sum = 0;
        // or $( 'input[name^="ingredient"]' )
        $('.montant').each(function(i, e) {
            var v = parseInt($(e).val());
            if (!isNaN(v))
                sum += v;
            console.log('total apres ' + sum);
        });
        $("#total_paye").val(sum);
    }

    function getType(val, id) {
        var base_url = "<?php echo e(url('/')); ?>";
        $.ajax({

            type: 'POST',
            url: base_url + '/staff/mission/get_type',
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                id: val,
            },

            success: function(data) {
                //$("#opt_"+id).hide();
                $("#courier_type_" + id).html(data);
            }
        });
    }

    function changeMontant(id) {
        var sum = 0;
        // or $( 'input[name^="ingredient"]' )
        $('.montant').each(function(i, e) {
            var v = parseInt($(e).val());
            if (!isNaN(v))
                sum += v;
            console.log('total changeMontant ' + sum);
        });
        $("#total_paye").val(sum);
    }


</script>
<script>
    "use strict";
    (function ($) {


        $('.addUserData').on('click', function () {
            let length=$("#addedField").find('.single-item').length;
            let html = `
            <div class="row single-item gy-2">
            <div class="col-md-2">
            <select class="form-control" id="rdv_type_${length}"  name="items[${length}][rdvName]"  onChange="getType(this.value,${length});" required="">
                                            <option><?php echo app('translator')->get('Choisir'); ?></option>
                                               <option value="1" >ENVOI</option>
                                               <option value="0" >FRAIS</option>
                                                <option value="2" >DEPOT</option>
                                        </select>
            </div>
                <div class="col-md-3">
                    <select class="form-control select_${length} select2 selected_type" id="courier_type_${length}" onchange="currierType(${length})" name="items[${length}][courierName]" required>
                        <option disabled selected value=""><?php echo app('translator')->get('Choisir'); ?></option>
                           
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <input type="number" class="form-control quantity currier_quantity_${length}" placeholder="<?php echo app('translator')->get('Quantité'); ?>" onkeyup="courierQuantity(${length})" disabled name="items[${length}][quantity]"  required>
                        <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" id="amount"  class="form-control single-item-amount currier_fee_${length}  montant"  onkeyup="changeMontant(${length})" placeholder="<?php echo app('translator')->get('Prix'); ?>"  name="items[${length}][amount]" required>
                        <span class="input-group-text"><?php echo e(__($general->cur_text)); ?></span>
                    </div>
                </div>
                <div class="col-md-1">
                    <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>`;
            $('#addedField').append(html)

             $(".select_"+id).select2({
            allowClear:true,
            tags:true,
            placeholder:""});

        });

        $('#addedField').on('change', '.selected_type', function (e) {
            let unit = $(this).find('option:selected').data('unit');
            let parent = $(this).closest('.single-item');
            $(parent).find('.quantity').attr('disabled', false);
            $(parent).find('.unit').html(`${unit || '<i class="las la-balance-scale"></i>'}`);
            calculation();
        });

        $('#addedField').on('click', '.removeBtn', function (e) {
            let length=$("#addedField").find('.single-item').length;
            if(length <= 1){
                notify('warning',"<?php echo app('translator')->get('At least one item required'); ?>");
            }else{
                $(this).closest('.single-item').remove();
            }
            $('.discount').trigger('change');
            calculation();
        });

        let discount=0;

        $('.discount').on('input change',function (e) {
            this.value = this.value.replace(/^\.|[^\d\.]/g, '');
             discount=parseFloat($(this).val() || 0);
             if(discount >=100){
                discount=100;
                notify('warning',"<?php echo app('translator')->get('Discount can not bigger than 100 %'); ?>");
                $(this).val(discount);
             }
            calculation();
        });

        $('#addedField').on('input', '.quantity', function (e) {
            this.value = this.value.replace(/^\.|[^\d\.]/g, '');

            let quantity = $(this).val();
            if (quantity <= 0) {
                quantity = 0;
            }
            quantity=parseFloat(quantity);

            let parent   = $(this).closest('.single-item');
            let price    = parseFloat($(parent).find('.selected_type option:selected').data('price') || 0);
            let subTotal = price*quantity;

            $(parent).find('.single-item-amount').val(subTotal.toFixed(2));


            var sum = 0;
                // or $( 'input[name^="ingredient"]' )
                $('.montant').each(function(i, e) {
                    var v = parseInt($(e).val());
                    if (!isNaN(v))
                        sum += v;
                    console.log('total apres ' + sum);
                });
                $("#total_paye").val(sum);
        });

        function calculation ( ) {
            let items    = $('#addedField').find('.single-item');
            let subTotal = 0;

            $.each(items, function (i, item) {
                let price = parseFloat($(item).find('.selected_type option:selected').data('price') || 0);
                let quantity = parseFloat($(item).find('.quantity').val() || 0);
                subTotal+=price*quantity;
            });

            subTotal=parseFloat(subTotal);

            let discountAmount = (subTotal/100)*discount;
            let total          = subTotal-discountAmount;

            $('.subtotal').text(subTotal.toFixed(2));
            $('.total').text(total.toFixed(2));
        };

        $('.date').datepicker({
            language  : 'en',
            dateFormat: 'yyyy-mm-dd',
            minDate   : new Date()
        });



       


    })(jQuery);
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .border-line-area {
            position: relative;
            text-align: center;
            z-index: 1;
        }
        .border-line-area::before {
            position: absolute;
            content: '';
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #e5e5e5;
            z-index: -1;
        }
        .border-line-title {
            display: inline-block;
            padding: 3px 10px;
            background-color: #fff;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/missions/validate_mission2.blade.php ENDPATH**/ ?>