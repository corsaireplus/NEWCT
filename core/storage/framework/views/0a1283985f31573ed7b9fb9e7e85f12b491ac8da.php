<?php $__env->startSection('panel'); ?>
<div class="row mb-none-30">
    <div class="col-xl-3 col-lg-5 col-md-5 col-sm-12">
        <div class="card b-radius--10 overflow-hidden mt-30 box--shadow1">
            <div class="card-body">
                <h5 class="mb-20 text-muted"><?php echo app('translator')->get('Chauffeur'); ?></h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        <span class="font-weight-bold"><?php echo e(__($courierInfo->mission->chauffeur->firstname)); ?></span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">

                        <span class="font-weight-bold"><?php echo e(__($courierInfo->mission->chauffeur->mobile)); ?></span>
                    </li>

                </ul>
            </div>
        </div>

    </div>

    <div class="col-xl-9 col-lg-7 col-md-7 col-sm-12 mt-10">
        <form action="<?php echo e(route('staff.transactions.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row mb-30">
                <div class="col-lg-6 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Expediteur'); ?></h5>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">

                                    <span><?php echo e(__($courierInfo->client->nom)); ?></span>
                                    <input type="hidden" name="sender_id" id="sender_id" value="<?php echo e($courierInfo->client->id); ?>">
                                    </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">

                                    <span><?php echo e(__($courierInfo->client->contact)); ?></span>
                                </li>
                                <?php if($courierInfo->adresse->adresse): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                    <span><?php echo e(__($courierInfo->adresse->adresse)); ?></span>
                                </li>
                                <?php endif; ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                                    <?php if($courierInfo->adresse->code_postal): ?>
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

                <div class="col-lg-6 mt-2">
                    <div class="card border--dark">
                        <h5 class="card-header bg--dark"><?php echo app('translator')->get('Destinataire'); ?></h5>
                        <div class="card-body">
                                      <div class="row">
                                            <div class="form-group col-lg-12">
                                               
                                                <input type="text" class="form-control" name="reference" id="reference" placeholder="<?php echo app('translator')->get(" Reference Souche"); ?>"
                                                 value="<?php echo e(old('reference')); ?>"   style="background-color : green; color: #ffffff"
                                                    >
                                            </div>
                                            <div class="form-group col-lg-12">
                                                
                                                <input type="text" class="form-control" id="receiver_phone" name="receiver_phone" placeholder="<?php echo app('translator')->get(" Téléphone"); ?>" 
                                                    value="<?php echo e(old('receiver_customer_phone')); ?>" id="receiver_phone"
                                                    >
                                            </div>
                                            <div class="form-group col-lg-12">
                                                
                                                <input type="text" class="form-control"
                                                id="receiver_name" name="receiver_name" value="<?php echo e(old('receiver_name')); ?>" placeholder="<?php echo app('translator')->get(" Nom Destinataire"); ?>" >
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

