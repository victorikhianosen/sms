<!DOCTYPE html>
<html lang="en">

<head>


    <?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</head>

<body>

    


    <div class="relative h-screen">
        <!-- Fixed Sidebar -->

        <?php echo $__env->make('includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Fixed Navbar -->

        <?php echo $__env->make('includes.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Scrollable Body -->
        



        <div class="absolute top-0 right-0 p-6 pb-12 z-50">
            <div class="absolute top-0 left-0 p-6 z-50 w-full flex justify-between items-center">
                <!-- Company Logo (Left Corner) -->
                <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Company Logo" class="w-24 h-auto">

                <div class="relative">
                    <!-- Mobile Menu Button (SVG Icon in Black) -->
                    <button id="menuButton"
                        class="fixed top-4 right-4 z-[9999] p-2 bg-blue-500 text-white rounded-md lg:hidden">
                        <!-- SVG for Open Menu Icon in Black -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-black" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Mobile Menu Overlay (Darker Background) -->
                    <div id="menuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-[9998]" style="display: none;"
                        onclick="toggleMenu()"></div>

                    <!-- Mobile Menu (Slide-in from Right) -->
                    <div id="mobileMenu" class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg z-[10000] p-6"
                        style="display: none;">

                        <!-- Close Button (Right Corner) -->
                        <button id="closeButton" class="absolute top-4 right-4 text-gray-700 text-xl">
                            ✕
                        </button>

                        <!-- Navigation Menu -->
                        <nav class="mt-10 space-y-2">
                            <a href="<?php echo e(route('dashboard')); ?>"
                                class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                <i class="fa-solid fa-house-chimney"></i>
                                <span>Dashboard</span>
                            </a>

                            <!-- Top-up Menu with Dropdown -->
                            <div class="relative">
                                <button id="topupButton"
                                    class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                    <i class="fa-solid fa-mobile-screen-button"></i>
                                    <span>Top-up</span>
                                    <i class="fa-solid fa-chevron-down"></i> <!-- Dropdown icon -->
                                </button>
                                <!-- Dropdown Menu -->
                                <!-- Top-up Dropdown Menu -->
                                <div id="topupDropdown"
                                    class="absolute top-full left-0 w-full bg-white shadow-lg mt-2 hidden p-4">
                                    <ul class="space-y-4">
                                        <li>
                                            <a href="<?php echo e(route('payment.bank')); ?>"
                                                class="text-textPrimary font-light text-sm flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                                                <i class="fa-solid fa-university mr-2"></i> <!-- Bank icon -->
                                                Via Bank Transfer
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(route('payment.paystack')); ?>"
                                                class="text-textPrimary font-light text-sm flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                                                <i class="fa-brands fa-cc-visa mr-2"></i> <!-- Visa card icon -->
                                                Via Card
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <a href="<?php echo e(route('single')); ?>"
                                class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Send SMS</span>
                            </a>
                            <a href="<?php echo e(route('schedule')); ?>"
                                class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                <i class="fa-solid fa-calendar"></i>
                                <span>SMS Scheduling</span>
                            </a>
                            <a href="<?php echo e(route('message')); ?>"
                                class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                <i class="fa-solid fa-message"></i>
                                <span>Messages History</span>
                            </a>
                            <a href="<?php echo e(route('payment.history')); ?>"
                                class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                <i class="fa-solid fa-credit-card"></i>
                                <span>Payment History</span>
                            </a>
                            <a href="<?php echo e(route('groups')); ?>"
                                class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                <i class="fa-solid fa-users"></i>
                                <span>All Groups</span>
                            </a>
                            <a href="<?php echo e(route('apidocs')); ?>"
                                class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                <i class="fa-solid fa-file-lines"></i>
                                <span>API Docs</span>
                            </a>
                            <a href="<?php echo e(route('profile')); ?>"
                                class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                <i class="fa-solid fa-user"></i>
                                <span>Profile</span>
                            </a>
                            <a href="<?php echo e(route('changepassword')); ?>"
                                class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                <i class="fa-solid fa-lock"></i>
                                <span>Change Password</span>
                            </a>
                            <a href="<?php echo e(route('logout')); ?>"
                                class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Logout</span>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <script>
                // Elements
                const menuButton = document.getElementById('menuButton');
                const mobileMenu = document.getElementById('mobileMenu');
                const menuOverlay = document.getElementById('menuOverlay');
                const closeButton = document.getElementById('closeButton');
                const topupButton = document.getElementById('topupButton');
                const topupDropdown = document.getElementById('topupDropdown');

                // Toggle Mobile Menu
                menuButton.addEventListener('click', function() {
                    mobileMenu.style.display = 'block';
                    menuOverlay.style.display = 'block';
                });

                // Close Mobile Menu
                closeButton.addEventListener('click', function() {
                    mobileMenu.style.display = 'none';
                    menuOverlay.style.display = 'none';
                });

                // Close Menu if Overlay is Clicked
                menuOverlay.addEventListener('click', function() {
                    mobileMenu.style.display = 'none';
                    menuOverlay.style.display = 'none';
                });

                // Toggle Top-up Dropdown
                topupButton.addEventListener('click', function() {
                    topupDropdown.classList.toggle('hidden');
                });
            </script>

        </div>


        <div class="relative bg-[#f2f2f2] ml-0 lg:ml-[240px] mt-0 lg:mt-[80px] h-full overflow-y-auto pt-24 lg:pt-6 pb-6 px-6">

            <?php echo $__env->yieldContent('auth-section'); ?>
        </div>





    </div>

    <script src="<?php echo e(asset('assets/js/sweet-alart2.js')); ?>"></script>
    <script>
        window.addEventListener('alert', (event) => {
            const data = event.detail;

            Swal.fire({
                icon: data.type,
                text: data.text,
                position: data.position,
                timer: data.timer,
                buttons: data.button,
            });
        });
    </script>
    <script>
        <?php if(session('alert')): ?>
            window.dispatchEvent(new CustomEvent('alert', {
                detail: {
                    type: '<?php echo e(session('alert.type')); ?>',
                    text: '<?php echo e(session('alert.text')); ?>',
                    position: '<?php echo e(session('alert.position')); ?>',
                    timer: <?php echo e(session('alert.timer')); ?>,
                    button: <?php echo e(session('alert.button') ? 'true' : 'false'); ?>

                }
            }));
        <?php endif; ?>
    </script>

    <script src="https://js.paystack.co/v1/inline.js"></script>
    


</body>

</html>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/layouts/auth_layout.blade.php ENDPATH**/ ?>