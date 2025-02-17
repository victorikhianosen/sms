<div class="bg-white fixed top-0 left-[240px] right-0 h-[80px] hidden lg:block py-4 px-6  z-10">


    <div x-data="{ open: false, accountBalance: 1000 }">
        <div class="flex items-end justify-between relative">
            <div>
                <h2 class="font-bold text-2xl">Admin</h2>
            </div>
            <div>
                <div class="flex justify-center items-center gap-3">
                    <div>
                        <h4 class="text-base font-semibold text-blue">Victor</h4>
                        <p class="text-sm font-bold transition-all duration-300"
                            :class="{
                                'text-red-500 animate-pulse': accountBalance < 500,
                                'text-green-500 font-extrabold': accountBalance >= 500
                            }">
                            &#8358; <span x-text="accountBalance.toFixed(2)"></span>
                        </p>
                    </div>

                    <img class="w-12 h-12 rounded-full border-4 border-blue cursor-pointer" src="assets/images/logo.png"
                        alt="" @mouseover="open = true"
                        @mouseleave="setTimeout(() => { if (!document.querySelector('.dropdown:hover')) open = false; }, 300)" />
                </div>

                <div x-show="open"
                    class="absolute right-0 mt-2 p-4 w-48 bg-white shadow-lg rounded-lg overflow-hidden z-10 dropdown"
                    @mouseover="open = true" @mouseleave="open = false" style="display: none;">
                    <a href="#"
                        class="flex items-center px-4 py-2 text-gray-800 transition-all duration-200 hover:translate-x-2 ease-in-out hover:text-blue">
                        <i class="fas fa-cogs mr-3 text-gray-600"></i>
                        <span>Settings</span>
                    </a>

                    <a href="<?php echo e(route('admin.logout')); ?>"
                        class="flex items-center px-4 py-2 text-gray-800 transition-all duration-200 hover:translate-x-2 ease-in-out hover:text-blue">
                        <i class="fas fa-sign-out-alt mr-3 text-gray-600"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>



</div>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/includes/admin/navbar.blade.php ENDPATH**/ ?>