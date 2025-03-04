<div x-data="{ showModal: @entangle('showModal') }">

    <div class="flex flex-col bg-white rounded-lg py-6 p-6 md:px-8">

        <div class="pt-4 pb-10 ">
            <h3 class="font-bold text-2xl ">Send Bulk SMS</h3>

        </div>

        {{-- @dd($sendersAll); --}}

        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">

                <div class="overflow-x-auto">



                    <form class="space-y-4" x-data="{ files: [] }">
                        <!-- Sender Field -->
                        <div>
                            <label class="block text-start text-base font-light text-textPrimary">Sender</label>
                            <select autocomplete="off" wire:model='sender'
                                class="w-full lg:w-2/5 px-3 py-3 border-2 text-sm border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue">
                                <option>Select a sender ID</option>
                                @foreach ($sendersAll as $item)
                                    <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>

                            @error('sender')
                                <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-start text-base font-light text-textPrimary">Send to Phone
                                Groups</label>
                            <select autocomplete="off" wire:model="group_numbers"
                                class="w-full lg:w-2/5 px-3 py-3 border-2 text-sm border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue">
                                <option>Select a Group</option>

                                @foreach ($allGroups as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>

                            @error('group_numbers')
                                <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                            @enderror
                        </div>


                        <div x-data="{ phoneNumbers: @entangle('phone_number') }">
                            <label class="block text-start text-base font-light text-textPrimary">Phone Numbers</label>
                            <textarea x-model="phoneNumbers"
                                class="w-full lg:w-2/5 px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue placeholder:text-sm"
                                placeholder="Enter phone numbers separated by a comma" cols="20" rows="3"
                                x-on:input="phoneNumbers = phoneNumbers.replace(/\D/g, '').replace(/(\d{11})(?=\d)/g, '$1, ').trim()"></textarea>

                            @error('phone_number')
                                <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                            @enderror
                        </div>



                        <div>
                            <label class="block text-start text-base font-light text-textPrimary">Message</label>
                            <textarea wire:model="message"
                                class="w-full lg:w-2/5 px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue placeholder:text-sm"
                                placeholder="Enter your message" cols="20" rows="3"></textarea>

                            @error('message')
                                <span class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pt-4">
                            <button wire:loading.remove wire:click.prevent="processBulkMessage"
                                class="bg-blue ms:w-full py-3 px-12 rounded-lg text-white text-base transition-all duration-200 hover:bg-opacity-90">
                                Process Message
                            </button>

                            <button type="button" wire:loading wire:target="processBulkMessage"
                                class="bg-blue ms:w-full py-3 px-12 rounded-lg text-white text-base transition-all duration-200 hover:bg-opacity-90">
                                <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    @if ($showModal)
        <div x-data="{ showModal: true }" x-show="showModal"
            class="fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif]">
            <!-- Modal container -->
            <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg p-12 relative">
                <!-- Modal header -->
                <div class="flex items-center">
                    <h3 class="text-bg-blue text-xl font-bold flex-1">SMS Summary Analysis</h3>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-3 ml-2 cursor-pointer shrink-0 fill-gray-400 hover:fill-red-500"
                        viewBox="0 0 320.591 320.591" @click="showModal = false; @this.closeModal()">
                        <path
                            d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                            data-original="#000000"></path>
                        <path
                            d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                            data-original="#000000"></path>
                    </svg>
                </div>

                <!-- Modal content -->
                <form class="space-y-4 pt-16">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-8">
                        <div class="text-textPrimary font-light space-y-1 flex flex-col items-center justify-center">
                            <h4 class="font-semibold text-2xl">₦{{ $totalCharge }}</h4>
                            <p class="text-sm text-softGray uppercase tracking-wider">cost</p>
                        </div>
                        <div class="text-textPrimary font-light space-y-1 flex flex-col items-center justify-center">
                            <h4 class="font-semibold text-2xl">{{ $numberCount }}</h4>
                            <p class="text-sm text-softGray uppercase tracking-wider">Recipients</p>
                        </div>
                        {{-- <div class="text-textPrimary font-light space-y-1 flex flex-col items-center justify-center">
                            <h4 class="font-semibold text-2xl">{{ $smsUnits }}</h4>
                            <p class="text-sm text-softGray uppercase">Page</p>
                        </div> --}}
                        <div class="text-textPrimary font-light space-y-1 flex flex-col items-center justify-center">
                            <h4 class="font-semibold text-2xl">{{ $smsUnits }}</h4>
                            <p class="text-sm text-softGray uppercase tracking-wider">
                                {{ $smsUnits > 1 ? 'Pages' : 'Page' }}
                            </p>
                        </div>

                    </div>

                    <div class="pt-8">
                        <label class="text-gray-800 text-sm mb-2 block">Sender</label>
                        <input type="text" autocomplete="off" wire:model="sender"
                            class="w-1/4 px-3 text-softGray py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                            placeholder="Sender" readonly />
                    </div>

                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Phone</label>
                        <textarea autocomplete="off" wire:model="numbersToSend"
                            class="w-full px-3 text-softGray py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                            placeholder="Phone" disabled></textarea>
                    </div>

                    <div>
                        <label class="text-gray-800 text-sm mb-2 block ">Text</label>
                        <textarea autocomplete="off" wire:model="message"
                            class="w-full px-3 py-2 text-softGray border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                            placeholder="Text" disabled></textarea>
                    </div>


                    <div class="pt-4 text-center">
                        <button type="submit" wire:loading.remove wire:click.prevent="sendBulkMessage" class="bg-blue ms:w-full py-3 px-12 rounded-lg text-white text-base">
                            Send Message
                        </button>

                        <button type="button" wire:loading wire:target="sendBulkMessage" class="bg-blue ms:w-full py-3 px-12 rounded-lg text-white text-base">
                            <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                        </button>


                    </div>
                </form>
            </div>
        </div>
    @endif


</div>
