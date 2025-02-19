<div class="pt-8"> <!-- Sync Alpine with Livewire -->

    <div class="pt-4 pb-10 px-6 flex justify-between items-center">
        <h3 class="font-bold text-2xl ">All Groups</h3>
        
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!--[if BLOCK]><![endif]--><?php if(!$adminAllGroups): ?>
            <div class="p-6 text-center bg-white rounded-lg shadow-sm">
                <p class="text-textPrimary font-light text-lg leading-relaxed">
                    You have no groups. Add one, upload a CV, or an Excel file.
                </p>
            </div>
        <?php else: ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $adminAllGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="relative p-6 text-center shadow-sm bg-white space-y-3 rounded-lg">
                    <h3 class="text-lg font-medium"><?php echo e($item['name']); ?></h3>
                    <p class="text-textPrimary font-light text-sm leading-relaxed"><?php echo e($item['name']); ?></p>
                    <div class="pt-3 flex justify-center items-center gap-2">
                        <button wire:click.prevent="viewGroup(<?php echo e($item['id']); ?>)" type="button"
                            class="mt-6 px-5 py-2 block w-full rounded-lg text-white text-xs tracking-wider font-light border-none outline-none bg-blue hover:opacity-90">View</button>

                        <button type="button" wire:click.prevent="deleteGroup(<?php echo e($item['id']); ?>)"
                            class="mt-6 px-5 py-2 w-full rounded-lg text-white text-xs tracking-wider font-light border-none outline-none bg-red-600 hover:opacity-90">Delete
                        </button>
                    </div>

                    <span class="block absolute top-0 right-4 bg-blue text-white py-1 px-2 rounded-lg text-[12px]">
                        <?php echo e(count(json_decode($item['numbers'], true))); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <div class="mt-12">
        <?php echo e($adminAllGroups->links()); ?>

    </div>




    <!--[if BLOCK]><![endif]--><?php if($editModel): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
            <div
                class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-screen sm:w-[600px] lg:w-[600px] xl:w-[1000px] max-w-lg">
                <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                    <h3 class="text-2xl font-bold">View Group</h3>
                    <button class="text-black text-2xl" wire:click="closeModal">
                        <i class="fas fa-times hover:text-red-600"></i>
                    </button>
                </div>

                <form class="mt-4 text-gray-700 space-y-6 pt-6">
                    <div class="grid grid-cols-1 gap-6">

                        <div>
                            <label class="font-medium text-gray-700">Title</label>
                            <input type="text" wire:model="name"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Email</label>
                            <input type="text" wire:model="email"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>


                        <div>
                            <label class="font-medium text-gray-700">Description</label>
                            <input type="text" wire:model="description"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>


                        <div>
                            <label class="font-medium text-gray-700">Phone</label>
                            <textarea wire:model="numbers" class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600"
                                rows="3" readonly></textarea>
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
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/livewire/admin/group-list.blade.php ENDPATH**/ ?>