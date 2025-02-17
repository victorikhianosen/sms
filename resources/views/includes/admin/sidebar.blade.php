<div class="bg-white fixed left-0 top-0 h-full w-[250px] hidden lg:block overflow-hidden" x-data="{ activeLink: '' }">
    <div class="px-6 py-6 h-full flex flex-col">
        <div class="">
            <img class="h-16" src="{{ asset('assets/images/logo.png') }}" />
        </div>

        <div class="p-3 flex-1 overflow-y-auto">
            <ul class="pt-12 space-y-6" x-data="{ openMenu: null }">
                <div class=space-y-4>
                    <p class="text-textSecondary font-light text-sm pt-4 uppercase">Main</p>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" wire:navigate.hover
                            @click.prevent="activeLink = 'bulk'"
                            :class="{ 'text-blue font-semibold': activeLink === 'bulk', 'text-gray': activeLink !== 'bulk' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            Dashboard
                        </a>
                    </li>
                </div>

                {{-- <div class="space-y-4">
                    <p class="text-textSecondary font-light text-sm uppercase">Top-up</p>
                    <li>
                        <a href="#" @click.prevent="openMenu = openMenu === 'topup' ? null : 'topup'"
                            class="flex justify-between items-center">
                            <div
                                class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                                <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                                Buy SMS Units
                            </div>
                            <span class="ml-auto block">
                                <i :class="openMenu === 'topup' ? 'fa-solid fa-chevron-down text-sm' :
                                        'fa-solid fa-chevron-right text-sm'"></i>
                            </span>
                        </a>
                        <ul x-show="openMenu === 'topup'" x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 transform scale-y-0"
                            x-transition:enter-end="opacity-100 transform scale-y-100"
                            x-transition:leave="transition ease-in duration-500"
                            x-transition:leave-start="opacity-100 transform scale-y-100"
                            x-transition:leave-end="opacity-0 transform scale-y-0"
                            class="pl-6 pt-4 space-y-4 origin-top transform-gpu overflow-hidden">
                            <li><a href="#"
                                    class="text-textPrimary font-light text-sm flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">Via
                                    Bank Transfer</a></li>
                            <li><a href="#"
                                    class="text-textPrimary font-light text-sm flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">Via
                                    Card</a></li>
                        </ul>
                    </li>
                </div> --}}

                <div class="space-y-4">
                    <p class="text-textSecondary font-light text-sm pt-4 uppercase">User Management</p>
                    <li>
                        <a href="{{ route('admin.userlist') }}" wire:navigate.hover
                            @click.prevent="activeLink = 'single'"
                            :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            All Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.list') }}" wire:navigate.hover @click.prevent="activeLink = 'bulk'"
                            :class="{ 'text-blue font-semibold': activeLink === 'bulk', 'text-gray': activeLink !== 'bulk' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            All Admins
                        </a>
                    </li>
                </div>



                <div class="space-y-4">
                    <p class="text-textSecondary font-light text-sm pt-4 uppercase">Transactions</p>
                    <li>
                        <a href="{{ route('admin.payment') }}" wire:navigate.hover
                            @click.prevent="activeLink = 'single'"
                            :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            Payments
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('admin.list') }}" wire:navigate.hover @click.prevent="activeLink = 'bulk'"
                            :class="{ 'text-blue font-semibold': activeLink === 'bulk', 'text-gray': activeLink !== 'bulk' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            All Admins
                        </a>
                    </li> --}}
                </div>

                <div class=space-y-4>
                    <p class="text-textSecondary font-light text-sm pt-4 uppercase">Resources</p>
                    <li>
                        <a href="{{ route('admin.message') }}" wire:navigate.hover
                            :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            All Messages
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.smssender') }}" wire:navigate.hover
                            :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            All Senders
                        </a>
                    </li>
                </div>



                <div class=space-y-4>
                    <p class="text-textSecondary font-light text-sm pt-4 uppercase">Settings</p>
                    <li>
                        <a href="{{ route('admin.logout') }}"
                            :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            Logout
                        </a>
                    </li>
                </div>
            </ul>
        </div>
    </div>
</div>
