 <div class="bg-white fixed left-0 top-0 h-full w-[240px] hidden lg:block">
     <div class="px-6">
         <div class="">
             <img src="{{ asset('assets/images/logo.png') }}" />
         </div>

         <div class="p-3">

             <ul class="pt-12 space-y-5" x-data="{ openMenu: null }">


                 <li>
                     <a href="{{ route('dashboard') }}" wire:navigate.hover
                         @click.prevent="openMenu = openMenu === 'dashboard' ? null : 'dashboard'"
                         class="text-gray text-lg flex items-center transition-all duration-200 hover:text-blue">
                         <span><i class="fa-solid fa-mobile-screen-button mr-1"></i></span>
                         DashBoard

                     </a>

                 </li>


                 <!-- SMS Menu -->
                 <li>
                     <a href="#" @click.prevent="openMenu = openMenu === 'sms' ? null : 'sms'"
                         class="text-gray text-lg flex items-center transition-all duration-200 hover:text-blue">
                         <span><i class="fa-solid fa-mobile-screen-button mr-1"></i></span>
                         SMS
                         <span class="ml-auto">
                             <i
                                 :class="openMenu === 'sms' ? 'fa-solid fa-chevron-down text-sm' :
                                     'fa-solid fa-chevron-right text-sm'"></i>
                         </span>
                     </a>
                     <ul x-show="openMenu === 'sms'" x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform scale-y-0"
                         x-transition:enter-end="opacity-100 transform scale-y-100"
                         x-transition:leave="transition ease-in duration-500"
                         x-transition:leave-start="opacity-100 transform scale-y-100"
                         x-transition:leave-end="opacity-0 transform scale-y-0"
                         class="pl-6 pt-4 space-y-4 origin-top transform-gpu overflow-hidden">
                         <li><a href="{{ route('sms.message') }}" wire:navigate.hover
                                 class="text-gray text-base hover:text-blue hover:font-semibold">Last 3
                                 days</a></li>
                         <li><a href="{{ route('sms.old') }}" wire:navigate.hover
                                 class="text-gray text-base hover:text-blue hover:font-semibold">Older
                                 Message</a></li>
                         <li><a href="{{ route('sms.single') }}" wire:navigate.hover
                                 class="text-gray text-base hover:text-blue hover:font-semibold">Single
                                 SMS</a></li>
                         <li><a href="{{ route('sms.bulk') }}" wire:navigate.hover
                                 class="text-gray text-base hover:text-blue hover:font-semibold">Bulk
                                 SMS</a></li>
                         <li><a href="{{ route('sms.payment') }}" wire:navigate.hover
                                 class="text-gray text-base hover:text-blue hover:font-semibold">Payment</a></li>
                     </ul>
                 </li>

                 <!-- USSD Menu -->
                 <li>
                     <a href="#" @click.prevent="openMenu = openMenu === 'ussd' ? null : 'ussd'"
                         class="text-gray text-lg flex items-center transition-all duration-200 hover:text-blue">
                         <span><i class="fa-solid fa-mobile-screen-button mr-1"></i></span>
                         USSD
                         <span class="ml-auto">
                             <i
                                 :class="openMenu === 'ussd' ? 'fa-solid fa-chevron-down text-sm' :
                                     'fa-solid fa-chevron-right text-sm'"></i>
                         </span>
                     </a>
                     <ul x-show="openMenu === 'ussd'" x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform scale-y-0"
                         x-transition:enter-end="opacity-100 transform scale-y-100"
                         x-transition:leave="transition ease-in duration-500"
                         x-transition:leave-start="opacity-100 transform scale-y-100"
                         x-transition:leave-end="opacity-0 transform scale-y-0"
                         class="pl-6 pt-4 space-y-4 origin-top transform-gpu overflow-hidden">
                         <li><a href="{{ route('ussd.usage') }}" wire:navigate.hover
                                 class="text-gray text-base hover:text-blue hover:font-semibold">Usage</a>
                         </li>
                         <li><a href="{{ route('ussd.shortcode') }}" wire:navigate.hover
                                 class="text-gray text-base hover:text-blue hover:font-semibold">Shortcode</a>
                         </li>
                         <li><a href="{{ route('ussd.payment') }}" wire:navigate.hover
                                 class="text-gray text-base hover:text-blue hover:font-semibold">Payment</a>
                          </li>
                         <li><a href="{{ route('ussd.logs') }}" wire:navigate.hover
                                 class="text-gray text-base hover:text-blue hover:font-semibold">Logs</a>
                         </li>

                     </ul>
                 </li>

                 <!-- VAS Menu -->
                 <li>
                     <a href="#" @click.prevent="openMenu = openMenu === 'vas' ? null : 'vas'"
                         class="text-gray text-lg flex items-center transition-all duration-200 hover:text-blue">
                         <span><i class="fa-solid fa-mobile-screen-button mr-1"></i></span>
                         Vas
                         <span class="ml-auto">
                             <i
                                 :class="openMenu === 'vas' ? 'fa-solid fa-chevron-down text-sm' :
                                     'fa-solid fa-chevron-right text-sm'"></i>
                         </span>
                     </a>
                     <ul x-show="openMenu === 'vas'" x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 transform scale-y-0"
                         x-transition:enter-end="opacity-100 transform scale-y-100"
                         x-transition:leave="transition ease-in duration-500"
                         x-transition:leave-start="opacity-100 transform scale-y-100"
                         x-transition:leave-end="opacity-0 transform scale-y-0"
                         class="pl-6 pt-4 space-y-4 origin-top transform-gpu overflow-hidden">
                         <li><a href="#" class="text-gray text-base hover:text-blue hover:font-semibold">MTN</a>
                         </li>
                         <li><a href="#" class="text-gray text-base hover:text-blue hover:font-semibold">GLO</a>
                         </li>
                     </ul>
                 </li>
             </ul>




         </div>

     </div>
 </div>
