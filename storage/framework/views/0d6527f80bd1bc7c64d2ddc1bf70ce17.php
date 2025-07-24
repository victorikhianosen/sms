<div>

    <div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
        <div class="flex justify-between items-center">
            <h3 class="font-bold text-2xl">All Sender</h3>

            <div x-data="{ isApiKeyModalOpen: false }">
                <button @click="isApiKeyModalOpen = true"
                    class="bg-blue py-2 px-4 text-white rounded-lg cursor-pointer text-sm">Add Sender</button>

                <div x-show="isApiKeyModalOpen" x-cloak
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
                    <div @click.away="isApiKeyModalOpen = false"
                        class="bg-white p-6 sm:p-8 rounded-lg shadow-lg 
                w-full sm:w-[600px] lg:w-[600px] xl:w-[800px] max-w-4xl">
                        <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                            <h3 class="text-2xl font-bold">Add Sender</h3>
                            <button @click="isApiKeyModalOpen = false" class="text-black text-2xl">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <form class="mt-4 text-gray-700 space-y-6 pt-6" wire:submit.prevent="addNewsender">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                                <div>
                                    <label class="font-medium text-gray-700">Name</label>
                                    <input type="text" id="messageId" wire:model="name"
                                        class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span
                                            class="text-sm text-red-600 block text-start italic pt-1"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>


                                <div>
                                    <label class="font-medium text-gray-700">User</label>
                                    <select id="messageId" wire:model="user"
                                        class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                        <option value="">Select User</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->id); ?>"><?php echo e($user->email); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span
                                            class="text-sm text-red-600 block text-start italic pt-1"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>




                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div>
                                    <label class="font-medium text-gray-700">Route</label>
                                    <select id="messageSender" wire:model="route"
                                        class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                        <option value="">Select Route</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($route->id); ?>"><?php echo e($route->description); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['route'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span
                                            class="text-sm text-red-600 block text-start italic pt-1"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div>
                                    <label class="font-medium text-gray-700">Description</label>
                                    <input type="text" id="messageId" wire:model="description"
                                        class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span
                                            class="text-sm text-red-600 block text-start italic pt-1"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                            </div>



                            <div class="mt-6 flex justify-start pt-4 space-x-4">
                                <button wire:loading.remove
                                    class="px-8 py-3 bg-blue text-white rounded-lg hover:bg-opacity-90 transition text-sm">
                                    Add
                                </button>

                                <button type="submit" wire:loading wire:target="addNewsender"
                                    class="px-8 py-3 bg-blue text-white rounded-lg hover:bg-opacity-90 transition text-sm">
                                    <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>






        </div>
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead>
                            <tr class="bg-blue text-white">
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Name</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">User</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Route</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-30">Description</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Date</th>

                                <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                    <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Action</th>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php if($senders->isEmpty()): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-600">No Sender Found</td>
                                </tr>
                            <?php else: ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $senders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sender): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray"><?php echo e($sender->name); ?>

                                        </td>

                                        
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($sender->user ? $sender->user->email : 'Unknown User'); ?>

                                        </td>

                                        
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($sender->smsRoute ? $sender->smsRoute->description : 'Unknown '); ?>

                                        </td>

                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($sender->description); ?>

                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($sender->created_at); ?>

                                        </td>
                                        <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                            <td class="px-4 py-4 whitespace-normal flex items-center gap-2">
                                                <button type="button" wire:click.prevent="editSender(<?php echo e($sender->id); ?>)"
                                                    class="bg-blue py-2 px-2 text-sm text-white rounded-lg cursor-pointer">
                                                    Edit
                                                </button>
                                                <button type="button"
                                                    wire:click.prevent="deleteSender(<?php echo e($sender->id); ?>)"
                                                    class="bg-red-600 text-sm py-2 px-2 text-white rounded-lg cursor-pointer">
                                                    Delete
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
            <?php echo e($senders->links()); ?>

        </div>

    </div>




    <!--[if BLOCK]><![endif]--><?php if($editModel): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
            <div
                class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-full sm:w-[600px] lg:w-[600px] xl:w-[800px] max-w-lg">
                <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                    <h3 class="text-2xl font-bold">Add Sender</h3>
                    <button class="text-black text-2xl" wire:click="closeModal">
                        <i class="fas fa-times hover:text-red-600"></i>
                    </button>
                </div>

                <form class="mt-4 text-gray-700 space-y-6 pt-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="font-medium text-gray-700">Name</label>
                            <input type="text" wire:model="name"
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
                            <label class="font-medium text-gray-700">Route</label>
                            <select wire:click="route"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($route->id); ?>"><?php echo e($route->description); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['route'];
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
                            <input type="text" wire:model="description"
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
                        <button type="button" wire:loading.remove wire:click.prevent="updateSender"
                            class="px-8 py-3 bg-blue text-white rounded-lg hover:bg-opacity-90 transition text-sm">
                            Update
                        </button>
                        <button type="submit" wire:loading wire:target="updateSender"
                            class="px-8 py-3 bg-blue text-white rounded-lg hover:bg-opacity-90 transition text-sm">
                            <i class="fa-solid fa-spinner animate-spin"></i> Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->




</div>
<?php /**PATH /home/victor/Documents/GGT/sms/resources/views/livewire/admin/sms-sender-list.blade.php ENDPATH**/ ?>