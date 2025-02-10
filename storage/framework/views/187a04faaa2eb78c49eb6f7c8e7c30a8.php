<div wire:poll.2000ms="updateBalance"> <!-- Refresh every 2 seconds -->

    <div class="flex items-end justify-end relative">
        <div>
            <div class="flex justify-center items-center gap-3">
                <div>
                    <h4 class="text-base font-semibold text-blue">Victor</h4>
                    <p class="text-sm font-bold transition-all duration-300"
                        :class="{
                            'text-red-500 animate-pulse': <?php echo e($accountBalance); ?> < 500,
                            'text-green-500 font-extrabold': <?php echo e($accountBalance); ?> >= 500
                        }">
                        ₦ <?php echo e(number_format($accountBalance, 2)); ?>

                    </p>
                </div>
                <img class="w-12 h-12 rounded-full border-4 border-blue cursor-pointer"
                    src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="" />
            </div>


            
            <div 
                class="absolute right-0 mt-2 p-4 w-48 bg-white shadow-lg rounded-lg overflow-hidden z-10">
                <a href="<?php echo e(route('profile')); ?>" wire:navigate.hover
                    class="flex items-center px-4 py-2 text-gray-800 transition-all duration-200 ease-in-out hover:text-blue">
                    <i class="fas fa-cogs mr-3 text-gray-600"></i>
                    <span>Settings</span>
                </a>

                <a href="<?php echo e(route('changepassword')); ?>" wire:navigate.hover
                    class="flex items-center px-4 py-2 text-gray-800 transition-all duration-200 ease-in-out hover:text-blue">
                    <i class="fas fa-cogs mr-3 text-gray-600"></i>
                    <span>Change Password</span>
                </a>
                <a href="<?php echo e(route('logout')); ?>"
                    class="flex items-center px-4 py-2 text-gray-800 transition-all duration-200 ease-in-out hover:text-blue">
                    <i class="fas fa-sign-out-alt mr-3 text-gray-600"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>

</div>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/livewire/include/nav-bar.blade.php ENDPATH**/ ?>