<div> <!-- Sync Alpine with Livewire -->

    <div class="pt-4 pb-10 px-6 flex justify-between items-center">
        <h3 class="font-bold text-2xl ">All Groups</h3>
        <button type="button" wire:click.prevent="addModal"
            class="mt-6 px-5 py-2.5 rounded-lg text-white text-xs tracking-wider font-medium border-none outline-none bg-blue hover:opacity-90">
            Add Group
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!--[if BLOCK]><![endif]--><?php if($allGroups->isEmpty()): ?>
            <div class="p-6 text-center bg-white rounded-lg shadow-sm">
                <p class="text-textPrimary font-light text-lg leading-relaxed">
                    You have no groups. Add one, upload a CV, or an Excel file.
                </p>
            </div>
        <?php else: ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="relative p-6 text-center shadow-sm bg-white space-y-3 rounded-lg">
                    <h3 class="text-lg font-medium"><?php echo e($item['name']); ?></h3>
                    <p class="text-textPrimary font-light text-sm leading-relaxed"><?php echo e($item['name']); ?></p>
                    <div class="pt-3 flex justify-center items-center gap-2">
                        <a href="<?php echo e(route('editgroups', $item['id'])); ?>" wire:navigate.hover type="button"
                            @click.prevent.stop
                            class="mt-6 px-5 py-2 block w-full rounded-lg text-white text-xs tracking-wider font-light border-none outline-none bg-blue hover:opacity-90">View</a>

                        <button type="button" wire:click.prevent="deletGroup(<?php echo e($item['id']); ?>)"
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

    <div class="mt-6">
        <?php echo e($allGroups->links()); ?>

    </div>




    
    <!--[if BLOCK]><![endif]--><?php if($showModal): ?>
        <div
            class="fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif]">
            <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-8 relative">
                <div class="flex items-center">
                    <h3 class="text-bg-blue text-xl font-bold flex-1">Add New Group</h3>

                   <button type="button" wire:click.prevent="closeModal" class="hover:text-red-600">
                    <i class="fa-solid fa-xmark text-lg font-semibold"></i>
                   </button>
                </div>
                <form class="space-y-4 mt-8" x-data="{ files: [] }">
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Name</label>
                        <input type="text" autocomplete="off" wire:model="name"
                            class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                            placeholder="Enter group name">
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
                        <label class="text-textPrimary text-sm mb-2 block">Descriptions</label>
                        <textarea wire:model="description" autocomplete="off"
                            class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                            placeholder="Enter group description"></textarea>
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

                    <div x-show="files.length > 0" class="space-y-2">
                        <h3 class="text-sm font-medium">Preview:</h3>
                        <div class="flex space-x-2">
                            <template x-for="(file, index) in files" :key="index">
                                <div class="flex items-center space-x-2">
                                    <template x-if="file.name.endsWith('.csv')">
                                        <i class="fas fa-file-csv text-yellow-600"></i> <!-- CSV Icon -->
                                    </template>
                                    <template x-if="file.name.endsWith('.xls')">
                                        <i class="fas fa-file-excel text-green-600"></i> <!-- XLS Icon -->
                                    </template>
                                    <template x-if="file.name.endsWith('.xlsx')">
                                        <i class="fas fa-file-excel text-green-600"></i> <!-- XLSX Icon -->
                                    </template>
                                    <span x-text="file.name" class="text-gray-700 text-sm"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="relative">
                        <label class="text-textPrimary text-sm mb-2 block">Upload Phone Numbers</label>
                        <input type="file" wire:model="numbers"
                            class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue opacity-0 absolute inset-0 z-10 cursor-pointer"
                            accept=".csv, .xls, .xlsx" x-on:change="files = Array.from($event.target.files)" />
                        <div
                            class="w-full px-3 py-2 border-2 border-softGray rounded-md text-gray-500 bg-white cursor-pointer">
                            <span>Select a file (CSV, .xls, or .xlsx format)</span>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['numbers'];
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

                    <div class="flex justify-end gap-4 !mt-8">
                        <button type="button" wire:click.prevent="addGroup" wire:loading.attr="disabled"
                            wire:target="numbers"
                            class="px-16 py-3 rounded-lg text-white text-sm border-none outline-none tracking-wide bg-blue transition-all duration-200 ease-in-out hover:bg-opacity-90">
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/livewire/user/groups.blade.php ENDPATH**/ ?>