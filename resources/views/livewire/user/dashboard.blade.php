<div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between mb-4" wire:init='getBalance'>
                <div>
                    <div class="flex items-center mb-1">
                        @if (!isset($accountBalance))
                            <!-- Check if balance is not set or loading -->
                            <div class="flex justify-center items-center space-x-2">
                                <i class="fa-solid fa-spinner animate-spin text-lg text-blue-500"></i>
                                <p class="text-md text-gray-600 animate-pulse">Loading...</p>
                            </div>
                        @else
                            <div
                                class="text-2xl font-semibold {{ $accountBalance < 500 ? 'text-red-600 animate-pulse' : 'text-green-600' }}">
                                ₦ {{ number_format($accountBalance, 2, '.', ',') }}
                            </div>
                        @endif
                    </div>


                    <div class="text-sm font-medium text-gray-400">Balance</div>
                </div>
                <div class="dropdown">
                    <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i
                            class="ri-more-fill"></i></button>
                    <ul
                        class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                        <li>
                            <a href="#"
                                class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between mb-4">
                <div>
                    <div class="flex items-center mb-1">
                        @if (!isset($messageCount))
                            <!-- Check if messageCount is not set (loading) -->
                            <div class="flex justify-center items-center space-x-2">
                                <i class="fa-solid fa-spinner animate-spin text-lg text-blue-500"></i>
                                <p class="text-md text-gray-600 animate-pulse">Loading...</p>
                            </div>
                        @else
                            <div class="text-2xl font-semibold">{{ $messageCount }}</div>
                        @endif
                    </div>

                    <div class="text-sm font-medium text-gray-400">Total Send Message</div>
                </div>
                <div class="dropdown">
                    <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i
                            class="ri-more-fill"></i></button>
                    <ul
                        class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                        <li>
                            <a href="#"
                                class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="/dierenartsen" class="text-[#f84525] font-medium text-sm hover:text-red-800">View</a>
        </div>



        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5" wire:init="getAllGroups">
            <div class="flex justify-between mb-4">
                <div>


                    <div class="flex items-center mb-1">
                        @if (!isset($groupCount))
                            <!-- Check if groupCount is not set (loading) -->
                            <div class="flex justify-center items-center space-x-2">
                                <i class="fa-solid fa-spinner animate-spin text-lg text-blue-500"></i>
                                <p class="text-md text-gray-600 animate-pulse">Loading...</p>
                            </div>
                        @else
                            <div class="text-2xl font-semibold">{{ $groupCount }}</div>
                            <div
                                class="p-1 rounded bg-emerald-500/10 text-emerald-500 text-[12px] font-semibold leading-none ml-2">
                                <!-- You can add any other label if needed here -->
                            </div>
                        @endif
                    </div>

                    {{-- <div class="flex items-center mb-1">
                        <div class="text-2xl font-semibold">{{ $groupCount }}</div>
                        <div
                            class="p-1 rounded bg-emerald-500/10 text-emerald-500 text-[12px] font-semibold leading-none ml-2">
                            </div>
                    </div> --}}
                    <div class="text-sm font-medium text-gray-400">Number of Phone Groups</div>
                </div>
                <div class="dropdown">
                    <button type="button" class="dropdown-toggle text-gray-400 hover:text-gray-600"><i
                            class="ri-more-fill"></i></button>
                    <ul
                        class="dropdown-menu shadow-md shadow-black/5 z-30 hidden py-1.5 rounded-md bg-white border border-gray-100 w-full max-w-[140px]">
                        <li>
                            <a href="#"
                                class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Profile</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Settings</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
            <a href="/dierenartsen" class="text-[#f84525] font-medium text-sm hover:text-red-800">View</a>
        </div>
    </div>



    <div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2" wire:init="getRecentMessage">
        <h3 class="font-bold text-2xl">Recent Messages</h3>
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead>
                            <tr class="bg-blue text-white">
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-28">
                                    Message ID</th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                    Title</th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                    Destination</th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">
                                    Message</th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-12">
                                    Page</th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-24">
                                    Rate</th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-24">
                                    Amount</th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-24">
                                    Status</th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">
                                    Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($allMessage === null)
                                <!-- Loader placed inside the table body -->
                                <tr>
                                    <td colspan="9" class="text-center py-6">
                                        <i class="fa-solid fa-spinner animate-spin text-4xl text-blue-500"></i>
                                        <p class="text-xl text-gray-600 mt-2 animate-pulse">Loading...</p>
                                    </td>
                                </tr>
                            @elseif ($allMessage->isEmpty())
                                <!-- If no messages found -->
                                <tr>
                                    <td colspan="9" class="px-4 py-4 text-center text-sm text-gray">
                                        No recent Messages
                                    </td>
                                </tr>
                            @else
                                <!-- Display messages if available -->
                                @foreach ($allMessage as $item)
                                    <tr class="odd:bg-white even:bg-gray-100">
                                        <td class="px-4 py-4 whitespace-normal text-sm font-medium text-gray">
                                            {{ substr($item->message_id, 0, 8) }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">{{ $item->sender }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $item->destination }}</td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray break-words">
                                            {{ substr($item->message, 0, 20) }}
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $item->page_number }}</td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $item->page_rate }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">{{ $item->amount }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">{{ $item->status }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $item->created_at }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>






    <div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2" wire:init="allRecentPayment">
        <h3 class="font-bold text-2xl">Latest Payment</h3>

        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                        <thead>
                            <tr class="bg-blue text-white">
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-28">
                                    Tranx ID
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                    Reference
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                    Amount
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-36">
                                    Payment type
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                    Status
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">
                                    Date
                                </th>
                                <th scope="col" class="px-4 py-3 text-start text-xs font-semibold uppercase w-24">
                                    Currency
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$allPayment)
                                <!-- Loader Row Below the Header -->
                                <tr>
                                    <td colspan="9" class="text-center py-6">
                                        <i class="fa-solid fa-spinner animate-spin text-4xl text-blue-500"></i>
                                        <p class="text-xl text-gray-600 mt-2 animate-pulse">Loading...</p>
                                    </td>
                                </tr>
                            @elseif ($allPayment->isEmpty())
                                <!-- No Payment Row Below the Header -->
                                <tr>
                                    <td colspan="9" class="px-4 py-4 text-center text-sm text-gray">
                                        No recent payment
                                    </td>
                                </tr>
                            @else
                                <!-- Display Payments -->
                                @foreach ($allPayment as $payment)
                                    <tr class="odd:bg-white even:bg-gray-100">
                                        <td class="px-4 py-4 whitespace-normal text-sm font-medium text-gray">
                                            {{ $payment->transaction_id }}</td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $payment->reference }}</td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $payment->amount }}</td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $payment->payment_type }}</td>
                                        <td
                                            class="px-4 py-4 whitespace-normal text-sm
                                        @if ($payment->status == 'success') text-green-600
                                        @elseif($payment->status == 'failed') text-red-600
                                        @else text-gray-600 @endif">
                                            {{ $payment->status }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $payment->created_at }}</td>
                                        <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                            {{ $payment->currency }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



</div>
