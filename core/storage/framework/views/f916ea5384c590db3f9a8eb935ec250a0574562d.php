<form action="<?php echo e(route('staff.transaction.store_depense')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('POST'); ?>
                <div class="modal-body">
                    <input type="hidden" name="idmission" value="<?php echo e($idmission); ?>">
                    <input type="hidden" name="cat_id" value="10">
                    <p><?php echo app('translator')->get('Entrez Information Depense'); ?></p>
                    <div class="form-group">
                        

                        <div class="form-group col-lg-6">
                            <input type="numeric" class="form-control" name="montant" id="montant" placeholder="Montant Depense">
                        </div>
                        <div class="form-group col-lg-6">
                        <select  class="form-control" name="cat_id" id="cat_id">
                       <?php $__currentLoopData = $categorie; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->id); ?>"><?php echo e($type->nom); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        </div>
                            <label><?php echo app('translator')->get('Entrer Description'); ?></label>
                            <textarea name="description" id="description" rows="4" class="form-control form-control-lg" placeholder="<?php echo app('translator')->get('Entrer Message'); ?>"><?php echo e(old('message')); ?></textarea>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Ajouter Depense'); ?></button>
                  </div>
                  
            </form><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/modal/depense.blade.php ENDPATH**/ ?>