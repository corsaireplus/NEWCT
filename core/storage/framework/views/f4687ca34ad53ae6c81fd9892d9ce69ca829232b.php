<?php
    $contactInfo = getContent('contactInfo.content', true);
?>
<header>
    <div class="header-top d-none d-md-block">
        <div class="container">
            <div class="header-top-wrapper">
                <ul class="header-contact-info">
                    <li>
                        <a href="Mailto:<?php echo e(@$contactInfo->data_values->email); ?>"><i class="las la-envelope"></i>
                            <?php echo e(@$contactInfo->data_values->email); ?></a>
                    </li>
                    <li>
                        <a href="Tel:<?php echo e(@$contactInfo->data_values->mobile); ?>">
                            <i class="las la-phone"></i><?php echo e(@$contactInfo->data_values->mobile); ?>

                        </a>
                    </li>
                </ul>
                <?php if($general->ln): ?>
                    <select class="lang-select ms-auto me-4 langChanage">
                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->code); ?>" <?php if(session('lang') == $item->code): ?> selected <?php endif; ?>>
                                <?php echo e(__($item->name)); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                <?php endif; ?>
                <div class="right-area d-none d-md-block">
                    <a href="<?php echo e(route('order.tracking')); ?>" class="cmn--btn btn--sm text-white me-3">
                        <?php echo app('translator')->get('Order Tracking'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="header__wrapper">
                <div class="logo">
                    <a href="<?php echo e(route('home')); ?>">
                        <img src="<?php echo e(getImage(getFilePath('logoIcon') . '/logo.png')); ?>" alt="<?php echo app('translator')->get('logo'); ?>">
                    </a>
                </div>
                <div class="header-bar ms-auto d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="menu-area align-items-center ">
                    <div class="d-lg-none cross--btn">
                        <i class="las la-times"></i>
                    </div>
                    <div class="right-area d-md-none text-center mb-4">
                        <?php if($general->ln): ?>
                        <select class="lang-select ms-auto m-3 langChanage">
                            <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->code); ?>" <?php if(session('lang') == $item->code): ?> selected <?php endif; ?>>
                                <?php echo e(__($item->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        <?php endif; ?>

                        <a href="<?php echo e(route('order.tracking')); ?>" class="cmn--btn btn--sm me-3"><?php echo app('translator')->get('Order Tracking'); ?></a>
                        <ul class="header-contact-info">
                            <li>
                                <a href="Mailto:<?php echo e(@$contactInfo->data_values->email); ?>">
                                    <i class="las la-envelope"></i> <?php echo e(__(@$contactInfo->data_values->email)); ?>

                                </a>
                            </li>
                            <li>
                                <a href="Tel:<?php echo e(@$contactInfo->data_values->mobile); ?>">
                                    <i class="las la-phone"></i><?php echo e(__(@$contactInfo->data_values->mobile)); ?>

                                </a>
                            </li>
                        </ul>
                    </div>
                    <ul class="menu">
                        <li><a href="<?php echo e(route('pages', ['/'])); ?>"><?php echo app('translator')->get('Home'); ?></a></li>
                        <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="<?php echo e(route('pages', [$data->slug])); ?>"><?php echo e(__($data->name)); ?></a></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e(route('pages', ['blog'])); ?>"><?php echo app('translator')->get('Blog'); ?></a></li>
                        <li><a href="<?php echo e(route('pages', ['contact'])); ?>"><?php echo app('translator')->get('Contact'); ?></a></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/partials/header.blade.php ENDPATH**/ ?>