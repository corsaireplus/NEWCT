<?php $__env->startSection('panel'); ?>
<div class="row mb-none-30">
    <div class="col-lg-12 col-md-12 mb-30">
        <div class="card">
            <div class="card-body">
                <form action="<?php echo e(route('staff.rdv.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="rdvcode" value="<?php echo e($courierInfo->code); ?>" />
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white"><?php echo app('translator')->get('Information Client'); ?></h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="sender_name" class="form-control-label font-weight-bold"><?php echo app('translator')->get('Nom'); ?></label>
                                            <input type="text" class="form-control form-control-lg" id="sender_name" name="sender_name" value="<?php echo e($courierInfo->sender->nom); ?>" maxlength="40" required="">
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="sender_phone" class="form-control-label font-weight-bold"><?php echo app('translator')->get('Telephone'); ?></label>
                                            <input type="text" class="form-control form-control-lg" id="phone" value="<?php echo e($courierInfo->sender->contact); ?>" name="sender_phone" maxlength="40" required="">
                                            <ul id="suggestions-list"></ul>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6 autocomplete">
                                            <label for="sender_address" class="form-control-label font-weight-bold"><?php echo app('translator')->get('Adresse'); ?></label>
                                            <input type="text" class="form-control form-control-lg" id="sender_address" name="sender_address" value="<?php echo e(optional($courierInfo->adresse)->adresse ?? 'N/A'); ?>" maxlength="255" required="">
                                        </div>


                                        <div class="form-group col-lg-6">
                                            <label for="sender_code_postal" class="form-control-label font-weight-bold"><?php echo app('translator')->get('Code postal'); ?></label>
                                            <input type="text" class="form-control form-control-lg" id="sender_code_postal" name="sender_code_postal" value="<?php echo e(optional($courierInfo->adresse)->code_postal ?? 'N/A'); ?>" maxlength="255" required="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold"><?php echo app('translator')->get('Date'); ?></label>
                                            <input name="date" type="text" data-range="true" data-language="en" class="datepicker-here form-control" data-position='bottom right' placeholder="<?php echo app('translator')->get('Date Rdv'); ?>" autocomplete="off" value="<?php echo e(date('d-m-Y', strtotime($courierInfo->date))); ?>">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="sender_address" class="form-control-label font-weight-bold"><?php echo app('translator')->get('Observation'); ?></label>
                                            <input name="observation" type="text" data-range="true" data-language="en" class="form-control" data-position='bottom right' placeholder="<?php echo app('translator')->get('Observation'); ?>" autocomplete="off" value="<?php echo e($courierInfo->observation); ?>">
                                        </div>
                                    </div>



                                </div>
                            </div>
                            <div class="row mb-30">
                                <div class="col-lg-12">
                                    <div class="card border--primary mt-3">
                                        <h5 class="card-header bg--primary  text-white"><?php echo app('translator')->get('Information RDV'); ?>
                                            <button type="button" class="btn btn-sm btn-outline-light float-right addUserData"><i class="la la-fw la-plus"></i><?php echo app('translator')->get('Ajouter'); ?>
                                            </button>
                                        </h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="row addedField">
                                            <?php $__currentLoopData = $courierInfo->courierDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-12 user-data">
                                                <div class="form-group">

                                                    <div class="input-group mb-md-0 mb-4">
                                                        <div class="col-md-2">
                                                            <select class="form-control form-control-lg" id="rdv_type_<?php echo e($courier->id); ?>" onChange="getType(this.value,<?php echo e($courier->id); ?>);" name="rdvName[]">
                                                                <option><?php echo app('translator')->get('Choisir'); ?></option>
                                                                <option value="1" <?php echo e($courier->rdv_type_id == 1 ?  'selected' : ''); ?>>RECUP</option>
                                                                <option value="2" <?php echo e($courier->rdv_type_id == 2 ?  'selected' : ''); ?>>DEPOT</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select class="form-control select3  form-control-lg" id="courier_type_<?php echo e($courier->id); ?>" onchange="currierType(<?php echo e($courier->id); ?>)" name="courierName[]">

                                                                <option id="opt_<?php echo e($courier->type->id); ?>" value="<?php echo e($courier->type->id); ?>" 'selected' data-unit="<?php echo e($courier->type->unit->name); ?>" data-price=<?php echo e(getAmount($courier->type->price)); ?>><?php echo e(__($courier->type->name)); ?></option>

                                                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option id="{$type->id}}" value="<?php echo e($type->id); ?>" data-unit="<?php echo e($type->unit->name); ?>" data-price=<?php echo e(getAmount($type->price)); ?>><?php echo e(__($type->name)); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control form-control-lg currier_quantity_<?php echo e($courier->id); ?>" value="<?php echo e($courier->qty); ?>" name="quantity[]" onkeyup="courierQuantity(<?php echo e($courier->id); ?>)" aria-label="Qté" aria-describedby="basic-addon2" required="">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="unit_<?php echo e($courier->id); ?>"><i class="las la-balance-scale"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mt-md-0 mt-2">
                                                            <div class="input-group mb-3">
                                                                <input type="text" id="amount" class="form-control form-control-lg currier_fee_<?php echo e($courier->id); ?>" value="<?php echo e(getAmount($courier->fee)); ?>" name="amount[]" aria-label="Recipient's username" aria-describedby="basic-addon2" required="">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text" id="basic-addon2"><?php echo e($general->cur_text); ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1 mt-md-0 mt-2 text-right">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn--danger btn-lg removeBtnold w-100" type="button">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>




                        </div>

                    </div>

                    <div class="form-group">
                        <div class="md-6">
                            <button type="submit" class="btn btn--primary btn-block"><i class="fa fa-fw fa-paper-plane"></i> <?php echo app('translator')->get('Modifier RDV'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
<a href="<?php echo e(route('staff.rdv.list')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-angle-double-left"></i> <?php echo app('translator')->get('Retour'); ?></a>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-lib'); ?>
<script src="<?php echo e(asset('assets/viseradmin/js/vendor/datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/viseradmin/js/vendor/datepicker.en.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('style-lib'); ?>
    <link  rel="stylesheet" href="<?php echo e(asset('assets/viseradmin/css/vendor/datepicker.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>s
<script>
    (function($) {
        "use strict";
        if (!$('.datepicker-here').val()) {
            $('.datepicker-here').datepicker();
        }
    })(jQuery)
    "use strict";

    function rdvType(id) {

    }

    function currierType(id) {
        let unit = $("#courier_type_" + id).find(':selected').data('unit');
        let price = $("#courier_type_" + id).find(':selected').data('price');

        $("#unit_" + id).html(unit);

        if ($('#courier_type_' + id).val()) {

            $(".currier_quantity_" + id).removeAttr("disabled");

        }
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

    function courierQuantity(id) {
        let quantity = $(".currier_quantity_" + id).val();
        let price = $("#courier_type_" + id).find(':selected').data('price');
        let rdv_type = $('#rdv_type_' + id).val();
        $(".currier_fee_" + id).removeAttr("disabled");
        $(".currier_fee_" + id).val(quantity * price);

    }
    $(document).ready(function() {
        let id = 100;
        $(document).on('click', '.removeBtnold', function() {
            $(this).closest('.user-data').remove();
        });
        $('.addUserData').on('click', function() {
            id++;
            let html = `<div class="col-md-12 user-data">
                            <div class="form-group">
                                <div class="input-group mb-md-0 mb-4">
                                <div class="col-md-2">
                                                            <select class="form-control form-control-lg" id="rdv_type_${id}" onChange="getType(this.value,${id});"  name="rdvName[]">
                                                                <option><?php echo app('translator')->get('Choisir'); ?></option>
                                                                <option value="1" >RECUP</option>
                                                                <option value="2" >DEPOT</option>
                                                            </select>
                                                        </div>
                                    <div class="col-md-3">
                                        <select class="form-control form-control-lg" id="courier_type_${id}" onchange="currierType(${id})" name="courierName[]" required="">
                                            <option><?php echo app('translator')->get('Choisir Type'); ?></option>
                                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($type->id); ?>" data-unit="<?php echo e($type->unit->name); ?>" data-price=<?php echo e(getAmount($type->price)); ?>><?php echo e(__($type->name)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-md-0 mt-2">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control form-control-lg currier_quantity_${id}" disabled placeholder="<?php echo app('translator')->get('Qté'); ?>" onkeyup="courierQuantity(${id})" name="quantity[]" aria-label="Qté" aria-describedby="basic-addon2" required="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="unit_${id}"><i class="las la-balance-scale"></i></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mt-md-0 mt-2">
                                       <div class="input-group mb-3">
                                            <input type="text" id="amount" class="form-control form-control-lg currier_fee_${id}" disabled placeholder="<?php echo app('translator')->get('Frais'); ?>" name="amount[]" aria-label="Frais" aria-describedby="basic-addon2" required="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2"><?php echo e($general->cur_text); ?></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-1 mt-md-0 mt-2 text-right">
                                        <span class="input-group-btn">
                                            <button class="btn btn--danger btn-lg removeBtn w-100" type="button">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>`;
            $('.addedField').append(html)
        });

        $(document).on('click', '.removeBtn', function() {
            $(this).closest('.user-data').remove();
        });
    });
</script>
<script>
    $(document).ready(function () {
    var $adresseInput = $('#sender_address');
    var $suggestionsList = $('#suggestions-list');
    var $codePostalInput = $('#sender_code_postal');
    var suggestions;
    var base_url = "<?php echo e(url('/')); ?>";
   // var $suggestionsList = $('#suggestions-list');

    // Fonction pour mettre à jour la liste de suggestions
    function updateSuggestions(suggestionsData) {
        $suggestionsList.empty();

        suggestions = suggestionsData; // Mettez à jour la variable suggestions

        if (suggestions.length === 0) {
            $suggestionsList.hide();
            return;
        }

        suggestions.forEach(function (suggestion) {
            var listItem = $('<li>').text(suggestion.adresse);
            $suggestionsList.append(listItem);
        });

        $suggestionsList.show();
    }

    // Écouter les saisies dans le champ d'adresse
    $adresseInput.on('input', function () {
        var search = $(this).val().toLowerCase();
        var clientId = $('input[name="client_id"]').val();
        // Récupérer les suggestions via une requête AJAX
        $.get(base_url + '/staff/get-client-addresses/' + clientId, { query: search }, function (data) {
            // Mettre à jour la liste de suggestions
            updateSuggestions(data);
        });
    });

    // Gérer la sélection d'une suggestion depuis la liste
    $suggestionsList.on('click', 'li', function () {
        var selectedSuggestion = $(this).text();

        // Remplir le champ d'adresse
        $adresseInput.val(selectedSuggestion);

        // Trouver le code postal correspondant à l'adresse sélectionnée
        var selectedAddressWithPostalCode = suggestions.find(function (suggestion) {
            return suggestion.adresse === selectedSuggestion;
        });

        // Remplir le champ de code postal
        if (selectedAddressWithPostalCode) {
            $codePostalInput.val(selectedAddressWithPostalCode.code_postal);
        }

        $suggestionsList.hide();
    });

    // Cacher la liste de suggestions lorsqu'on clique à l'extérieur
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.autocomplete').length) {
            $suggestionsList.hide();
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/rdv/edit.blade.php ENDPATH**/ ?>