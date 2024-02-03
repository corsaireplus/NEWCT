<?php $__env->startSection('panel'); ?>
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('staff.transactions.updating')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="transfert_id" id="transfert_id" value="<?php echo e($courierInfo->id); ?>">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white"><?php echo app('translator')->get('Expediteur'); ?></h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Contact'); ?></label>
                                            <!--  suppression de disabled  sur l expediteur pour permtttre la modification du contact expediteur-->
                                            <input type="text" class="form-control" id="phone" value="<?php echo e($courierInfo->sender->contact); ?>" name="sende_phone" maxlength="40" disabled required="">
                                            <input type="hidden" name="sender_phone" id="sender_phone" value="<?php echo e($courierInfo->sender->contact); ?>">
                                            <input type="hidden" name="sender_id" id="sender_id" value="<?php echo e($courierInfo->sender->id); ?>">


                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Nom'); ?></label>
                                            <input type="text" class="form-control" id="sender_name" name="sender_name" value="<?php echo e($courierInfo->sender->nom); ?>" placeholder="<?php echo app('translator')->get(" Expediteur"); ?>" maxlength="40" required="">
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Reference'); ?></label>
                                            <input type="text" style="background-color : green; color: #ffffff" class="form-control form-control-lg" id="reference" name="reference" value="<?php echo e($courierInfo->reftrans); ?>" maxlength="40" required="">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Type Envoi'); ?></label>
                                            <select class="form-control" name="envoi" id="envoi" required="">
                                                <option value="1" <?php echo e($courierInfo->type_envoi == 1 ?  'selected' : ''); ?>>Maritime</option>
                                                <option value="2" <?php echo e($courierInfo->type_envoi == 2 ?  'selected' : ''); ?>>Aerien</option>

                                            </select>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white"><?php echo app('translator')->get('Destinataire'); ?></h5>
                                <div class="card-body">
                                    <div class="row">

                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Contact'); ?></label>
                                            <input type="text" class="form-control" id="receiver_phone" name="receiver_phone" value="<?php echo e($courierInfo->receiver->contact); ?>" required="">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Nom'); ?></label>
                                            <input type="text" class="form-control" id="receiver_name" name="receiver_name" value="<?php echo e($courierInfo->receiver->nom); ?>" maxlength="40" required="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Adresse'); ?></label>
                                            <input type="text" class="form-control" id="receiver_address" name="receiver_address" <?php if($courierInfo->receiver_adresse != null): ?> value="<?php echo e($courierInfo->receiver_adresse->adresse); ?>" <?php else: ?> value="" placeholder="Entrer Adresse" <?php endif; ?> >
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('Destination'); ?></label>
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

                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white"><?php echo app('translator')->get('Information Colis'); ?>
                                <button type="button" class="btn btn-sm btn-outline-light float-end addUserData"><i
                                            class="la la-fw la-plus"></i><?php echo app('translator')->get('Ajouter'); ?>
                                    </button>
                                </h5>

                                <div class="card-body">
                                    <div class="row addedField">
                                        <?php $__currentLoopData = $courierInfo->courierDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <div class="row single-item gy-2 user-data">
                                                    <div class="col-md-4">
                                                        <select class="form-control  form-control-lg" id="courier_type_0" onchange="currierType(0)" name="courierName[]">
                                                            <option id="opt_<?php echo e($courier->type->id); ?>" value="<?php echo e($courier->type->id); ?>" 'selected' data-unit="<?php echo e($courier->type->unit->name); ?>" data-price=<?php echo e(getAmount($courier->type->price)); ?>><?php echo e(__($courier->type->name)); ?></option>

                                                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option id="{$type->id}}" value="<?php echo e($type->id); ?>" data-unit="<?php echo e($type->unit->name); ?>" data-price=<?php echo e(getAmount($type->price)); ?>><?php echo e(__($type->name)); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-lg quantity currier_quantity_<?php echo e($courier->id); ?>" value="<?php echo e($courier->qty); ?>" name="quantity[]" onkeyup="courierQuantity(<?php echo e($courier->id); ?>)" aria-label="Qté" aria-describedby="basic-addon2" required="">
                                                            <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="input-group mb-3">
                                                            <input type="text" id="amount" class="form-control form-control-lg currier_fee_<?php echo e($courier->id); ?> montant" value="<?php echo e(getAmount($courier->fee)); ?>" name="amount[]" aria-label="Frais" aria-describedby="basic-addon2" required="">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-30">
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white"><?php echo app('translator')->get('Information Paiement'); ?>

                                </h5>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('TOTAL A PAYER'); ?></label>
                                            <input type="text" style="background-color :red; color :#ffffff" class="form-control form-control-lg" id="total_paye" value="<?php echo e(old('total_paye')); ?>" name="total_payer" placeholder="<?php echo app('translator')->get(" Total a Payer"); ?>" maxlength="40" required="">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('DEJA PAYER'); ?></label>
                                            <input type="text" class="form-control form-control-lg" disabled id="deja_paye" value="<?php echo e($deja_payer); ?>" name="deja_paye" maxlength="40" required="">
                                            <input type="hidden" name="deja_payer" id="deja_payer" value="<?php echo e($deja_payer); ?>">

                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('MONTANT PAYER'); ?></label>
                                            <input type="text" style="background-color : green; color :#ffffff" class="form-control form-control-lg" id="montant_payer" name="montant_payer" value="<?php echo e(old('montant_payer')); ?>" placeholder="<?php echo app('translator')->get(" Montant Payer "); ?>" maxlength="40" required="">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label><?php echo app('translator')->get('MODE PAIEMENT'); ?></label>
                                            <select class="form-control form-control-lg" id="mode" name="mode" required>

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
                   
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>

