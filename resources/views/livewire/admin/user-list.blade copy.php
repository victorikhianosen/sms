<div>

    <div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2" >
        <h3 class="font-bold text-2xl">All Users</h3>
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead>
                            <tr class="bg-blue text-white">
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-28">First Name</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Last Nme</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Email</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">phone Number</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-12">Balance</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-24">Status</th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Account Number
                                </th>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase">Action</th>
                            </tr>
                        </thead>
                        {{-- @if (!$allUsers) --}}


                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fa-solid fa-spinner animate-spin text-4xl text-blue-500"></i>
                                        <p class="text-lg text-gray-600 mt-2 animate-pulse">Loading...</p>
                                    </td>
                                </tr>
                            </tbody>
                        {{-- @else --}}
                            <tbody>

                                {{-- @if (!empty($allUsers) && count($allUsers) > 0) --}}
                                    @foreach ($allUsers as $item)
                                        <tr class="odd:bg-white even:bg-gray-100">
                                            <td class="px-4 py-4 whitespace-normal text-sm font-medium text-gray">
                                                {{ $item->first_name }}</td>
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                                {{ $item->last_name }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                                {{ $item->email }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray break-words">
                                                {{ $item['phone'] }}</td>
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                                {{ $item->balance }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                                {{ $item->status }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                                {{ $item->account_number }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-normal flex items-center gap-2">
                                             
                                                <a href="{{ route('admin.userdetails', $item->id) }}" wire:navigate.hover type="button"
                                                    class="bg-blue py-2 px-2 text-white rounded-lg cursor-pointer">
                                                    View
                                                </a>
                                          
                                            </td>
                                        </tr>
                                    @endforeach
                                {{-- @else --}}
                                    <tr>
                                        <td colspan="8" class="text-center py-4">No users found</td>
                                    </tr>
                                {{-- @endif --}}

                            </tbody>

                        {{-- @endif --}}
                    </table>
                </div>
            </div>
        </div>
    </div>







    {{-- <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" id="modal">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-5xl p-6 relative">
            <!-- Close Button (Top Right) -->
            <button class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 transition" id="closeModal">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Modal Header -->
            <h3 class="text-2xl font-semibold text-gray-900 border-b pb-3">User Details</h3>

            <!-- Modal Body -->
            <div class="mt-4 grid grid-cols-2 lg:grid-cols-3 gap-4 text-gray-700">
                <div>
                    <label class="font-medium text-gray-700">First name</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="first_name" readonly>
                </div>

                <div>
                    <label class="font-medium text-gray-700">Last Name</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="last_name" readonly>
                </div>

                <div>
                    <label class="font-medium text-gray-700">Email</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="email" readonly>
                </div>

                <div>
                    <label class="font-medium text-gray-700">Balance</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="phone" readonly>
                </div>

                <div>
                    <label class="font-medium text-gray-700">Last Payment Reference</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="amount" readonly>
                </div>

                <div>
                    <label class="font-medium text-gray-700">Status</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="created_at" readonly>
                </div>

                <div>
                    <label class="font-medium text-gray-700">Account Number</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="created_at" readonly>
                </div>


                <div>
                    <label class="font-medium text-gray-700">Phone</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="created_at" readonly>
                </div>
                <div>
                    <label class="font-medium text-gray-700">Address</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="created_at" readonly>
                </div>
                <div>
                    <label class="font-medium text-gray-700">Company Name</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="created_at" readonly>
                </div>
                <div>
                    <label class="font-medium text-gray-700">Last OTP</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="created_at" readonly>
                </div>
                <div>
                    <label class="font-medium text-gray-700">OTP EXpiration</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="created_at" readonly>
                </div>
                <div>
                    <label class="font-medium text-gray-700">SMS Rate</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="created_at" readonly>
                </div>
                <div>
                    <label class="font-medium text-gray-700">Profile Picture</label>
                    <input type="file" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="created_at" readonly>
                </div>

                <div>
                    <label class="font-medium text-gray-700">Valid ID</label>
                    <input type="file" class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-600"
                        id="created_at" readonly>
                </div>
            </div>


            <!-- Modal Footer with Close Button -->
            <div class="mt-6 flex justify-end">
                <button class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
                    id="closeModalBtn">
                    Close
                </button>
            </div>
        </div>
    </div> --}}


</div>







{{-- Response --}}
{{-- "id" => 2
          "first_name" => "John"
          "last_name" => "Matthew"
          "email" => "John@gmail.com"
          "api_key" => "TRIX_ZGsRwv5QNtTS4wRoeFrkSvzWMzcnlN3P"
          "api_secret" => "TRIX_SECRET_44a8oVkiMR63FbWM7jWoM6qdv6PEvXvk"
          "email_verified_at" => null
          "password" => "$2y$12$USjP9tDdw3qWUDuw2PKKjO8mCTx9GQGqbE/YtWkWVeXUoGRx.zAgK"
          "balance" => "0.00"
          "last_payment_reference" => null
          "status" => "active"
          "profile_picture" => null
          "valid_id" => null
          "account_number" => null
          "phone" => "94303030303"
          "address" => null
          "company_name" => null
          "otp" => null
          "otp_expired_at" => null
          "sms_rate" => "3.00"
          "sms_char_limit" => "150"
          "remember_token" => null
          "created_at" => "2025-02-11 09:59:13"
          "updated_at" => "2025-02-11 09:59:13" --}}
