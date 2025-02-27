<div>
    <div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
        <div class="flex justify-between items-center">
            <h3 class="font-bold text-2xl">All Users</h3>
            <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search by Email, Phone & Status"
                class="px-4 py-2 border rounded-md bg-gray-100 text-gray-600 w-64 placeholder:text-xs">

            <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                <button wire:click="AddUser" class="bg-blue py-1 px-4 text-white rounded-lg cursor-pointer text-sm">

                    Add User
                </button>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead>
                            <tr class="bg-blue text-white">
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">First Name</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Last Nme</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Email</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">phone Number</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-12">Balance</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-24">Status</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Account Number
                                </th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php if($users->isEmpty()): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-lg text-gray-600">No users found
                                    </td>
                                </tr>
                            <?php else: ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="odd:bg-white even:bg-gray-100">
                                        <td class="px-4 py-4 whitespace-normal text-sm font-medium text-gray">
                                            <?php echo e($item->first_name); ?></td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($item->last_name); ?>

                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($item->email); ?>

                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray break-words">
                                            <?php echo e($item['phone']); ?></td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($item->balance); ?>

                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($item->status); ?>

                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            <?php echo e($item->account_number?: 'Unavailable'); ?>

                                        </td>
                                        <td class="px-4 py-4 whitespace-normal flex items-center gap-2">

                                            <a href="<?php echo e(route('admin.userdetails', $item->id)); ?>" wire:navigate.hover
                                                type="button"
                                                class="bg-blue py-2 px-2 text-white rounded-lg cursor-pointer text-xs">
                                                View
                                            </a>


                                            <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                                <button wire:click.prevent="AddFunds(<?php echo e($item->id); ?>)"
                                                    class="bg-green-600 py-2 px-2 text-white rounded-lg cursor-pointer text-xs">
                                                    Funds
                                                </button>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                            

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
            <?php echo e($users->links()); ?>

        </div>
    </div>



    

    <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
        <!--[if BLOCK]><![endif]--><?php if($editModel): ?>
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
                <div
                    class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-screen sm:w-[600px] lg:w-[600px] xl:w-[1000px] max-w-3xl">
                    <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                        <h3 class="text-2xl font-bold">Add User</h3>
                        <button class="text-black text-2xl" wire:click="closeModal">
                            <i class="fas fa-times hover:text-red-600"></i>
                        </button>
                    </div>

                    <form class="mt-4 text-gray-700 space-y-6 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label class="font-medium text-gray-700">First Name</label>
                                <input type="text" wire:model="first_name"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['first_name'];
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
                                <label class="font-medium text-gray-700">Last Name</label>
                                <input type="text" wire:model="last_name"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['last_name'];
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
                                <label class="font-medium text-gray-700">Email</label>
                                <input type="text" wire:model="email"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
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
                                <label class="font-medium text-gray-700">Phone Number</label>
                                <input type="text" wire:model="phone" maxlength="11"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['phone'];
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

                            <div x-data="{ showPassword: false }" class="relative">
                                <label class="block text-start text-sm font-medium text-gray">Password</label>
                                <div class="relative">
                                    <!-- Password Input -->
                                    <input :type="showPassword ? 'text' : 'password'" wire:model="password"
                                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                        placeholder="**********">

                                    <!-- Show/Hide Password Icon -->
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                        <i x-show="!showPassword" class="fas fa-eye"></i>
                                        <i x-show="showPassword" class="fas fa-eye-slash"></i>
                                    </button>
                                </div>

                                <!-- Error Message (if any) -->
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-sm text-red-600 block text-start italic pt-1"><?php echo e($message); ?></span>

                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div x-data="{ showPassword: false }" class="relative">
                                <label class="block text-start text-sm font-medium text-gray">Confirm
                                    Password</label>
                                <div class="relative">
                                    <!-- Password Input -->
                                    <input :type="showPassword ? 'text' : 'password'" wire:model="password_confirmation"
                                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                        placeholder="**********">

                                    <!-- Show/Hide Password Icon -->
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                        <i x-show="!showPassword" class="fas fa-eye"></i>
                                        <i x-show="showPassword" class="fas fa-eye-slash"></i>
                                    </button>
                                </div>

                                <!-- Error Message (if any) -->
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password_confirmation'];
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
                            


                            <button type="submit" wire:loading.remove wire:click.prevent="AddNewUser"
                                class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                Create Account
                            </button>

                            <button type="submit" wire:loading wire:target="AddNewUser"
                                class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->




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
                                <input type="text" wire:model="email"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['first_name'];
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
                                <label class="font-medium text-gray-700">Phone Number</label>
                                <input type="text" wire:model="phone"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['last_name'];
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
                                <label class="font-medium text-gray-700">Available Balance</label>
                                <input type="text" wire:model="available_balance"
                                    class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
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
                     


                            <button type="submit" wire:loading.remove wire:click.prevent="addUserFund"
                                class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                Fund Account
                            </button>

                            <button type="submit" wire:loading wire:target="addUserFund"
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
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/livewire/admin/user-list.blade.php ENDPATH**/ ?>