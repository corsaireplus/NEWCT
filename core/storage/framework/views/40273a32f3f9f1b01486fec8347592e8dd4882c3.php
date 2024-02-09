<?php $__env->startSection('content'); ?>
    <?php
        $orderTracking = getContent('order_tracking.content', true);
    ?>
     <section class="track-section pt-120 pb-120">
        <div class="container">
            <div class="section__header section__header__center">
                <span class="section__cate">
                    <?php echo e(__(@$orderTracking->data_values->title)); ?>

                </span>
                <h3 class="section__title"> <?php echo e(__(@$orderTracking->data_values->heading)); ?></h3>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-9 col-xl-6">
                    <form action="<?php echo e(route('order.tracking')); ?>" method="GET" class="order-track-form mb-4 mb-md-5">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field("GET"); ?>
                        <div class="order-track-form-group">
                            <input type="text" name="order_number" placeholder="<?php echo app('translator')->get('Entrez votre reference'); ?>" value="<?php echo e(@$orderNumber->reference_souche); ?>">
                            <button type="submit"><?php echo app('translator')->get('Suivre Maintenant'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        
            <?php if($orderNumber): ?>
            <div class="ustify-content-center">
            <h5 class="track__title j"> Reference : <?php echo e($orderNumber->reference_souche); ?> <br>Nombre : <?php echo e($orderNumber->transfertDetail->count()); ?> colis <br> enregistré le : <?php echo e(date('d-m-Y',strtotime($orderNumber->created_at))); ?></h5>
            </div>
                <div class="track--wrapper">
                    <div class="track__item  done ">
                        <div class="track__thumb">
                            <i class="las la-briefcase"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title"><?php echo app('translator')->get('Picked'); ?></h5>
                        </div>
                    </div>
                    <div class="track__item  done ">
                        <div class="track__thumb">
                            <i class="las la-building"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title"><?php echo app('translator')->get('Assort'); ?></h5>
                        </div>
                    </div>
                    <?php if($orderNumber->paymentInfo->status == 2): ?>
                    <div class="track__item  done">
                        <div class="track__thumb">
                            <i class="las la-money-bill"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title"><?php echo app('translator')->get('Completed'); ?></h5>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="track__item ">
                        <div class="track__thumb">
                            <i class="las la-money-bill"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">Non <?php echo app('translator')->get('Completed'); ?> <br> totalement</h5>
                        </div>
                    </div>

                    <?php endif; ?>
                    
                    <div class="track__item <?php if($orderNumber->status == 1 || $orderNumber->paymentInfo->status == 2): ?> done <?php endif; ?>">
                        <div class="track__thumb">
                            <i class="las la-check-circle"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title"><?php echo app('translator')->get('Envoi En Cours'); ?></h5>
                        </div>
                    </div>
                    
                </div>
            <?php endif; ?>
            <div class="clear"></div>
            <?php if(isset($orderConteneur) && !empty($orderConteneur)): ?>
            <div class="track--wrapper">

            <?php $__empty_1 = true; $__currentLoopData = $orderConteneur; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cont): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                  <div class="track__item  done ">
                        <div class="track__thumb">
                            <i class="las la-ship"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title"><?php echo app('translator')->get('Loaded in container'); ?><br> le <?php echo e(date('d-m-Y',strtotime($cont->conteneur->date))); ?></h5>
                        </div>
                    </div>
                    
                    <div class="track__item done ">
                        <div class="track__thumb">
                            <i class="las la-box"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title"><?php echo e($cont->nb_colis); ?> colis chargé  </h5>
                        </div>
                    </div>
                    <?php if($cont->conteneur->status !=2): ?>
                    <div class="track__item ">
                        <div class="track__thumb">
                            <i class="las la-anchor"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">Arrivée estimée <br>le <?php echo e(date('d-m-Y',strtotime($cont->conteneur->date_arrivee))); ?></h5>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="track__item done ">
                        <div class="track__thumb">
                            <i class="las la-anchor"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">Colis Disponible <br> Appeler au (+225) 0141652222 / 0141652323 </h5>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($cont->date_livraison == null): ?>
                    <div class="track__item ">
                        <div class="track__thumb">
                            <i class="las la-truck"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title">Non <?php echo app('translator')->get('Delivered'); ?></h5>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="track__item done">
                        <div class="track__thumb">
                            <i class="las la-truck"></i>
                        </div>
                        <div class="track__content">
                            <h5 class="track__title"><?php echo app('translator')->get('Delivered'); ?> <br>le <?php echo e(date('d-m-Y',strtotime($cont->date_livraison))); ?></h5>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                    <?php endif; ?>
                    </div>

            <?php endif; ?>
        
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/order_tracking.blade.php ENDPATH**/ ?>