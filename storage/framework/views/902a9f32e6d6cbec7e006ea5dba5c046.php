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