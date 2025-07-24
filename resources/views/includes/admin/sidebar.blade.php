<div class="bg-white fixed left-0 top-0 h-full w-[350px] hidden lg:block overflow-hidden" x-data="{ activeLink: '' }">
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


                <div class=space-y-4>
                    <p class="text-textSecondary font-light text-sm pt-4 uppercase">Message Management</p>
                    <li>
                        <a href="{{ route('admin.sendsms') }}" wire:navigate.hover @click.prevent="activeLink = 'bulk'"
                            :class="{ 'text-blue font-semibold': activeLink === 'bulk', 'text-gray': activeLink !== 'bulk' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            Send SMS
                        </a>
                    </li>
                </div>

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

                </div>

                <div class=space-y-6>
                    <p class="text-textSecondary font-light text-sm pt-4 uppercase">Resources</p>
                    <li>
                        <a href="{{ route('admin.message') }}" wire:navigate.hover
                            :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            Users Messages
                        </a>
                    </li>


                    <li>
                        <a href="{{ route('admin.adminmessage') }}" wire:navigate.hover
                            :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            Admins Messages
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.schedulelist') }}" wire:navigate.hover
                            :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            Schedule Messages
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


                    <li>
                        <a href="{{ route('admin.group') }}" wire:navigate.hover
                            :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            All Group
                        </a>
                    </li>

                </div>




                <div class=space-y-6>
                    <p class="text-textSecondary font-light text-sm pt-4 uppercase">Ledger & Provider</p>


                    @adminOrSuperAdmin
                        <li>
                            <a href="{{ route('admin.ledgers') }}" wire:navigate.hover
                                :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                                class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                                <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                                Ledger Accounts
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.transactions') }}" wire:navigate.hover
                                :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                                class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                                <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                                Transactions
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.exchange') }}" wire:navigate.hover
                                :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                                class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                                <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                                Exchange Accounts
                            </a>
                        </li>
                    @endadminOrSuperAdmin
                </div>



                <div class=space-y-4>
                    <p class="text-textSecondary font-light text-sm pt-4 uppercase">Settings</p>
                    <li>
                        <a href="{{ route('admin.providers') }}"
                            :class="{ 'text-blue font-semibold': activeLink === 'single', 'text-gray': activeLink !== 'single' }"
                            class="text-textPrimary font-light text-base flex items-center transition-all duration-500 hover:translate-x-2 hover:text-blue hover:font-medium">
                            <span><i class="fa-solid fa-mobile-screen-button mr-2"></i></span>
                            Providers
                        </a>
                    </li>


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
