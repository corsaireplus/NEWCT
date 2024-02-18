<form action="<?php echo e(route('staff.mission.send_sms')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="idmission" id="idmission" value="<?php echo e($idmission); ?>">
                <input type="hidden" name="contact" id="contact" value=<?php echo e($contact); ?>>

                <div class="modal-body">
                      <div class="form-group">
                        
                            <label><?php echo app('translator')->get('Entrer Message'); ?></label>
                            <textarea name="message" id="message" rows="4" class="form-control form-control-lg" placeholder="<?php echo app('translator')->get('Entrer Message'); ?>"><?php echo e(old('message')); ?></textarea>
                        
                        </div>

               <p>NB: SMS non valable les dimanches et jour ferié</p>
                    <p><?php echo app('translator')->get('Êtes vous sûr de vouloir envoyer les sms?'); ?></p>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo app('translator')->get('Envoyer Sms'); ?></button>
                </div>
    <form><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/modal/sms.blade.php ENDPATH**/ ?>