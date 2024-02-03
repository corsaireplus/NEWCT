<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="checkAll"> <?php echo app('translator')->get('Select All'); ?>
                                    </th>
                                    <th><?php echo app('translator')->get('Sender Branch - Staff'); ?></th>
                                    <th><?php echo app('translator')->get('Receiver Branch - Staff'); ?></th>
                                    <th><?php echo app('translator')->get('Amount - Order Number'); ?></th>
                                    <th><?php echo app('translator')->get('Creations Date'); ?></th>
                                    <th><?php echo app('translator')->get('Estimate Delivery Date'); ?></th>
                                    <th><?php echo app('translator')->get('Payment Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $courierLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courierInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="childCheckBox" data-id="<?php echo e($courierInfo->id); ?>">
                                        </td>
                                        <td>
                                            <span class="fw-bold"><?php echo e(__($courierInfo->senderBranch->name)); ?></span><br>

                                            <small class="text-mute"><i>
                                                    <?php echo e(__($courierInfo->senderStaff->fullname)); ?></i></small>
                                        </td>

                                        <td>
                                            <span>
                                                <?php if($courierInfo->receiver_branch_id): ?>
                                                    <?php echo e(__($courierInfo->receiverBranch->name)); ?>

                                                <?php else: ?>
                                                    <?php echo app('translator')->get('N/A'); ?>
                                                <?php endif; ?>
                                            </span>
                                            <br>
                                            <?php if($courierInfo->receiver_staff_id): ?>
                                                <?php echo e(__($courierInfo->receiverStaff->fullname)); ?>

                                            <?php else: ?>
                                                <span><?php echo app('translator')->get('N/A'); ?></span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <span class="fw-bold"><?php echo e(showAmount(@$courierInfo->paymentInfo->final_amount)); ?>

                                                <?php echo e(__($general->cur_text)); ?></span><br>
                                            <span><?php echo e($courierInfo->code); ?></span>
                                        </td>

                                        <td>
                                            <?php echo e(showDateTime($courierInfo->created_at, 'd M Y')); ?>

                                        </td>
                                        <td>
                                            <?php echo e(showDateTime($courierInfo->estimate_date, 'd M Y')); ?>

                                        </td>

                                        <td>
                                            <?php if(@$courierInfo->paymentInfo->status == Status::PAID): ?>
                                                <span class="badge badge--success"><?php echo app('translator')->get('Paid'); ?></span>
                                            <?php elseif(@$courierInfo->paymentInfo->status == Status::UNPAID): ?>
                                                <span class="badge badge--danger"><?php echo app('translator')->get('Unpaid'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('staff.courier.invoice', encrypt($courierInfo->id))); ?>"
                                                title="" class="btn btn-sm btn-outline--info"><i
                                                    class="las la-file-invoice"></i><?php echo app('translator')->get('Invoice'); ?></a>
                                            <a href="<?php echo e(route('staff.courier.details', encrypt($courierInfo->id))); ?>"
                                                title="" class="btn btn-sm btn-outline--primary"><i
                                                    class="las la-info-circle"></i><?php echo app('translator')->get('Details'); ?></a>
                                            <button type="button" class="btn btn-sm btn-outline--success confirmationBtn"
                                                data-action="<?php echo e(route('staff.courier.dispatched', $courierInfo->id)); ?>"
                                                data-question="<?php echo app('translator')->get('Are you sure to dispatch this courier?'); ?>">
                                                <i class="las la-arrow-circle-right"></i><?php echo app('translator')->get('Dispatch'); ?>
                                            </button>
                                            <a href="<?php echo e(route('staff.courier.edit', encrypt($courierInfo->id))); ?>"
                                                class="btn btn-sm btn-outline--primary">
                                                <i class="las la-pen"></i><?php echo app('translator')->get('Edit'); ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr class="d-none dispatch">
                                    <td colspan="8">
                                        <button class="btn btn-sm btn--primary h-45 w-100 " id="dispatch_all"> <i
                                                class="las la-arrow-circle-right "></i> <?php echo app('translator')->get('Dispatch'); ?></button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if($courierLists->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($courierLists)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b = $component; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ConfirmationModal::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b)): ?>
<?php $component = $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b; ?>
<?php unset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['placeholder' => 'Search here...']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Search here...']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.date-filter','data' => ['placeholder' => 'Start date - End date']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('date-filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Start date - End date']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $(".childCheckBox").on('change', function(e) {
                let totalLength = $(".childCheckBox").length;
                let checkedLength = $(".childCheckBox:checked").length;
                if (totalLength == checkedLength) {
                    $('.checkAll').prop('checked', true);
                } else {
                    $('.checkAll').prop('checked', false);
                }
                if (checkedLength) {
                    $('.dispatch').removeClass('d-none')
                } else {
                    $('.dispatch').addClass('d-none')
                }
            });

            $('.checkAll').on('change', function() {
                if ($('.checkAll:checked').length) {
                    $('.childCheckBox').prop('checked', true);
                } else {
                    $('.childCheckBox').prop('checked', false);
                }
                $(".childCheckBox").change();
            });
            $('#dispatch_all').on('click', function() {
                let ids = [];
                $('.childCheckBox:checked').each(function() {
                    ids.push($(this).attr('data-id'))
                })
                let id = ids.join(',')
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "<?php echo e(route('staff.courier.dispatch.all')); ?>",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        notify('success', 'Courier dispatched successfully')
                        location.reload();
                    }
                })
            });

        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('staff.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/MAMP/htdocs/NEWCT/core/resources/views/staff/courier/sentQueue.blade.php ENDPATH**/ ?>