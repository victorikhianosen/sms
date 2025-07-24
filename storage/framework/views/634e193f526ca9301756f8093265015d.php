<div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2 h-screen">
    <div class="flex justify-between items-center">
        <h3 class="font-bold text-2xl">SMS Provider</h3>
    </div>

    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-x-auto pb-24">
                <table class="min-w-full divide-y divide-[#c2c3c5]">
                    <thead>
                        <tr class="bg-blue-600 text-black">
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase">S/N</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Date</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#c2c3c5] ">
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="px-4 py-4 text-sm text-gray-700">
                                    <?php echo e($item->id); ?>

                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">
                                    <?php echo e($item->name); ?>

                                </td>
                                <td class="px-4 py-4 text-sm relative">
                                    <div x-data="{ open: false }" class="relative inline-block text-left">
                                        <button @click="open = !open"
                                            class="px-3 py-1 rounded cursor-pointer
                                            <?php echo e($item->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>

                                            hover:bg-opacity-80 transition">
                                            <?php echo e($item->is_active ? 'Active' : 'Inactive'); ?>

                                        </button>

                                        <div x-show="open"
                                            @click.away="open = false"
                                            x-transition
                                            class="absolute right-0 mt-1 bg-white border border-gray-200 rounded shadow-lg z-50 w-32">
                                            <button
                                                wire:click="updateStatus(<?php echo e($item->id); ?>, 'active')"
                                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 text-green-700">
                                                Set Active
                                            </button>
                                            <button
                                                wire:click="updateStatus(<?php echo e($item->id); ?>, 'inactive')"
                                                class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 text-red-700">
                                                Set Inactive
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">
                                    <?php echo e($item->created_at); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-gray-500">
                                    No providers found.
                                </td>
                            </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <?php echo e($providers->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/victor/Documents/GGT/sms/resources/views/livewire/admin/settings/sms-provider-list.blade.php ENDPATH**/ ?>