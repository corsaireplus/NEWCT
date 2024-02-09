<form action="<?php echo e(route('staff.mission.delete_mission')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="idmission"id="idmission" value="<?php echo e($idmission); ?> >
                    <div class="modal-body">
                    <p><?php echo app('translator')->get('Êtes vous sûr de vouloir Supprimer ce programme ?'); ?></p>
                </div>
                </form><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/modal/delete.blade.php ENDPATH**/ ?>