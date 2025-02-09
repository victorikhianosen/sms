<div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
    <h3 class="font-bold text-2xl">Messages</h3>
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead>
                        <tr class="bg-blue text-white">
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-28">
                                Message ID</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                Title</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                Destination</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">
                                Message</th>

                            
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-12">
                                Amount</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-24">
                                Status</th>
                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">
                                Date</th>

                            <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $allMessage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="odd:bg-white even:bg-gray-100">
                                <td class="px-4 py-4 whitespace-normal text-sm font-medium text-gray">
                                    <?php echo e(substr($item->message_id, 0, 8)); ?>

                                </td>
                                <td class="px-4 py-4 whitespace-normal text-sm text-gray"><?php echo e($item->sender); ?></td>
                                <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                    <?php echo e($item->destination); ?>

                                </td>
                                <td class="px-4 py-4 whitespace-normal text-sm text-gray break-words">
                                    
                                    <?php echo e(substr($item->message, 0, 20)); ?>


                                </td>

                                
                                <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                    <?php echo e($item->amount); ?>

                                </td>
                                <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                    <?php echo e($item->status); ?>

                                </td>
                                <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                    <?php echo e($item->created_at); ?>

                                </td>
                                <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                    <span class="bg-blue py-2 px-2 text-white rounded-lg cursor-pointer"
                                        wire:click="showMessage(<?php echo e($item->id); ?>)">
                                        View
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="px-4 py-4 text-center text-sm text-gray">
                                    No recent Messages
                                </td>
                            </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>

                <!-- Pagination Controls -->
                <div class="mt-4 py-4">
                    <?php echo e($allMessage->links()); ?>

                </div>

            </div>
        </div>
    </div>


    <!--[if BLOCK]><![endif]--><?php if($selectedMessage): ?>
        <div x-data="{ open: false }" x-show="open" x-init="$wire.on('openModal', () => open = true)"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">

            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl p-6 relative">
                <!-- Close Button (Top Right) -->
                <button class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 transition"
                    @click="open = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Modal Header -->
                <h3 class="text-2xl font-semibold text-gray-900 border-b pb-3">Message Details</h3>

                <!-- Modal Body -->
                <div class="mt-4 grid grid-cols-2 gap-4 text-gray-700">
                    <div>
                        <label class="font-medium text-gray-700">Message ID</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            value="<?php echo e($selectedMessage->message_id); ?>" readonly>
                    </div>

                    <div>
                        <label class="font-medium text-gray-700">Sender</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            value="<?php echo e($selectedMessage->sender); ?>" readonly>
                    </div>

                    <div>
                        <label class="font-medium text-gray-700">Destination</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            value="<?php echo e($selectedMessage->destination); ?>" readonly>
                    </div>

                    <div>
                        <label class="font-medium text-gray-700">Status</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            value="<?php echo e($selectedMessage->status); ?>" readonly>
                    </div>

                    <div>
                        <label class="font-medium text-gray-700">Amount</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            value="<?php echo e($selectedMessage->amount); ?>" readonly>
                    </div>

                    <div>
                        <label class="font-medium text-gray-700">Date</label>
                        <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            value="<?php echo e($selectedMessage->created_at); ?>" readonly>
                    </div>
                </div>

                <!-- Full Width Message Textarea -->
                <div class="mt-4">
                    <label class="font-medium text-gray-700">Message</label>
                    <textarea class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600 h-32 resize-none" readonly><?php echo e($selectedMessage->message); ?></textarea>
                </div>

                <!-- Modal Footer with Close Button -->
                <div class="mt-6 flex justify-end">
                    <button class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                        @click="open = false">
                        Close
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


</div>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/livewire/user/messages.blade.php ENDPATH**/ ?>