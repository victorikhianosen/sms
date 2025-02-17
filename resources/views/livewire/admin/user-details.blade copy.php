<div>

    <div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-10 pb-12" wire:init="getUserDetails">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="#" onclick="history.back()"
                    class="text-gray-700 transition-all hidden md:block duration-200 hover:translate-x-1 hover:text-softGray">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h3 class="font-bold text-2xl">User Details</h3>
            </div>
            <div>
                @if ($allUsers)
                    <button
                        class="bg-blue px-4 py-2 text-sm transtion-all text-white rounded-lg duration-200 hover:opacity-90">
                        API Keys
                    </button>
                @endif
            </div>
        </div>
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto">


                    @if (!$allUsers)
                        <div class="text-center">
                            <i class="fa-solid fa-spinner animate-spin text-4xl text-blue"></i>
                            <p class="text-lg text-gray-600 mt-2 animate-pulse">Loading...</p>
                        </div>
                    @else
                        <div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-2 items-center">




                                <!-- Profile Picture Section -->
                                <div x-data="{ isProfileOpen: false }" class="relative">
                                    <label class="font-medium text-gray-700">Profile Picture</label>
                                    <img @click="isProfileOpen = !isProfileOpen"
                                        class="w-3/4 h-44 object-cover rounded-lg cursor-pointer"
                                        src="{{ $profile_picture && file_exists(public_path('storage/' . $profile_picture))
                                            ? asset('storage/' . $profile_picture)
                                            : asset('assets/images/no-image.jpg') }}"
                                        alt="Profile Picture" />

                                    <!-- Profile Picture Popup -->
                                    <div x-show="isProfileOpen"
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div @click.away="isProfileOpen = false"
                                            class="bg-white p-4 rounded-lg shadow-lg relative">
                                            <button @click="isProfileOpen = false"
                                                class="absolute top-2 right-2 bg-red-500 text-white py-1 px-2 rounded-full">
                                                X
                                            </button>
                                            <img class="w-96 h-96 object-cover rounded-lg"
                                                src="{{ $profile_picture && file_exists(public_path('storage/' . $profile_picture))
                                                    ? asset('storage/' . $profile_picture)
                                                    : asset('assets/images/no-image.jpg') }}"
                                                alt="Profile Picture" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Valid ID Section -->
                                <div x-data="{ isIdOpen: false }" class="relative">
                                    <label class="font-medium text-gray-700">Valid ID</label>
                                    <img @click="isIdOpen = !isIdOpen"
                                        class="w-3/4 h-44 object-cover rounded-lg cursor-pointer"
                                        src="{{ $valid_id && file_exists(public_path('storage/' . $valid_id))
                                            ? asset('storage/' . $valid_id)
                                            : asset('assets/images/no-image.jpg') }}"
                                        alt="Valid ID" />

                                    <!-- Valid ID Popup -->
                                    <div x-show="isIdOpen"
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div @click.away="isIdOpen = false"
                                            class="bg-white p-4 rounded-lg shadow-lg relative">
                                            <button @click="isIdOpen = false"
                                                class="absolute top-2 right-2 bg-red-500 text-white py-1 px-2 rounded-full">
                                                X
                                            </button>
                                            <img class="w-96 h-96 object-cover rounded-lg"
                                                src="{{ $valid_id && file_exists(public_path('storage/' . $valid_id))
                                                    ? asset('storage/' . $valid_id)
                                                    : asset('assets/images/no-image.jpg') }}"
                                                alt="Valid ID" />
                                        </div>
                                    </div>
                                </div>








                                <form class="space-y-4">
                                    <h2 class="font-medium">Reset User Password</h2>


                                    <div class="space-y-2">


                                        <div x-data="{ showPassword: false }" class="pb-2">
                                            <label
                                                class="block text-start text-sm font-medium text-gray">Password</label>

                                            <!-- Password Input -->
                                            <div class="relative w-3/5">
                                                <input :type="showPassword ? 'text' : 'password'" wire:model="password"
                                                    class="w-full pl-3 pr-10 py-1 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
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
                                            <label class="block text-start text-sm font-medium text-gray">Password
                                                Confirmation</label>

                                            <!-- Password Input -->
                                            <div class="relative w-3/5">
                                                <input :type="showPassword ? 'text' : 'password'" wire:model="password"
                                                    class="w-full pl-3 pr-10 py-1 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
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





                                    </div>

                                    @adminOrSuperAdmin
                                        <div class=" flex justify-start items-center pt-2">
                                            <button wire:click.prevent="ChangePassword"
                                                class="px-5 py-2 bg-blue text-white rounded-lg hover:bg-opacity-90 transition text-xs"
                                                id="closeModalBtn">
                                                Update Password
                                            </button>
                                        </div>
                                    @endadminOrSuperAdmin



                                </form>
                            </div>

                        </div>



                        <form class="">
                            <div class="mt-4 grid grid-cols-1 lg:grid-cols-3 gap-8 text-gray-700">


                                <div>
                                    <label class="font-medium text-gray-700">First name</label>
                                    <input type="text" wire:model="first_name"
                                        class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                                    id="first_name" @adminOrSuperAdmin @else disabled
                                    @endadminOrSuperAdmin>
                            </div>

                            <div>
                                <label class="font-medium text-gray-700">Last Name</label>
                                <input type="text" wire:model="last_name"
                                    class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                                id="last_name" @adminOrSuperAdmin @else disabled
                                @endadminOrSuperAdmin>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">Email</label>
                            <input type="text" wire:model="email"
                                class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                            id="email" @adminOrSuperAdmin @else disabled
                            @endadminOrSuperAdmin>
                    </div>



                    <div>
                        <label class="font-medium text-gray-700">Balance</label>
                        <input type="text" wire:model="balance"
                            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="phone" @adminOrSuperAdmin @else disabled
                        @endadminOrSuperAdmin>
                </div>



                <div>
                    <label class="font-medium text-gray-700">Status</label>
                    <input type="text" wire:model="status"
                        class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                    id="created_at" @adminOrSuperAdmin @else disabled
                    @endadminOrSuperAdmin>
            </div>

            <div>
                <label class="font-medium text-gray-700">Account Number</label>
                <input type="text" wire:model="account_number" readonly
                    class="w-full px-3 py-2 border rounded-md bg-lightGray text-gray-600"
                    id="created_at" readonly>
            </div>


            <div>
                <label class="font-medium text-gray-700">Phone</label>
                <input type="text" wire:model="phone"
                    class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                id="created_at" @adminOrSuperAdmin @else disabled
                @endadminOrSuperAdmin>
        </div>
        <div>
            <label class="font-medium text-gray-700">Address</label>
            <input type="text" wire:model="address"
                class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
            id="created_at" @adminOrSuperAdmin @else disabled
            @endadminOrSuperAdmin>
    </div>
    <div>
        <label class="font-medium text-gray-700">Company Name</label>
        <input type="text" wire:model="company_name"
            class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
        id="created_at" @adminOrSuperAdmin @else disabled
        @endadminOrSuperAdmin>
</div>
<div>
    <label class="font-medium text-gray-700">Last OTP</label>
    <input type="text" wire:model="otp"
        class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
        id="created_at">
</div>
<div>
    <label class="font-medium text-gray-700">OTP EXpiration</label>
    <input type="text" wire:model="otp_expiration"
        class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
    id="created_at" @adminOrSuperAdmin @else disabled
    @endadminOrSuperAdmin>
</div>
<div>
<label class="font-medium text-gray-700">SMS Rate</label>
<input type="text" wire:model="sms_rate"
    class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
id="created_at" @adminOrSuperAdmin @else disabled
@endadminOrSuperAdmin>
</div>

</div>

@adminOrSuperAdmin
<div class=" flex justify-start items-center pt-6">
<button class="px-5 py-2 bg-blue text-white rounded-lg hover:bg-opacity-90 transition"
id="closeModalBtn">
Update Profile
</button>
</div>
@endadminOrSuperAdmin
</form>
@endif







</div>
