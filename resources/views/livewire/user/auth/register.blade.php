<div>
    <div class="h-screen overflow-x-hidden md:overflow-hidden bg-lightGray grid grid-cols-5">
        <!-- Image Section -->
        <div class="hidden col-span-2 sm:block lg:block">
            <img class="h-screen" src="{{ asset('assets/images/login.jpg') }}" alt="">
        </div>

        <!-- Register Section -->

        <div class="col-span-5 lg:col-span-3 ">
            <di class="">
                <img class="p-6" src="{{ asset('assets/images/logo.png') }}" alt="" />
            </di>
            <div class="flex-grow  flex items-center justify-center">

                <div
                    class="bg-white w-auto md:w-4/5 py-8 px-6 sm:px-12 md:px-24 rounded-lg shadow-sm text-center space-y-10">
                    <div class="space-y-1">
                        <h1 class="text-4xl font-bold">Register!</h1>
                        <p class="text-softGray text-sm">Please enter your info to create an account..</p>
                    </div>
                    <div>

                        <form class="space-y-5" wire:submit.prevent="registerUser">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-0 md:gap-x-6 gap-y-4 md:gap-y-0">

                                <div class="">
                                    <label class="block text-start text-sm font-medium text-gray">First Name</label>
                                    <input type="text" wire:model="first_name"
                                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                        placeholder="">
                                    @error('first_name')
                                        <span
                                            class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="">
                                    <label class="block text-start text-sm font-medium text-gray">Last Name</label>
                                    <input type="text" wire:model="last_name"
                                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                        placeholder="">
                                    @error('last_name')
                                        <span
                                            class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-0 md:gap-x-6 gap-y-4 md:gap-y-0">

                                <div class="">
                                    <label class="block text-start text-sm font-medium text-gray">Email</label>
                                    <input type="text" wire:model="email"
                                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                        placeholder="victor@example.com">
                                    @error('email')
                                        <span
                                            class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="">
                                    <label class="block text-start text-sm font-medium text-gray">Phone Number</label>
                                    <input type="text" wire:model="phone" maxlength="11"
                                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                        placeholder="07033274155">
                                    @error('phone')
                                        <span
                                            class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>



                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-0 md:gap-x-6 gap-y-4 md:gap-y-0">

                                <div x-data="{ showPassword: false }" class="relative">
                                    <label class="block text-start text-sm font-medium text-gray">Password</label>
                                    <div class="relative">
                                        <!-- Password Input -->
                                        <input :type="showPassword ? 'text' : 'password'" wire:model="password"
                                            class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                            placeholder="**********">

                                        <!-- Show/Hide Password Icon -->
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                            <i x-show="!showPassword" class="fas fa-eye"></i>
                                            <i x-show="showPassword" class="fas fa-eye-slash"></i>
                                        </button>
                                    </div>

                                    <!-- Error Message (if any) -->
                                    @error('password')
                                        <span
                                            class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>

                                        </span>
                                    @enderror
                                </div>


                                <div x-data="{ showPassword: false }" class="relative">
                                    <label class="block text-start text-sm font-medium text-gray">Confirm
                                        Password</label>
                                    <div class="relative">
                                        <!-- Password Input -->
                                        <input :type="showPassword ? 'text' : 'password'"
                                            wire:model="password_confirmation"
                                            class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                            placeholder="**********">

                                        <!-- Show/Hide Password Icon -->
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                            <i x-show="!showPassword" class="fas fa-eye"></i>
                                            <i x-show="showPassword" class="fas fa-eye-slash"></i>
                                        </button>
                                    </div>

                                    <!-- Error Message (if any) -->
                                    @error('password_confirmation')
                                        <span
                                            class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                                    @enderror
                                </div>


                            </div>

                            <div class="pt-4">
                                <button type="submit" wire:loading.remove
                                    class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                    Create Account
                                </button>

                                <button type="submit" wire:loading wire:target="registerUser"
                                    class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                    <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                                </button>


                            </div>


                            <div class="">
                                <a href="{{ route('login') }}" wire:navigate.hover class="text-gray text-sm">Already
                                    have
                                    an account? <span class="font-semibold text-blue">Sign in</span></a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
