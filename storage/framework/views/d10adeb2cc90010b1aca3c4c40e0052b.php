<div wire:poll="getAllUserBalance">
    <div x-data="{ open: false, accountBalance: 1000 }">
        <div class="flex items-end justify-between relative">
            <div>
                <h2 class="font-bold text-2xl">Admin</h2>
            </div>
            <div class="flex items-center gap-8">




                <div>
                    <h2 class="text-blue font-semibold">Transactional</h2>
                    <!--[if BLOCK]><![endif]--><?php if(is_null($exchangeTransBalance)): ?>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-spinner animate-spin text-sm text-blue-500"></i>
                            <p class="text-md text-gray-600 mt-2 animate-pulse">Loading...</p>
                        </div>
                    <?php else: ?>
                        <p
                            class="text-sm font-bold transition-all duration-300 <?php echo e($exchangeTransBalance < 500 ? 'text-red-500' : 'text-green-500'); ?>">
                            &#8358; <?php echo e(number_format($exchangeTransBalance, 2)); ?> / <?php echo e($exchangeTransUnit); ?>Units
                        </p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>


                 <div>
                    <h2 class="text-blue font-semibold">Promotional</h2>
                    <!--[if BLOCK]><![endif]--><?php if(is_null($exchangeProBalance)): ?>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-spinner animate-spin text-sm text-blue-500"></i>
                            <p class="text-md text-gray-600 mt-2 animate-pulse">Loading...</p>
                        </div>
                    <?php else: ?>
                        <p
                            class="text-sm font-bold transition-all duration-300 <?php echo e($exchangeProBalance < 500 ? 'text-red-500' : 'text-green-500'); ?>">
                            &#8358; <?php echo e(number_format($exchangeProBalance, 2)); ?> / <?php echo e($exchangeProUnit); ?>Units
                        </p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <div>
                    <h2 class="text-blue font-semibold">Users Balance</h2>
                    <!--[if BLOCK]><![endif]--><?php if(is_null($totalBalance)): ?>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-spinner animate-spin text-sm text-blue-500"></i>
                            <p class="text-md text-gray-600 mt-2 animate-pulse">Loading...</p>
                        </div>
                    <?php else: ?>
                        <p
                            class="text-sm font-bold transition-all duration-300 <?php echo e($totalBalance < 500 ? 'text-red-500' : 'text-green-500'); ?>">
                            &#8358; <?php echo e(number_format($totalBalance, 2)); ?>

                        </p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div>
                    <h2 class="text-blue font-semibold">Ledger Balance</h2>
                    <!--[if BLOCK]><![endif]--><?php if(is_null($ledgerBalance)): ?>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-spinner animate-spin text-sm text-blue-500"></i>
                            <p class="text-md text-gray-600 mt-2 animate-pulse">Loading...</p>
                        </div>
                    <?php else: ?>
                        <p
                            class="text-sm font-bold transition-all duration-300 <?php echo e($ledgerBalance < 500 ? 'text-red-500' : 'text-green-500'); ?>">
                            &#8358; <?php echo e(number_format($ledgerBalance, 2)); ?>

                        </p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>



                <div class="flex justify-center items-center gap-3 relative" @mouseenter="open = true"
                    @mouseleave="open = false">
                    <div>
                        <!--[if BLOCK]><![endif]--><?php if(is_null($first_name)): ?>
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-spinner animate-spin text-sm text-blue-500"></i>
                                <p class="text-md text-gray-600 mt-2 animate-pulse">Loading...</p>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if(!is_null($first_name)): ?>
                            <h4 class="text-base font-semibold text-blue"><?php echo e($first_name); ?></h4>
                            <p
                                class="text-sm font-bold transition-all duration-300 <?php echo e($allUserBalance < 500 ? 'text-red-500' : 'text-green-500'); ?>">
                                &#8358; <span><?php echo e($balance); ?></span>
                            </p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <img class="w-12 h-12 rounded-full border-4 border-blue cursor-pointer"
                        src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="" />

                    <!-- Dropdown -->
                    <div x-show="open" x-transition
                        class="absolute right-0 mt-44 p-4 w-48 bg-white shadow-lg rounded-lg overflow-hidden z-10 dropdown">
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
</div>
<?php /**PATH /home/victor/Documents/GGT/sms/resources/views/livewire/admin/includes/navbar.blade.php ENDPATH**/ ?>