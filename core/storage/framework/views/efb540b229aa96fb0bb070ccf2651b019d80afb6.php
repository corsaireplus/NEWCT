<!doctype html>
<html lang="<?php echo e(config('app.locale')); ?>" itemscope itemtype="http://schema.org/WebPage">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> <?php echo e($general->siteName(__($pageTitle))); ?></title>
    <?php echo $__env->make('partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <link href="<?php echo e(asset('assets/global/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/global/css/all.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/line-awesome.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/animate.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/lightbox.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/owl.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/main.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/custom.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/autocomplete.css')); ?>">

    <?php echo $__env->yieldPushContent('style-lib'); ?>
    <?php echo $__env->yieldPushContent('style'); ?>

    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/color.php')); ?>?color=<?php echo e($general->base_color); ?>">
</head>

<body>

    <?php echo $__env->yieldPushContent('fbComment'); ?>

    <div class="overlay"></div>
    <a href="#0" class="scrollToTop"><i class="las la-angle-up"></i></a>
    <div class="preloader">
        <div class="loader"></div>
    </div>

    <?php echo $__env->yieldContent('panel'); ?>

    <script src="<?php echo e(asset('assets/global/js/jquery-3.6.0.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue.'js/rafcounter.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue.'js/lightbox.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue.'js/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue.'js/owl.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue.'js/viewport.jquery.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue.'js/main.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('script-lib'); ?>
    <?php echo $__env->yieldPushContent('script'); ?>
    <?php echo $__env->make('partials.plugins', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('partials.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <script>
        (function ($) {
            "use strict";

            <?php if($general->ln): ?>
                $(".langChanage").on("change", function () {
                    window.location.href = "<?php echo e(route('home')); ?>/change/" + $(this).val();
                });
            <?php endif; ?>

            var inputElements = $('input,select');
            $.each(inputElements, function (index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $('.policy').on('click', function () {
                $.get(`<?php echo e(route('cookie.accept')); ?>`, function (response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            setTimeout(function () {
                $('.cookies-card').removeClass('hide')
            }, 2000);

            var inputElements = $('[type=text],select,textarea');

            $.each(inputElements, function (index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            $.each($('input, select, textarea'), function (i, element) {
                var elementType = $(element);
                if (elementType.attr('type') != 'checkbox') {
                    if (element.hasAttribute('required')) {
                        $(element).closest('.form-group').find('label').addClass('required');
                    }
                }
            });

        })(jQuery);
    </script>

</body>

</html>
<?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/templates/basic/layouts/app.blade.php ENDPATH**/ ?>