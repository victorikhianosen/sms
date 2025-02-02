<div>
    <div class="h-screen overflow-hidden bg-lightGray grid grid-cols-5">
        <!-- Image Section -->
        <div class="hidden col-span-2 sm:block lg:block">
            <img class="h-screen" src="{{ asset('assets/images/login.jpg') }}" alt="">
        </div>

        <!-- Register Section -->

        <div class="col-span-5 lg:col-span-3 ">
            <di class="">
                <a href="{{ route('home') }}" wire:navigate.hover>
                    <img class="p-6" src="{{ asset('assets/images/logo.png') }}" alt="" />
                </a>
            </di>
            <div class="flex-grow  flex items-center justify-center">

                <div
                    class="bg-white w-auto md:w-4/5 py-8 px-6 sm:px-12 md:px-24 rounded-lg shadow-sm text-center space-y-10">
                    <div class="space-y-1">
                        <h1 class="text-4xl font-bold">Reset Password</h1>
                        <p class="text-softGray text-sm">Enter your new password below to reset your password.</p>

                    </div>
                    <div>
                        <form class="space-y-4">

                            <div x-data="{ showPassword: false }" class="pb-2">
                                <label class="block text-start text-sm font-medium text-gray">Password</label>

                                <!-- Password Input -->
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" wire:model.live="password"
                                        class="w-full px-3 py-3 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                        placeholder="**********">

                                    <!-- Show/Hide Password Icon -->
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                        <i x-show="!showPassword" class="fas fa-eye"></i>
                                        <!-- Eye icon for showing password -->
                                        <i x-show="showPassword" class="fas fa-eye-slash"></i>
                                        <!-- Eye-slash icon for hiding password -->
                                    </button>
                                </div>

                                @error('password')
                                    <span
                                        class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div x-data="{ showPassword: false }" class="pb-2">
                                <label class="block text-start text-sm font-medium text-gray">Confirm Password</label>

                                <!-- Password Input -->
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" wire:model.live="password_confirmation"
                                        class="w-full px-3 py-3 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                        placeholder="**********">

                                    <!-- Show/Hide Password Icon -->
                                    <button type="button" @click="showPassword = !showPassword"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                        <i x-show="!showPassword" class="fas fa-eye"></i>
                                        <!-- Eye icon for showing password -->
                                        <i x-show="showPassword" class="fas fa-eye-slash"></i>
                                        <!-- Eye-slash icon for hiding password -->
                                    </button>
                                </div>

                                @error('password_confirmation')
                                    <span
                                        class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="pt-6">
                                <button wire:click.prevent="resetUserPassword" wire:loading.remove
                                    class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                    Submit
                                </button>


                                <button type="submit" wire:loading wire:target="resetUserPassword"
                                    class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                    <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                                </button>
                            </div>
                            <div class="pt-4">
                                <a href="{{ route('register') }}" wire:navigate.hover class="text-gray text-sm ">Don't
                                    have
                                    an account? <span
                                        class="font-semibold text-blue transition-all duration-200 hover:font-bold">Sign
                                        up</span></a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