<a href="<?php echo e(url()->previous()); ?>" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> <?php echo app('translator')->get('Retour'); ?></a>

<!-- <a href="<?php echo e(route('staff.transfert.liste')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> <?php echo app('translator')->get('Retour'); ?></a> -->
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

    $('.select2-basic').select2({});


    $('#phone').keyup(function() {
        var query = $(this).val();

        if (query != '' && query.length == 10) {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "<?php echo e(route('staff.rdv.fetch')); ?>",
                method: "POST",
                data: {
                    query: query,
                    _token: _token
                },
                success: function(response) {
                    console.log(response);
                    if (response) {
                        $("#sender_name").val(response.nom);
                        // $("#sender_address").val(response.adresse);
                        //$("#sender_code").val(response.code_postal);
                    }

                }
            });
        }
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
                        $("#receiver_address").val(response.adresse);
                        //  $("#receiver_code").val(response.code_postal);
                    }

                }
            });
        }
    });
</script>
<script>
    "use strict";

    function currierType(id) {
        let unit = $("#courier_type_" + id).find(':selected').data('unit');
        let price = $("#courier_type_" + id).find(':selected').data('price');
        $("#unit_" + id).html(unit);

        if ($('#courier_type_' + id).val()) {
            $(".currier_quantity_" + id).removeAttr("disabled");
        }
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

    function courierQuantity(id) {
        let quantity = $(".currier_quantity_" + id).val();
        let price = $("#courier_type_" + id).find(':selected').data('price');
        $(".currier_fee_" + id).val(quantity * price);
        $(".currier_fee_" + id).removeAttr("disabled");

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

    $(document).ready(function() {
        let id = 100;
        $('.addUserData').on('click', function() {
            id++;
            let html = `<div class="row single-item gy-2 user-data">
                            
                                    <div class="col-md-4">
                                        <select class="form-control select2-basic_${id} selected_type" id="courier_type_${id}" onchange="currierType(${id})" name="courierName[]" required="">
                                            <option><?php echo app('translator')->get('Choisir'); ?></option>
                                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($type->id); ?>" data-unit="<?php echo e($type->unit->name); ?>" data-price=<?php echo e(getAmount($type->price)); ?>><?php echo e(__($type->name)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-lg currier_quantity_${id}" placeholder="<?php echo app('translator')->get('Qté'); ?>" disabled="" onkeyup="courierQuantity(${id})" name="quantity[]" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                            <span class="input-group-text unit"><i class="las la-balance-scale"></i></span>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                       <div class="input-group mb-3">
                                            <input type="text" id="amount" class="form-control form-control-lg currier_fee_${id} montant" placeholder="<?php echo app('translator')->get('Frais'); ?>" onkeyup="changeMontant(${id})" name="amount[]" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                            <span class="input-group-text"><?php echo e(__($general->cur_text)); ?></span>

                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <button class="btn btn--danger w-100 removeBtn w-100 h-45" type="button">
                                            <i class="fa fa-times"></i>
                                        </button>
                                      </div>

                              
                        </div>`;
            $('.addedField').append(html)
            $('.select2-basic_' + id).select2({});
        });

        $(document).on('click', '.removeBtn', function() {
            $(this).closest('.user-data').remove();
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/transactions/edit.blade.php ENDPATH**/ ?>