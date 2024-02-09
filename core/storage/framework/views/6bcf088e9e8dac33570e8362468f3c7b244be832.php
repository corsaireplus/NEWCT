<!-- resources/views/modals/dynamic_modal.blade.php -->

<div class="modal fade" id="dynamicModal" tabindex="-1" role="dialog" aria-labelledby="dynamicModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dynamicModalLabel">Dynamic Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Afficher ici les données dynamiques du modal -->
                <?php echo e($modalData->content ?? ''); ?>

            </div>
        </div>
    </div>
</div>
<?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/modal/modal.blade.php ENDPATH**/ ?>