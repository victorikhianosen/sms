<div>

    <div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-10 pb-24 mb-10" wire:init="getUserDetails">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="#" onclick="history.back()"
                    class="text-gray-700 transition-all hidden md:block duration-200 hover:translate-x-1 hover:text-softGray">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h3 class="font-bold text-2xl">User Details</h3>
            </div>
            <div>

                <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                    <!--[if BLOCK]><![endif]--><?php if($allUsers): ?>
                        <div x-data="{ isApiKeyModalOpen: false }">
                            <button @click="isApiKeyModalOpen = true"
                                class="bg-blue px-4 py-2 text-sm transition-all text-white rounded-lg duration-200 hover:opacity-90">
                                API Keys
                            </button>

                            <!-- API Key Modal -->
                            <div x-show="isApiKeyModalOpen"
                                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                <div @click.away="isApiKeyModalOpen = false"
                                    class="bg-white p-8 rounded-lg shadow-lg w-[600px] max-w-lg">
                                    <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                                        <h3 class="text-2xl font-bold">API Keys</h3>

                                        <button @click="isApiKeyModalOpen = false" class="text-black text-2xl">
                                            <i class="fas fa-times"></i>
                                        </button>

                                    </div>

                                    <form wire:submit.prevent="updateUserKey" class="mt-4 text-gray-700 space-y-4 pt-6">
                                        <div>
                                            <label class="font-medium text-gray-700">API Key</label>
                                            <input type="text" id="messageId" wire:model="api_key"
                                                class="w-full px-4 py-3 border rounded-md bg-gray-100 text-gray-600"
                                                readonly>
                                        </div>

                                        <div>
                                            <label class="font-medium text-gray-700">API Secret</label>
                                            <input type="text" id="messageSender" wire:model="api_secret"
                                                class="w-full px-4 py-3 border rounded-md bg-gray-100 text-gray-600"
                                                readonly>
                                        </div>

                                        <div class="mt-6 flex justify-start pt-4 space-x-4">
                                            <button wire:loading.remove
                                                class="px-6 py-3 bg-blue text-white rounded-lg hover:bg-opacity-90 transition text-sm">
                                                Update Key
                                            </button>

                                            <button type="submit" wire:loading wire:target="updateUserKey"
                                                class="px-6 py-3 bg-blue text-white rounded-lg hover:opacity-90 transition text-sm">
                                                <i class="fa-solid fa-spinner animate-spin mr-1"></i> Loading...
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            </div>
        </div>
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto">


                    <!--[if BLOCK]><![endif]--><?php if(!$allUsers): ?>
                        <div class="text-center">
                            <i class="fa-solid fa-spinner animate-spin text-4xl text-blue"></i>
                            <p class="text-lg text-gray-600 mt-2 animate-pulse">Loading...</p>
                        </div>
                    <?php else: ?>
                        <div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-2 items-center">

                                <!-- Profile Picture Section -->
                                <div x-data="{ isProfileOpen: false }" class="relative">
                                    <label class="font-medium text-gray-700">Profile Picture</label>
                                    <img @click="isProfileOpen = !isProfileOpen"
                                        class="w-3/4 h-52 object-fit rounded-lg cursor-pointer"
                                        src="<?php echo e($profile_picture && file_exists(public_path('storage/' . $profile_picture))
                                            ? asset('storage/' . $profile_picture)
                                            : asset('assets/images/no-image.jpg')); ?>"
                                        alt="Profile Picture" />

                                    <!-- Profile Picture Popup -->
                                    <div x-show="isProfileOpen"
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div @click.away="isProfileOpen = false"
                                            class="bg-white p-1 rounded-lg shadow-lg relative">
                                            <button @click="isProfileOpen = false"
                                                class="absolute top-2 right-2 bg-red-500 text-white py-1 px-2 rounded-full">
                                                X
                                            </button>
                                            <img class="w-96 h-72 md:w-96 md:h-96 object-fit rounded-lg"
                                                src="<?php echo e($profile_picture && file_exists(public_path('storage/' . $profile_picture))
                                                    ? asset('storage/' . $profile_picture)
                                                    : asset('assets/images/no-image.jpg')); ?>"
                                                alt="Profile Picture" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Valid ID Section -->
                                <div x-data="{ isIdOpen: false }" class="relative">
                                    <label class="font-medium text-gray-700">Valid ID</label>
                                    <img @click="isIdOpen = !isIdOpen"
                                        class="w-3/4 h-52 object-fit rounded-lg cursor-pointer"
                                        src="<?php echo e($valid_id && file_exists(public_path('storage/' . $valid_id))
                                            ? asset('storage/' . $valid_id)
                                            : asset('assets/images/no-image.jpg')); ?>"
                                        alt="Valid ID" />

                                    <!-- Valid ID Popup -->
                                    <div x-show="isIdOpen"
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div @click.away="isIdOpen = false"
                                            class="bg-white p-1 rounded-lg shadow-lg relative">
                                            <button @click="isIdOpen = false"
                                                class="absolute top-2 right-2 bg-red-500 text-white py-1 px-2 rounded-full">
                                                X
                                            </button>
                                            <img class="w-96 h-52 md:w-[60rem] md:h-96 object-fit rounded-lg"
                                                src="<?php echo e($valid_id && file_exists(public_path('storage/' . $valid_id))
                                                    ? asset('storage/' . $valid_id)
                                                    : asset('assets/images/no-image.jpg')); ?>"
                                                alt="Valid ID" />
                                        </div>
                                    </div>
                                </div>

                                <form class="space-y-4">
                                    <h2 class="font-medium">Reset User Password</h2>


                                    <div class="space-y-2">


                                        <div x-data="{ showPassword: false }" class="pb-2">
                                            <label
                                                class="block text-start text-sm font-medium text-gray">Password</label>

                                            <!-- Password Input -->
                                            <div class="relative w-3/5">
                                                <input :type="showPassword ? 'text' : 'password'" wire:model="password"
                                                    class="w-full pl-3 pr-10 py-1 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                                    placeholder="**********">

                                                <!-- Show/Hide Password Icon -->
                                                <button type="button" @click="showPassword = !showPassword"
                                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                                    <i x-show="!showPassword" class="fas fa-eye"></i>
                                                    <!-- Eye icon for showing password -->
                                                    <i x-show="showPassword" class="fas fa-eye-slash"></i>
                                                    <!-- Eye-slash icon for hiding password -->
                                                </button>
                                            </div>

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

                                        <div x-data="{ showPassword: false }" class="pb-2">
                                            <label class="block text-start text-sm font-medium text-gray">Password
                                                Confirmation</label>

                                            <!-- Password Input -->
                                            <div class="relative w-3/5">
                                                <input :type="showPassword ? 'text' : 'password'" wire:model="password"
                                                    class="w-full pl-3 pr-10 py-1 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                                    placeholder="**********">

                                                <!-- Show/Hide Password Icon -->
                                                <button type="button" @click="showPassword = !showPassword"
                                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                                    <i x-show="!showPassword" class="fas fa-eye"></i>
                                                    <!-- Eye icon for showing password -->
                                                    <i x-show="showPassword" class="fas fa-eye-slash"></i>
                                                    <!-- Eye-slash icon for hiding password -->
                                                </button>
                                            </div>

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

                                    </div>


                                    <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                        <div class=" flex justify-start items-center pt-2">
                                            <button wire:click.prevent="ChangePassword"
                                                class="px-5 py-2 bg-blue text-white rounded-lg hover:bg-opacity-90 transition text-xs"
                                                id="closeModalBtn">
                                                Update Password
                                            </button>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->



                                </form>
                            </div>

                        </div>


                        


                        <form class="">
                            <div class="pt-8 grid grid-cols-1 lg:grid-cols-3 gap-8 text-gray-700">
                                <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                    <div>
                                        <label class="font-medium text-gray-700">First Name</label>
                                        <input type="text" wire:model="first_name"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                                            id="first_name">
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">Last Name</label>
                                        <input type="text" wire:model="last_name"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                                            id="last_name">
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">Email</label>
                                        <input type="text" wire:model="email"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                                            id="email">
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">Balance</label>
                                        <input type="text" wire:model="balance"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600" readonly
                                            id="phone">
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">Status</label>
                                        <select wire:model="status"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600">
                                            <option value="">Select Status</option>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusOption): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($statusOption); ?>"><?php echo e($statusOption); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">Address</label>
                                        <input type="text" wire:model="address"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                                            id="created_at">
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">Company Name</label>
                                        <input type="text" wire:model="company_name"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                                            id="created_at">
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">SMS Rate</label>
                                        <input type="number" wire:model="sms_rate" maxlength="5"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                                            id="created_at">
                                    </div>
                                <?php else: ?>
                                    <div>
                                        <label class="font-medium text-gray-700">First Name</label>
                                        <input type="text"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-600"
                                            id="first_name" value="<?php echo e($first_name); ?>" readonly>
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">Last Name</label>
                                        <input type="text"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-600"
                                            id="last_name" value="<?php echo e($last_name); ?>" readonly>
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">Email</label>
                                        <input type="text"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-600"
                                            id="email" value="<?php echo e($email); ?>" readonly>
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">Balance</label>
                                        <input type="text"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-600"
                                            id="phone" value="<?php echo e($balance); ?>" readonly>
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">Status</label>
                                        <input type="text"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-600"
                                            value="<?php echo e($status); ?>" readonly>
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">Address</label>
                                        <input type="text"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-600"
                                            id="created_at" value="<?php echo e($address); ?>" readonly>
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">Company Name</label>
                                        <input type="text"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-600"
                                            id="created_at" value="<?php echo e($company_name); ?>" readonly>
                                    </div>

                                    <div>
                                        <label class="font-medium text-gray-700">SMS Rate</label>
                                        <input type="number"
                                            class="w-full px-3 py-2 border rounded-md bg-gray-200 text-gray-600"
                                            id="created_at" value="<?php echo e($sms_rate); ?>" readonly>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <div>
                                    <label class="font-medium text-gray-700">Account Number</label>
                                    <input type="text" wire:model="account_number"
                                        class="w-full px-3 py-2 border rounded-md bg-lightGray text-gray-600"
                                        id="created_at" readonly>
                                </div>

                                <div>
                                    <label class="font-medium text-gray-700">Phone</label>
                                    <input type="number" wire:model="phone" maxlength="11"
                                        class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                                        id="created_at" readonly>
                                </div>

                                <div>
                                    <label class="font-medium text-gray-700">Last OTP</label>
                                    <input type="text" wire:model="otp"
                                        class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                                        id="created_at" readonly>
                                </div>

                                <div>
                                    <label class="font-medium text-gray-700">OTP Expiration</label>
                                    <input type="text" wire:model="otp_expired_at"
                                        class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                                        id="created_at" readonly>
                                </div>
                            </div>

                            <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                <div class="flex justify-start items-center pt-6">
                                    <button wire:click.prevent="updateUserAccount"
                                        class="px-5 py-2 bg-blue text-white rounded-lg hover:bg-opacity-90 transition"
                                        id="closeModalBtn">
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
<?php /**PATH /home/victor/Documents/GGT/sms/resources/views/livewire/admin/user-details.blade.php ENDPATH**/ ?>