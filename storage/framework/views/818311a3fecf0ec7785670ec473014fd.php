<div>
    <div class="flex flex-col bg-white rounded-lg pb-12">
        <div class="pt-4 md:pt-8 pb-10 px-6">
            <h3 class="font-bold text-2xl">Change Password</h3>
        </div>


        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto mx-6">


                    <form class="space-y-4">

                        <div x-data="{ showPassword: false }" class="pb-2">
                            <label class="block text-start text-sm font-medium text-gray">Current Password</label>

                            <!-- Password Input -->
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" wire:model="current_password"
                                    class="w-full md:w-1/5 xl:w-1/5 px-3 py-2 pr-10 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                    placeholder="Enter current password">
                            </div>

                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['current_password'];
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

                        <div x-data="{ showPassword: false }" class="pb-2">
                            <label class="block text-start text-sm font-medium text-gray">Password</label>

                            <!-- Password Input -->
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" wire:model="password"
                                    class="w-full md:w-1/5 xl:w-1/5 px-3 py-2 pr-10 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                    placeholder="">
                            </div>

                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
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


                        <div x-data="{ showPassword: false }" class="pb-2">
                            <label class="block text-start text-sm font-medium text-gray">Password Confirmation</label>

                            <!-- Password Input -->
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" wire:model="password_confirmation"
                                    class="w-full md:w-1/5 xl:w-1/5 px-3 py-2 pr-10 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                    placeholder="">
                            </div>

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



                        <div class="pt-6">
                            <button wire:click.prevent="UpdateUserPassword"
                                class="w-full md:w-1/5 xl:w-1/5 bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                Update password
                            </button>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>



</div>



</div>
<?php /**PATH /home/victor/Documents/GGT/sms/resources/views/livewire/user/change-password.blade.php ENDPATH**/ ?>