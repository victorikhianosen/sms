<div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
    <div class="flex justify-between items-center">
        <h3 class="font-bold text-2xl">Exchange Accounts</h3>

        {{-- <button --}}
        {{-- class="bg-blue py-1 px-4 text-white rounded-lg cursor-pointer text-sm"></button> --}}
    </div>
    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead>
                        <tr class="bg-blue text-white">
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Name</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Username</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Rate</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Available Unit</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Balance</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Status</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Actions</th>

                        </tr>
                    </thead>


                    <tbody>
                        @if ($exchanges->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-600">No Payment Found</td>
                            </tr>
                        @else
                            @foreach ($exchanges as $item)
                                <tr>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $item['name'] }}
                                    </td>

                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $item['username'] }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $item['rate'] }}
                                    </td>

                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $item['available_unit'] }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        ₦{{ number_format($item['available_balance'], 2) }}
                                    </td>

                                    <td
                                        class="px-4 py-4 whitespace-normal text-sm 
                                        @if ($item['status'] == 'success') text-green-600 
                                        @elseif($item['status'] == 'failed') text-red-600 
                                        @elseif($item['status'] == 'pending') text-yellow-600 
                                        @else text-gray-600 @endif">
                                        {{ ucfirst($item['status']) }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <button wire:click.prevent="showAddFund({{ $item->id }})"
                                            class="bg-green-600 text-sm py-2 px-2 text-white rounded-lg cursor-pointer">
                                            Funds
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>

                </table>
            </div>
        </div>
    </div>


    <div class="py-8">
        {{-- {{ $payments->links() }} --}}
    </div>




    @if ($fundModel)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
            <div
                class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-screen sm:w-[600px] lg:w-[600px] xl:w-[1000px] max-w-3xl">
                <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                    <h3 class="text-2xl font-bold">Add Fund</h3>
                    <button class="text-black text-2xl" wire:click="closeModal">
                        <i class="fas fa-times hover:text-red-600"></i>
                    </button>
                </div>

                <form class="mt-4 text-gray-700 space-y-6 pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="font-medium text-gray-700">Name</label>
                            <input type="text" wire:model="name"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>


                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Username</label>
                            <input type="text" wire:model="username"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>


                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Available Balance</label>
                            <input type="text" wire:model="available_balance"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>

                        </div>


                        <div>
                            <label class="font-medium text-gray-700">Amount to Deposit</label>
                            <input type="text" wire:model="amount" maxlength="11"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600">
                            @error('amount')
                                <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-6 flex justify-start pt-4 space-x-4">



                        <button type="submit" wire:loading.remove wire:click.prevent="FundAccount({{ $exchangeId }})"
                            class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                            Fund Account
                        </button>

                        <button type="submit" wire:loading wire:target="FundAccount"
                            class="w-full bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                            <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                        </button>

                    </div>
                </form>
            </div>
        </div>
    @endif




</div>
