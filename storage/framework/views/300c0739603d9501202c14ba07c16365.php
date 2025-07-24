    <div class="flex justify-between items-center pt-6 pb-4 px-6 sm:block md:hidden">
            <div>
                <img class="object-fit w-36" src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="">
            </div>



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
                        <div id="menuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-[9998]"
                            style="display: none;" onclick="toggleMenu()"></div>

                        <!-- Mobile Menu (Slide-in from Right) -->
                        <div id="mobileMenu" class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg z-[10000] p-6"
                            style="display: none;">

                            <!-- Close Button (Right Corner) -->
                            <button id="closeButton" class="absolute top-4 right-4 text-gray-700 text-xl">
                                ✕
                            </button>

                            <!-- Navigation Menu -->
                            <nav class="mt-10 space-y-2">
                                <a href="<?php echo e(route('admin.dashboard')); ?>"
                                    class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                    <i class="fa-solid fa-house-chimney"></i>
                                    <span>Dashboard</span>
                                </a>

                         

                                <a href="<?php echo e(route('admin.sendsms')); ?>"
                                    class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    <span>Send SMS</span>
                                </a>
                                <a href="<?php echo e(route('admin.userlist')); ?>"
                                    class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                    <i class="fa-solid fa-calendar"></i>
                                    <span>All Users</span>
                                </a>
                                <a href="<?php echo e(route('admin.list')); ?>"
                                    class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                    <i class="fa-solid fa-message"></i>
                                    <span>All Admin</span>
                                </a>
                                <a href="<?php echo e(route('admin.payment')); ?>"
                                    class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                    <i class="fa-solid fa-credit-card"></i>
                                    <span>Payment history</span>
                                </a>
                                <a href="<?php echo e(route('admin.message')); ?>"
                                    class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                    <i class="fa-solid fa-users"></i>
                                    <span>All Message</span>
                                </a>
                                <a href="<?php echo e(route('admin.smssender')); ?>"
                                    class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                    <i class="fa-solid fa-file-lines"></i>
                                    <span>All Sender</span>
                                </a>
                                <a href="<?php echo e(route('admin.group')); ?>"
                                    class="flex items-center space-x-2 text-gray-800 hover:bg-gray-200 px-4 py-2 rounded-md transition-all duration-200 hover:translate-x-2 hover:text-blue ease-in-out">
                                    <i class="fa-solid fa-user"></i>
                                    <span>All Group</span>
                                </a>
                           
                                <a href="<?php echo e(route('admin.logout')); ?>"
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

        </div><?php /**PATH /home/victor/Documents/GGT/sms/resources/views/includes/admin/mobile_menu.blade.php ENDPATH**/ ?>