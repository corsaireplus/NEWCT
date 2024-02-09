<?php $__env->startSection('panel'); ?>
    <?php if(@json_decode($general->system_info)->version > systemDetails()['version']): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">
                        <h3 class="card-title"> <?php echo app('translator')->get('New Version Available'); ?> <button class="btn btn--dark float-end"><?php echo app('translator')->get('Version'); ?>
                                <?php echo e(json_decode($general->system_info)->version); ?></button> </h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark"><?php echo app('translator')->get('What is the Update ?'); ?></h5>
                        <p>
                            <pre class="f-size--24"><?php echo e(json_decode($general->system_info)->details); ?></pre>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if(@json_decode($general->system_info)->message): ?>
        <div class="row">
            <?php $__currentLoopData = json_decode($general->system_info)->message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-12">
                    <div class="alert border border--primary" role="alert">
                        <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                        <p class="alert__message"><?php echo $msg; ?></p>
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--purple has-link overflow-hidden box--shadow2">
                <a href="<?php echo e(route('admin.courier.info.index') . '?status=0'); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-hourglass-start f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Sent In Queue'); ?></span>
                            <h2 class="text-white"><?php echo e($sentInQueue); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--green has-link box--shadow2">
                <a href="<?php echo e(route('admin.courier.info.index') . '?status=1'); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-dolly f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Shipped Courier'); ?></span>
                            <h2 class="text-white"><?php echo e($shippingCourier); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--deep-purple has-link box--shadow2">
                <a href="<?php echo e(route('admin.courier.info.index') . '?status=2'); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="lab la-accessible-icon f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Waiting for Delivery'); ?></span>
                            <h2 class="text-white"><?php echo e($deliveryInQueue); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--info has-link box--shadow2">
                <a href="<?php echo e(route('admin.courier.info.index') . '?status=3'); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las  la-list-alt f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Delivered'); ?></span>
                            <h2 class="text-white"><?php echo e($delivered); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->

        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--primary has-link overflow-hidden box--shadow2">
                <a href="<?php echo e(route('admin.branch.index')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-university f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Total Branch'); ?></span>
                            <h2 class="text-white"><?php echo e($branchCount); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--cyan has-link box--shadow2">
                <a href="<?php echo e(route('admin.branch.manager.index')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-user-check f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Total manager'); ?></span>
                            <h2 class="text-white"><?php echo e($managerCount); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--orange has-link box--shadow2">
                <a href="<?php echo e(route('admin.courier.branch.income')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-money-bill-wave f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Total Income'); ?></span>
                            <h2 class="text-white"><?php echo e($general->cur_sym); ?><?php echo e(showAmount($totalIncome)); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <div class="card bg--pink has-link box--shadow2">
                <a href="<?php echo e(route('admin.courier.info.index')); ?>" class="item-link"></a>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <i class="las la-dolly-flatbed f-size--56"></i>
                        </div>
                        <div class="col-8 text-end">
                            <span class="text-white text--small"><?php echo app('translator')->get('Total Courier'); ?></span>
                            <h2 class="text-white"><?php echo e($courierInfoCount); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- dashboard-w1 end -->
    </div><!-- row end-->


    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mt-30 mb-30">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Name - Address'); ?></th>
                                    <th><?php echo app('translator')->get('Email - Phone'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold"><?php echo e(__($branch->name)); ?></span><br>
                                            <span><?php echo e(__($branch->address)); ?></span>
                                        </td>
                                        <td>
                                            <span><?php echo e($branch->email); ?></span><br>
                                            <span><?php echo e($branch->phone); ?></span>
                                        </td>
                                        <td> <?php echo $branch->statusBadge; ?> </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline--primary" id="actionButton"
                                                data-bs-toggle="dropdown"><i class="las la-ellipsis-v"></i>
                                                <?php echo app('translator')->get('Action'); ?></button>
                                            <div class="dropdown-menu p-0">
                                                <a href="<?php echo e(route('admin.branch.manager.list', $branch->id)); ?>"
                                                    class="dropdown-item"><i class="las la-user-tie"></i>
                                                    <?php echo app('translator')->get('Manager'); ?>
                                                </a>
                                                <a href="<?php echo e(route('admin.courier.info.index').'?&sender_branch_id='.$branch->id); ?>"
                                                    class=" dropdown-item"><i class="las la-dolly-flatbed"></i>
                                                    <?php echo app('translator')->get('Courier'); ?>
                                                </a>
                                                <a href="<?php echo e(route('admin.courier.info.index').'?status=3&receiver_branch_id='.$branch->id); ?>"
                                                    class="dropdown-item"><i class="las la-truck"></i>
                                                    <?php echo app('translator')->get('Delivery'); ?>
                                                </a>
                                            </div>
                                        </td>
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
            </div>
        </div>
    </div>

    <div class="row mb-none-30 mt-5">
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title"><?php echo app('translator')->get('Login By Browser'); ?> (<?php echo app('translator')->get('Last 30 days'); ?>)</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo app('translator')->get('Login By OS'); ?> (<?php echo app('translator')->get('Last 30 days'); ?>)</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6 mb-30">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo app('translator')->get('Login By Country'); ?> (<?php echo app('translator')->get('Last 30 days'); ?>)</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/viseradmin/js/vendor/chart.js.2.8.0.js')); ?>"></script>
    <script>
        "use strict";
        var ctx = document.getElementById('userBrowserChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($chart['user_browser_counter']->keys(), 15, 512) ?>,
                datasets: [{
                    data: <?php echo e($chart['user_browser_counter']->flatten()); ?>,
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                maintainAspectRatio: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });
        var ctx = document.getElementById('userOsChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($chart['user_os_counter']->keys(), 15, 512) ?>,
                datasets: [{
                    data: <?php echo e($chart['user_os_counter']->flatten()); ?>,
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(0, 0, 0, 0.05)'
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            },
        });
        // Donut chart
        var ctx = document.getElementById('userCountryChart');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($chart['user_country_counter']->keys(), 15, 512) ?>,
                datasets: [{
                    data: <?php echo e($chart['user_country_counter']->flatten()); ?>,
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>