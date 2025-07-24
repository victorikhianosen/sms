<div>

    <div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
        <div class="flex justify-between items-center">
            <h3 class="font-bold text-2xl">All Admins</h3>

            <div x-data="{ isApiKeyModalOpen: false }">
                <button @click="isApiKeyModalOpen = true"
                    class="bg-blue py-1 px-4 text-white rounded-lg cursor-pointer text-sm">Add Admin</button>

                <div x-show="isApiKeyModalOpen" x-cloak
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
                    <div @click.away="isApiKeyModalOpen = false"
                        class="bg-white p-6 sm:p-8 rounded-lg shadow-lg 
                w-full sm:w-[600px] lg:w-[600px] xl:w-[800px] max-w-4xl">
                        <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                            <h3 class="text-2xl font-bold">Add Admin</h3>
                            <button @click="isApiKeyModalOpen = false" class="text-black text-2xl">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <form class="mt-4 text-gray-700 space-y-6 pt-6" wire:submit.prevent="AddNewAdmin">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="font-medium text-gray-700">First Name</label>
                                    <input type="text" id="messageId" wire:model="first_name"
                                        class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['first_name'];
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
                                    <label class="font-medium text-gray-700">Last Name</label>
                                    <input type="text" id="messageSender" wire:model="last_name"
                                        class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['last_name'];
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
                                    <label class="font-medium text-gray-700">Email Address</label>
                                    <input type="text" id="messageId" wire:model="email"
                                        class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
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
                                <div x-data="{ phone: '' }">
                                    <label class="font-medium text-gray-700">Phone Number</label>
                                    <input type="number" id="messageSender" wire:model="phone_number" x-model="phone"
                                        @input="phone = phone.slice(0, 11)"
                                        class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['phone_number'];
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
                                    <label class="font-medium text-gray-700">Password</label>
                                    <input type="text" id="messageId" wire:model="password"
                                        class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
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
                                    <label class="font-medium text-gray-700">Role</label>
                                    <select wire:model="role"
                                        class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                        <option selected>Select a role</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allRoles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['role'];
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

                                <button type="submit" wire:loading wire:target="AddNewAdmin"
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
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">First Name</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Last Nme</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-70">Email</th>
                                
                                
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-30">Status</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Role
                                </th>
                                 <th class="px-4 py-3 text-start text-xs font-semibold uppercase">Balance
                                </th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Date
                                </th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase 40">Action</th>
                            </tr>
                        </thead>
                        <!--[if BLOCK]><![endif]--><?php if(!$allAdmins): ?>


                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fa-solid fa-spinner animate-spin text-4xl text-blue-500"></i>
                                        <p class="text-lg text-gray-600 mt-2 animate-pulse">Loading...</p>
                                    </td>
                                </tr>
                            </tbody>
                        <?php else: ?>
                            <tbody>

                                <!--[if BLOCK]><![endif]--><?php if(!empty($allAdmins)): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allAdmins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="odd:bg-white even:bg-gray-100">
                                            <td class="px-4 py-4 whitespace-normal text-sm font-medium text-gray">
                                                <?php echo e($item->first_name); ?></td>
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                                <?php echo e($item->last_name); ?>

                                            </td>
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                                <?php echo e($item->email); ?>

                                            </td>
                                            
                                            
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                                <?php
                                                    $statusColors = [
                                                        'active' => 'text-green-600',
                                                        'inactive' => 'text-red-600',
                                                        'pending' => 'text-yellow-600',
                                                    ];
                                                    $colorClass = $statusColors[$item->status] ?? 'text-black'; // Default to black for other statuses
                                                ?>
                                                <span class="<?php echo e($colorClass); ?>"><?php echo e(ucfirst($item->status)); ?></span>
                                            </td>

                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                                <?php
                                                    $roles = [
                                                        'admin' => 'Admin',
                                                        'super_admin' => 'Super Admin',
                                                        'supervisor' => 'Supervisor',
                                                    ];
                                                ?>
                                                <?php echo e($roles[$item->role] ?? ucfirst($item->role)); ?>

                                            </td>

                                              <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                                <?php echo e($item->balance); ?>

                                            </td>
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                                <?php echo e($item->created_at); ?>

                                            </td>

                                            <td class="px-4 py-4 whitespace-normal flex items-center gap-2">

                                                <a href="<?php echo e(route('admin.details', $item->id)); ?>" wire:navigate.hover
                                                    type="button"
                                                    class="bg-blue py-2 px-2 text-sm text-white rounded-lg cursor-pointer">
                                                    View
                                                </a>

                                                <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                                    <button wire:click.prevent="showAddFunds(<?php echo e($item->id); ?>)"
                                                        class="bg-green-600 text-sm py-2 px-2 text-white rounded-lg cursor-pointer">
                                                        Funds
                                                    </button>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No users found</td>
                                    </tr>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                            </tbody>

                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </table>
                </div>
            </div>
        </div>

        <div class="py-8">
            <?php echo e($allAdmins->links()); ?>

        </div>

    </div>




        <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
        <!--[if BLOCK]><![endif]--><?php if($editFundModel): ?>
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
                <div
                    class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-screen sm:w-[600px] lg:w-[600px] xl:w-[1000px] max-w-3xl">
                    <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                        <h3 class="text-2xl font-bold">Add Fund</h3>
                        <button class="text-black text-2xl" wire:click="closeModal">
                            <i class="fas fa-times hover:text-red-600"></i>
                        </button>
                    </div>

                    <form class="mt-4 text-gray-700 space-y-6 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="font-medium text-gray-700">Email</label>
                                <input type="text" wire:model="admin_email"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                              

                            </div>
                            <div>
                                <label class="font-medium text-gray-700">Phone Number</label>
                                <input type="text" wire:model="admin_phone"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                               

                            </div>
                            <div>
                                <label class="font-medium text-gray-700">Available Balance</label>
                                <input type="text" wire:model="admin_available_balance"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            
                            </div>


                            <div>
                                <label class="font-medium text-gray-700">Amount to Deposit</label>
                                <input type="text" wire:model="amount" maxlength="11"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['amount'];
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
                     


                            <button type="submit" wire:loading.remove wire:click.prevent="addAdminFunds"
                                class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                Fund Account
                            </button>

                            <button type="submit" wire:loading wire:target="addAdminFunds"
                                class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->





    
    




</div>
<?php /**PATH /home/victor/Documents/GGT/sms/resources/views/livewire/admin/admin-list.blade.php ENDPATH**/ ?>