<div class="row mb-none-30">
    <div class="col-lg-12">
        <div class="card border--dark">
            <h5 class="card-header bg--dark"><?php echo app('translator')->get('Information Envoi'); ?> 
            <button type="button"
                                            class="btn btn-sm btn-outline-light float-end addUserData"><i
                                                class="la la-fw la-plus"></i><?php echo app('translator')->get('Ajouter'); ?>
                                        </button>
            </h5>

            <div class="card-body">
                <div class="row addedField">
                <?php $__currentLoopData = $courierInfo->courierDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row single-item gy-2user-data">
                        
                                <div class="col-md-2">
                                    <select class="form-control selected_type" id="rdv_type_<?php echo e($courier->id); ?>" name="rdvName[]" onChange="getType(this.value,<?php echo e($courier->id); ?>);">
                                        <option><?php echo app('translator')->get('Choisir'); ?></option>
                                        <option value="1" <?php echo e($courier->rdv_type_id == 1 ?  'selected' : ''); ?>>ENVOI</option>
                                        <option value="2" <?php echo e($courier->rdv_type_id == 2 ?  'selected' : ''); ?>>DEPOT</option>
                                        <option value="0" <?php echo e($courier->rdv_type_id == 0 ?  'selected' : ''); ?>>FRAIS</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control select2 fselected_type" id="courier_type_<?php echo e($courier->id); ?>" onchange="currierType(<?php echo e($courier->id); ?>)" name="courierName[]">
                                    <option id="opt_<?php echo e($courier->type->id); ?>" value="<?php echo e($courier->type->id); ?>" 'selected'  data-unit="<?php echo e($courier->type->unit->name); ?>" data-price=<?php echo e(getAmount($courier->type->price)); ?>><?php echo e(__($courier->type->name)); ?></option>

                                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option id="{$type->id}}" value="<?php echo e($type->id); ?>"  data-unit="<?php echo e($type->unit->name); ?>" data-price=<?php echo e(getAmount($type->price)); ?>><?php echo e(__($type->name)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-lg quantity currier_quantity_<?php echo e($courier->id); ?>" value="<?php echo e($courier->qty); ?>" name="quantity[]" onkeyup="courierQuantity(<?php echo e($courier->id); ?>)" aria-label="Qté" aria-describedby="basic-addon2" required="">
                                        <span class="input-group-text unit"><i
                                                                        class="las la-balance-scale"></i></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <input type="text" id="amount" class="form-control form-control-lg currier_fee_<?php echo e($courier->id); ?> montant" value="<?php echo e(getAmount($courier->fee)); ?>" name="amount[]" aria-label="Frais" aria-describedby="basic-addon2" required="">
                                        <span
                                                                    class="input-group-text"><?php echo e(__($general->cur_text)); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                                            <button class="btn btn--danger w-100 removeBtn w-100 h-45"
                                                                type="button">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>
                            
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>
    <div class="col-lg-12">
        <div class="card border--primary mt-3">
            <h5 class="card-header bg--primary  text-white"><?php echo app('translator')->get('Information Paiement'); ?>

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
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-lg-12">
                        <label for="inputMessage"><?php echo app('translator')->get('Note'); ?></label>
                        <textarea name="message" id="observation" rows="6" class="form-control form-control-lg" placeholder="<?php echo app('translator')->get('Observation ou Note'); ?>"><?php echo e(old('message')); ?></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn--primary h-45 w-100 Submitbtn"> <?php echo app('translator')->get('Submit'); ?></button>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
<a href="<?php echo e(route('staff.mission.detailmission', encrypt($courierInfo->mission_id))); ?>" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i><?php echo app('translator')->get('Retour'); ?></a>
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
</script>
<script>
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
    $(document).ready(function() {
        let id = 100;
        $('.addUserData').on('click', function() {
            id++;
            let html = `<div class="row single-item gy-2 user-data">
                            
                                <div class="col-md-2">
                                        <select class="form-control selected_type" id="rdv_type_${id}"  name="rdvName[]"  onChange="getType(this.value,${id});" required="">
                                            <option><?php echo app('translator')->get('Choisir'); ?></option>
                                               <option value="1" >ENVOI</option>
                                               <option value="0" >FRAIS</option>
                                                <option value="2" >DEPOT</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control select_${id} selected_type" id="courier_type_${id}" onchange="currierType(${id})" name="courierName[]" required="">
                                            <option><?php echo app('translator')->get('Choisir'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-lg quantity currier_quantity_${id}" placeholder="<?php echo app('translator')->get('Qté'); ?>" disabled="" onkeyup="courierQuantity(${id})" name="quantity[]" aria-label="Qté" aria-describedby="basic-addon2" required="">
                                            <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>

                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                       <div class="input-group mb-3">
                                            <input type="text" id="amount" class="form-control form-control-lg currier_fee_${id}  montant" placeholder="<?php echo app('translator')->get('Frais'); ?>" onkeyup="changeMontant(${id})" name="amount[]" aria-label="Frais" aria-describedby="basic-addon2" required="" >
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2"><?php echo e($general->cur_text); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                        <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>

                             
                        </div>`;
            $('.addedField').append(html)

        $(".select_"+id).select2({
            allowClear:true,
            tags:true,
            placeholder:""});

        });

        $(document).on('click', '.removeBtn', function() {
            $(this).closest('.user-data').remove();
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/missions/validate_mission2.blade.php ENDPATH**/ ?>