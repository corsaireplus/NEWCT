<?php $__env->startSection('panel'); ?>
<div class="row mb-none-30">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('staff.transaction.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="refpaiement" id="refpaiement" value="<?php echo e($paiement->refpaiement); ?>">

                       <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="fname" class="form-control-label font-weight-bold"><?php echo app('translator')->get('Ref'); ?></label>
                                <?php if($paiement->transfert): ?>
                                <input type="text" class="form-control form-control-lg" id="reference" name="reference" disabled  maxlength="40" required="" value="<?php echo e($paiement->transfert->reference_souche); ?>">
                                <?php endif; ?>
                            </div>

                             <div class="form-group col-lg-6">
                                <label for="lname" class="form-control-label font-weight-bold"><?php echo app('translator')->get('Ref Paiement'); ?></label>
                                <input type="numeric" class="form-control form-control-lg" id="ref" disabled  name="ref"  maxlength="40" value="<?php echo e($paiement->refpaiement); ?>" required="">
                            </div>
                        </div>
                        <div class="row">
                            

                             <div class="form-group col-lg-6">
                                <label for="lname" class="form-control-label font-weight-bold"><?php echo app('translator')->get('Montant à modifier'); ?></label>
                                <input type="numeric" class="form-control form-control-lg" id="montant" name="montant"  maxlength="40" value="<?php echo e($paiement->sender_payer); ?>" required="">
                            </div><div class="form-group col-lg-6">
                        <label for="sender_name" class="form-control-label font-weight-bold"><?php echo app('translator')->get('MODE PAIEMENT'); ?></label>
                        <select class="form-control form-control-lg" id="mode" name="mode" required>
                          
                            <option value="1">ESPECE</option>
                            <option value="2">CHEQUE</option>
                            <option value="3">CARTE BANCAIRE</option>
                        </select>
                    </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn--primary btn-block"><i class="fa fa-fw fa-paper-plane"></i> <?php echo app('translator')->get('Modifier Paiement'); ?></button>
                        </div>
                      
                        </form>
                </div>
            </div>
        </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/bilan/edit_trans.blade.php ENDPATH**/ ?>