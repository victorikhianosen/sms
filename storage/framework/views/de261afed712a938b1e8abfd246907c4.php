<div class="px-6">
    <div class="pt-4 pb-10 flex justify-between items-center">
        <h3 class="font-bold text-2xl ">Edit Group</h3>
    </div>

    <div class="">
        <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-8 relative">

            <form class="space-y-4">
                <div>
                    <label class="text-gray-800 text-sm mb-2 block">Name</label>
                    <input type="text" wire:model="name"
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
                    <label class="text-textPrimary text-sm mb-2 block">Description</label>
                    <textarea wire:model="description"
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

                <div x-data="{ numbers: <?php if ((object) ('numbers') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('numbers'->value()); ?>')<?php echo e('numbers'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('numbers'); ?>')<?php endif; ?> }">
                    <label class="text-textPrimary text-sm mb-2 block">Numbers</label>
                    <textarea wire:model="numbers"
                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                        placeholder="Enter group numbers" rows="5" cols="5"
                        x-on:input="numbers = numbers.replace(/\D/g, '').replace(/(\d{11})(?=\d)/g, '$1, ').trim()"></textarea>
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
                    <a href="<?php echo e(route('groups')); ?>" wire:navigate.hover type="button"
                        class="px-6 py-3 rounded-lg text-blue text-sm border-2 border-blue outline-none tracking-wide bg-white transition-all duration-200 ease-in-out hover:bg-blue hover:text-white">Back</a>

                    <button type="button" wire:loading.remove wire:click.prevent="updateGroup"
                        class="px-6 py-3 rounded-lg text-white text-sm border-none outline-none tracking-wide bg-blue transition-all duration-200 ease-in-out hover:bg-opacity-90">
                        Update Group
                    </button>

                     <button type="submit" wire:loading wire:target="updateGroup"
                        class="px-6 py-3 rounded-lg text-white text-sm border-none outline-none tracking-wide bg-blue transition-all duration-200 ease-in-out hover:bg-opacity-90">
                                    <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/livewire/user/edit-groups.blade.php ENDPATH**/ ?>