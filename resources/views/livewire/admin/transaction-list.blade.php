<div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
    <div class="flex justify-between items-center">
        <h3 class="font-bold text-2xl">All Transactions</h3>

        <!-- Search Input Field -->
        <input type="text" wire:model.live.debounce.50ms="search" placeholder="Search by GL Number, Amount, Ref"
            class="px-4 py-2 border rounded-md bg-gray-100 text-gray-600 w-64 placeholder:text-xs">

        @adminOrSuperAdmin
            {{-- <button wire:click.prevent="addModal" type="button" class="text-sm text-white rounded-lg py-2 px-8 bg-blue">Add
            Ledger</button> --}}
        @endadminOrSuperAdmin
    </div>

    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead>
                        <tr class="bg-blue text-white">
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">GL Number</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">User</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Amount</th>

                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Tranx Reference</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Tranx Type</th>

                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Status</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Date</th>
                            @adminOrSuperAdmin
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Action</th>
                            @endadminOrSuperAdmin
                        </tr>
                    </thead>

                    <tbody>
                        @if ($transactions->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-600">No Payment Found</td>
                            </tr>
                        @else
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $transaction->ledger->account_number }}
                                    </td>

                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">

                                        @if ($transaction->user)
                                            {{ $transaction->user->email }}
                                        @else
                                            {{ $transaction->admin->email }}
                                        @endif

                                    </td>

                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $transaction['amount'] }}
                                    </td>


                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ Str::limit($transaction['reference'], 10, '..') }}
                                    </td>

                                      <td
                                        class="px-4 py-4 whitespace-normal text-sm 
                                        @if ($transaction['transaction_type'] == 'credit') text-green-600 
                                        @elseif($transaction['transaction_type'] == 'debit') text-red-600 
                                        @elseif($transaction['transaction_type'] == 'failed') text-yellow-600 
                                        @else text-gray-600 @endif">
                                        {{ ucfirst($transaction['transaction_type']) }}
                                    </td>

                                    <td
                                        class="px-4 py-4 whitespace-normal text-sm 
                                        @if ($transaction['status'] == 'success') text-green-600 
                                        @elseif($transaction['status'] == 'failed') text-red-600 
                                        @elseif($transaction['status'] == 'pending') text-yellow-600 
                                        @else text-gray-600 @endif">
                                        {{ ucfirst($transaction['status']) }}
                                    </td>

                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        {{ $transaction['created_at'] }}
                                    </td>
                                    @adminOrSuperAdmin
                                        <td class="px-4 py-4 whitespace-normal flex items-center gap-2">
                                            <button type="button"
                                                wire:click.prevent="viewTransaction({{ $transaction['id'] }})"
                                                class="bg-blue py-2 px-2 text-sm text-white rounded-lg cursor-pointer">
                                                View
                                            </button>
                                        </td>
                                    @endadminOrSuperAdmin
                                </tr>
                            @endforeach
                        @endif
                    </tbody>


                </table>
            </div>
        </div>
    </div>


    <div class="py-8">
        {{ $transactions->links() }}
    </div>

    @if ($viewModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
            <div
                class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-screen sm:w-[600px] lg:w-[600px] xl:w-[1000px] max-w-6xl">
                <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                    <h3 class="text-2xl font-bold">Transaction Details</h3>
                    <button class="text-black text-2xl" type="button" wire:click.prevent="closeModal">
                        <i class="fas fa-times hover:text-red-600"></i>
                    </button>
                </div>

                <form class="mt-4 text-gray-700 space-y-6 pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <div>
                            <label class="font-medium text-gray-700">Legder Name</label>
                            <input type="text" wire:model="ledgerName"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            <span class="text-sm text-red-600 block text-start italic pt-1"></span>
                        </div>


                        <div>
                            <label class="font-medium text-gray-700">Ledger Account Number</label>
                            <input wire:model="ledgerNumber" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            <span class="text-sm text-red-600 block text-start italic pt-1"></span>
                        </div>


                        <div>
                            <label class="font-medium text-gray-700">Ledger Available Balance</label>
                            <input wire:model="ledgerBalance" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            <span class="text-sm text-red-600 block text-start italic pt-1"></span>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">User Email</label>
                            <input wire:model="email" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            <span class="text-sm text-red-600 block text-start italic pt-1"></span>
                        </div>


                        <div>
                            <label class="font-medium text-gray-700">Amount</label>
                            <input wire:model="amount" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            <span class="text-sm text-red-600 block text-start italic pt-1"></span>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">Transaction Type</label>
                            <input wire:model="transaction_type" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            <span class="text-sm text-red-600 block text-start italic pt-1"></span>
                        </div>





                        <div>
                            <label class="font-medium text-gray-700">Balance before</label>
                            <input wire:model="balanceBefore" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            <span class="text-sm text-red-600 block text-start italic pt-1"></span>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">Balance After</label>
                            <input wire:model="balanceAfter" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            <span class="text-sm text-red-600 block text-start italic pt-1"></span>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">Transaction Method</label>
                            <input wire:model="transaction_method" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            <span class="text-sm text-red-600 block text-start italic pt-1"></span>
                        </div>

                        <div>
                            <label class="font-medium text-gray-700">Reference Number</label>
                            <input wire:model="reference" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            <span class="text-sm text-red-600 block text-start italic pt-1"></span>
                        </div>


                        <div>
                            <label class="font-medium text-gray-700">Status</label>
                            <input wire:model="status" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            <span class="text-sm text-red-600 block text-start italic pt-1"></span>
                        </div>




                        <div>
                            <label class="font-medium text-gray-700">Date</label>
                            <input wire:model="date" type="text"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                            <span class="text-sm text-red-600 block text-start italic pt-1"></span>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    @endif





</div>
