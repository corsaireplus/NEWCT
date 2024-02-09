<?php $__env->startSection('panel'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10 ">
            <div class="card-body p-0">
                <div class="table-responsive--sm table-responsive">
                    <table class="table table--light style--two custom-data-table white-space-wrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?php echo app('translator')->get('Date'); ?></th>
                                <th><?php echo app('translator')->get('ETD'); ?></th>
                                <th><?php echo app('translator')->get('ETA'); ?></th>
                                <th><?php echo app('translator')->get('N°CONTENEUR'); ?></th>
                                <th><?php echo app('translator')->get('N°DOSSIER'); ?></th>
                                <th><?php echo app('translator')->get('COMP/BATEAU'); ?></th>
                                <th><?php echo app('translator')->get('Status draft'); ?></th>
                                <th><?php echo app('translator')->get('Status relache'); ?></th>
                                <th><?php echo app('translator')->get('Palette'); ?></th>
                                <th><?php echo app('translator')->get('Montant'); ?></th>
                                <th><?php echo app('translator')->get('Regle'); ?></th>
                                <th><?php echo app('translator')->get('Livrer'); ?></th>

                            </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $rdv; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdvliste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                        <td><a href="<?php echo e(route('staff.suivi.edit', encrypt($rdvliste->id))); ?>"  class="icon-btn btn--primary "><i class="las la-edit"></i></a>
</td>
                        <td><?php echo e(date('d-m-Y', strtotime($rdvliste->date_charge))); ?></td>
                        <td><?php echo e($rdvliste->etd ? $rdvliste->etd :""); ?></td>
                        <td><?php echo e($rdvliste->eta ? $rdvliste->eta :""); ?></td>
                        <td><?php echo e($rdvliste->conteneur_num ? $rdvliste->conteneur_num :""); ?></td>
                        <td><?php echo e($rdvliste->dossier_num ? $rdvliste->dossier_num :""); ?></td>
                        <td><?php echo e($rdvliste->comp_bateau ? $rdvliste->comp_bateau :""); ?></td>
                        <td><?php echo e($rdvliste->draft_status ? $rdvliste->draft_status :""); ?></td>
                        <td><?php echo e($rdvliste->relache_status ? $rdvliste->relache_status :""); ?></td>
                        <td><?php echo e($rdvliste->palette? $rdvliste->palette :""); ?></td>
                        <td><?php echo e($rdvliste->montant ? $rdvliste->montant :""); ?></td>
                        <td><?php echo e($rdvliste->regle ? $rdvliste->regle :""); ?></td>
                        <td><?php echo e($rdvliste->livrer ? $rdvliste->livrer :""); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
         <?php echo e(paginateLinks($rdv)); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('breadcrumb-plugins'); ?>
<a href="<?php echo e(route('staff.suivi.create')); ?>" class="btn btn-sm btn--primary box--shadow1 text--small addUnit"><i class="fa fa-fw fa-paper-plane"></i><?php echo app('translator')->get('Creer Suivi'); ?></a>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/suivi/index.blade.php ENDPATH**/ ?>