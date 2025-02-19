<div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
    <div class="flex justify-between items-center">
        <h3 class="font-bold text-2xl">All Payment</h3>

        <!-- Search Input Field -->
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search by Amount, Tranx ID, Email"
            class="px-4 py-2 border rounded-md bg-gray-100 text-gray-600 w-64 placeholder:text-xs">
    </div>

    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead>
                        <tr class="bg-blue text-white">
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Tranx ID</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">User</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Payment Type</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Amount</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Status</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Date</th>
                            <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Action</th>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php if($payments->isEmpty()): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-600">No Payment Found</td>
                            </tr>
                        <?php else: ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($payment['transaction_id']); ?>

                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($payment['user']['email']); ?>

                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($payment['payment_type']); ?>

                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($payment['amount']); ?>

                                    </td>
                                    <td
                                        class="px-4 py-4 whitespace-normal text-sm 
                                        <?php if($payment['status'] == 'success'): ?> text-green-600 
                                        <?php elseif($payment['status'] == 'failed'): ?> text-red-600 
                                        <?php elseif($payment['status'] == 'pending'): ?> text-yellow-600 
                                        <?php else: ?> text-gray-600 <?php endif; ?>">
                                        <?php echo e(ucfirst($payment['status'])); ?>

                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($payment['created_at']); ?>

                                    </td>
                                    <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                        <td class="px-4 py-4 whitespace-normal flex items-center gap-2">
                                            <button type="button" wire:click.prevent="viewPayment(<?php echo e($payment['id']); ?>)"
                                                class="bg-blue py-2 px-2 text-sm text-white rounded-lg cursor-pointer">
                                                View
                                            </button>
                                        </td>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="py-8">
        <?php echo e($payments->links()); ?>

    </div>

    <!--[if BLOCK]><![endif]--><?php if($editModel): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
            <div
                class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-screen sm:w-[600px] lg:w-[600px] xl:w-[1000px] max-w-6xl">
                <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                    <h3 class="text-2xl font-bold">Payment Details</h3>
                    <button class="text-black text-2xl" wire:click="closeModal">
                        <i class="fas fa-times hover:text-red-600"></i>
                    </button>
                </div>

                <form class="mt-4 text-gray-700 space-y-6 pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="font-medium text-gray-700">Email</label>
                            <input type="text" wire:model="email"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Amount</label>
                            <input type="text" wire:model="amount"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>

                        <div>
                            <label class="font-medium text-gray-700">Status</label>
                            <input type="text" wire:model="status"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">Transaction iD</label>
                            <input type="text" wire:model="transaction_id"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Reference</label>
                            <input type="text" wire:model="reference"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>

                        <div>
                            <label class="font-medium text-gray-700">Bank Name</label>
                            <input type="text" wire:model="bank_name"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>

                        <!--[if BLOCK]><![endif]--><?php if(isset($account_number)): ?>
                            <div>
                                <label class="font-medium text-gray-700">Account Number</label>
                                <input type="text" wire:model="account_number"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                        

                        <div>
                            <label class="font-medium text-gray-700">Card Last Four</label>
                            <input type="text" wire:model="card_last_four"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>

                        <div>
                            <label class="font-medium text-gray-700">Card Brand</label>
                            <input type="text" wire:model="card_brand"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>

                        <div>
                            <label class="font-medium text-gray-700">Description</label>
                            <input type="text" wire:model="description"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>


                        <div>
                            <label class="font-medium text-gray-700">Payment Type</label>
                            <input type="text" wire:model="payment_type"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>


                        <div>
                            <label class="font-medium text-gray-700">Date</label>
                            <input type="text" wire:model="created_at"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>



                    </div>

                    <div class="mt-6 flex justify-start pt-4 space-x-4">
                        <button type="button" wire:click="closeModal"
                            class="px-8 py-3 bg-red-600 text-white rounded-lg hover:bg-opacity-90 transition text-sm">
                            Close
                        </button>

                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

</div>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/livewire/admin/payment-list.blade.php ENDPATH**/ ?>