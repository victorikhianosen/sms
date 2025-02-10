<div>
    <div class="flex flex-col bg-white rounded-lg">
        <div class="pt-4 md:pt-8 pb-10 px-6">
            <h3 class="font-bold text-2xl">Payment History</h3>
        </div>


        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead>
                            <tr class="bg-blue text-white">
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-28">
                                    Tranx ID
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                    Reference
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                    Amount
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-36">
                                    Payment type
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                    Status
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">
                                    Date
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-24">
                                    Currency
                                </th>
                            </tr>
                        </thead>

                        
                        <!--[if BLOCK]><![endif]--><?php if(!$allPayment): ?>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fa-solid fa-spinner animate-spin text-4xl text-blue-500"></i>
                                        <p class="text-lg text-gray-600 mt-2 animate-pulse">Loading...</p>
                                    </td>
                                </tr>
                            </tbody>
                        <?php else: ?>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allPayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="odd:bg-white even:bg-gray-100">
                                        <td class="px-4 py-4 whitespace-normal text-sm font-medium text-gray">
                                            <?php echo e($payment->transaction_id); ?>

                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($payment->reference); ?>

                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($payment->amount); ?>

                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($payment->payment_type); ?>

                                        </td>
                                        <td
                                            class="px-4 py-4 whitespace-normal text-sm
                                    <?php if($payment->status == 'success'): ?> text-green-600
                                    <?php elseif($payment->status == 'failed'): ?> text-red-600
                                    <?php else: ?> text-gray-600 <?php endif; ?>">
                                            <?php echo e($payment->status); ?>

                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($payment->created_at); ?>

                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            (<?php echo e($payment->currency); ?>)
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </table>
                </div>
            </div>
        </div>


        <div class="mt-4 py-4 px-4">
            <?php echo e($allPayment->links()); ?>

        </div>


    </div>



</div>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/livewire/user/payment-history.blade.php ENDPATH**/ ?>