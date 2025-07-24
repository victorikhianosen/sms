<div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
    <div class="flex justify-between items-center">
        <h3 class="font-bold text-2xl">Ledger</h3>

        <!-- Search Input Field -->
        <input type="text" wire:model.live.debounce.50ms="search" placeholder="Search by GL ID, Status, Balance"
            class="px-4 py-2 border rounded-md bg-gray-100 text-gray-600 w-64 placeholder:text-xs">

    </div>

    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead>
                        <tr class="bg-blue text-white">
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Name</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Account</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Balance</th>

                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Status</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Date</th>
                         
                        </tr>
                    </thead>


                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php if($ledgers->isEmpty()): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-600">No Payment Found</td>
                            </tr>
                        <?php else: ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $ledgers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ledger): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($ledger['name']); ?>

                                    </td>

                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($ledger['account_number']); ?>

                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($ledger['balance']); ?>

                                    </td>

                                    <td
                                        class="px-4 py-4 whitespace-normal text-sm 
                                        <?php if($ledger['status'] == 'success'): ?> text-green-600 
                                        <?php elseif($ledger['status'] == 'failed'): ?> text-red-600 
                                        <?php elseif($ledger['status'] == 'pending'): ?> text-yellow-600 
                                        <?php else: ?> text-gray-600 <?php endif; ?>">
                                        <?php echo e(ucfirst($ledger['status'])); ?>

                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($ledger['created_at']); ?>

                                    </td>
                                
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>

                </table>
            </div>
        </div>
    </div>


    <div class="py-8">
        
    </div>



    <!--[if BLOCK]><![endif]--><?php if($editModal): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
            <div
                class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-screen sm:w-[600px] lg:w-[600px] xl:w-[1000px] max-w-xl">
                <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                    <h3 class="text-2xl font-bold">Add Ledger</h3>
                    <button wire:click.prevent="closeModal" class="text-black text-2xl">
                        <i class="fas fa-times hover:text-red-600"></i>
                    </button>
                </div>

                <form class="mt-4 text-gray-700 space-y-6 pt-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="font-medium text-gray-700">Name</label>
                            <input wire:model="name" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">

                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-sm text-red-600 block text-start italic pt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">Description</label>
                            <input wire:model="description" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-sm text-red-600 block text-start italic pt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                    <div class="mt-6 flex justify-start pt-4 space-x-4">

                        <button type="submit" wire:loading.remove wire:click.prevent="AddLedgers"
                            class="px-8 py-3 bg-blue text-white rounded-lg hover:bg-opacity-90 transition text-sm">
                            Add
                        </button>

                        <button type="submit" wire:loading wire:target="AddLedgers"
                            class="px-8 py-3 bg-blue text-white rounded-lg hover:bg-opacity-90 transition text-sm">
                            <i class="fa-solid fa-spinner animate-spin "></i> Loading...

                        </button>

                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->




</div>
<?php /**PATH /home/victor/Documents/GGT/sms/resources/views/livewire/admin/ledger-list.blade.php ENDPATH**/ ?>