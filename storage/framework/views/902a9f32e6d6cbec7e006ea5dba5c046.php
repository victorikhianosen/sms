<div>

    <div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-10 pb-24 mb-10" wire:init="getAdminDetails">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="#" onclick="history.back()"
                    class="text-gray-700 transition-all hidden md:block duration-200 hover:translate-x-1 hover:text-softGray">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h3 class="font-bold text-2xl">Admin Details</h3>


            </div>


            <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                <div x-data="{ isApiKeyModalOpen: false }">
                    <button @click="isApiKeyModalOpen = true"
                        class="bg-blue px-4 py-2 text-sm transition-all text-white rounded-lg duration-200 hover:opacity-90">
                        Add found
                    </button>

                    <!-- API Key Modal -->
                    <div x-show="isApiKeyModalOpen" x-cloak
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div @click.away="isApiKeyModalOpen = false"
                            class="bg-white p-8 rounded-lg shadow-lg w-[600px] max-w-lg">
                            <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                                <h3 class="text-2xl font-bold">Add Fund</h3>

                                <button @click="isApiKeyModalOpen = false" class="text-black text-2xl">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <form wire:submit.prevent="addAdminFund" class="mt-4 text-gray-700 space-y-4 pt-6">
                                <div>
                                    <label class="font-medium text-gray-700">Amount</label>
                                    <input type="number" id="messageId" wire:model="amount" maxlength="4"
                                        class="w-full px-4 py-3 border rounded-md bg-gray-100 text-gray-600">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['amount'];
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


                                <div class="mt-6 flex justify-start pt-4 space-x-4">
                                    <button wire:loading.remove
                                        class="px-6 py-3 bg-blue text-white rounded-lg hover:bg-opacity-90 transition text-sm">
                                        Add
                                    </button>

                                    <button type="submit" wire:loading wire:target="addAdminFund"
                                        class="px-6 py-3 bg-blue text-white rounded-lg hover:opacity-90 transition text-sm">
                                        <i class="fa-solid fa-spinner animate-spin mr-1"></i> Loading...
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        </div>
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto">


                    <!--[if BLOCK]><![endif]--><?php if(!$admin): ?>
                        <div class="text-center">
                            <i class="fa-solid fa-spinner animate-spin text-4xl text-blue"></i>
                            <p class="text-lg text-gray-600 mt-2 animate-pulse">Loading...</p>
                        </div>
                    <?php else: ?>
                        


                        <form class="">
                            <div class="pt-6 grid grid-cols-1 lg:grid-cols-2 gap-8 text-gray-700">
                                <div>
                                    <label class="font-medium text-gray-700">First Name</label>
                                    <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                        <input type="text" wire:model="first_name"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600">
                                    <?php else: ?>
                                        <input type="text" wire:model="first_name"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-500" disabled>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div>
                                    <label class="font-medium text-gray-700">Last Name</label>
                                    <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                        <input type="text" wire:model="last_name"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600">
                                    <?php else: ?>
                                        <input type="text" wire:model="last_name"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-500" disabled>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div>
                                    <label class="font-medium text-gray-700">Email</label>
                                    <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                        <input type="text" wire:model="email"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600">
                                    <?php else: ?>
                                        <input type="text" wire:model="email"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-500" disabled>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div>
                                    <label class="font-medium text-gray-700">Phone</label>
                                    <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                        <input type="number" wire:model="phone_number"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600">
                                    <?php else: ?>
                                        <input type="number" wire:model="phone_number"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-500" disabled>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div>
                                    <label class="font-medium text-gray-700">Status</label>
                                    <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                        <select wire:model="status"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600">
                                            <option value="">Select Status</option>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($statusOption); ?>"><?php echo e($statusOption); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    <?php else: ?>
                                        <select class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-500"
                                            disabled>
                                            <option value=""><?php echo e($status); ?></option>
                                        </select>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div>
                                    <label class="font-medium text-gray-700">Role</label>
                                    <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                        <select wire:model="role"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600">
                                            <option value="">Select Role</option>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $roleOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roleOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($roleOption); ?>"><?php echo e($roleOption); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    <?php else: ?>
                                        <select class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-500"
                                            disabled>
                                            <option value=""><?php echo e($role); ?></option>
                                        </select>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div>
                                    <label class="font-medium text-gray-700">Balance</label>

                                    <input type="text" wire:model="balance"
                                        class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-500" readonly>

                                </div>
                            </div>

                            <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                <div class="flex justify-start items-center pt-6">
                                    <button wire:click.prevent="updateAdminAccount"
                                        class="px-5 py-2 bg-blue text-white rounded-lg hover:bg-opacity-90 transition">
                                        Update Profile
                                    </button>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </form>

                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                </div>
            </div>
        </div>

    </div>
</div>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/livewire/admin/admin-details.blade.php ENDPATH**/ ?>