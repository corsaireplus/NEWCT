<form action="<?php echo e(route('staff.mission.reopen')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('POST'); ?>
                <input type="hidden" name="code" value="<?php echo e($idmission); ?>">
                <div class="modal-body">
                    <p><?php echo app('translator')->get('Etes Vous sûr de rouvrir le programme?'); ?></p>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Reouvrir'); ?></button>
             </div>
            </form><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/modal/reopen.blade.php ENDPATH**/ ?>