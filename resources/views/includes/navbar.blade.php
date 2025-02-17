<div class="bg-white fixed top-0 left-[240px] right-0 h-[80px] hidden lg:block py-4 px-6  z-10">
    {{-- <div class="flex items-end justify-end relative">
        <!-- User Image with Dropdown -->
        <div x-data="{ open: false }">
            <!-- User Avatar -->

          <div class="flex justify-center items-center gap-3">
            <div>
                <h4 class="text-base font-semibold text-blue">Victor</h4>
                <p class="text-sm">₦{{Session::get('balance')}}</p>
            </div>
              <img class="w-12 h-12 rounded-full border-4 border-blue cursor-pointer" src="{{ asset('assets/images/login.png') }}" alt=""
                @click="open = !open" />
          </div>

            <!-- Dropdown Menu -->
            <div x-show="open" x-transition
                @click.away="open = false"
                class="absolute right-0 mt-2 p-4 w-48 bg-white shadow-lg rounded-lg overflow-hidden z-10">
                <!-- Settings Item -->
                <a href="#" class="flex items-center px-4 py-2 text-gray-800 transition-all duration-200 ease-in-out hover:text-blue">
                    <i class="fas fa-cogs mr-3 text-gray-600"></i> <!-- FontAwesome Settings Icon -->
                    <span>Settings</span>
                </a>
                <!-- Logout Item -->
                <a href="{{ route('logout') }}" class="flex items-center px-4 py-2 text-gray-800 transition-all duration-200 ease-in-out hover:text-blue">
                    <i class="fas fa-sign-out-alt mr-3 text-gray-600"></i> <!-- FontAwesome Logout Icon -->
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div> --}}


    <livewire:include.nav-bar />


</div>


