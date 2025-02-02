<div class="w-full max-w-4xl bg-white shadow-lg rounded-lg p-12 relative">
    <div class="flex items-center">
        <h3 class="text-bg-blue text-xl font-bold flex-1">SMS Analysis Summary</h3>
        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-3 ml-2 cursor-pointer shrink-0 fill-gray-400 hover:fill-red-500"
             viewBox="0 0 320.591 320.591">
            <path
                d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
                data-original="#000000"></path>
            <path
                d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
                data-original="#000000"></path>
        </svg>
    </div>

    <form class="space-y-4 pt-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-8">
            <div class="text-textPrimary font-light space-y-1 flex flex-col items-center justify-center">
                <h4 class="font-semibold text-2xl">#1506.00</h4>
                <p class="text-sm text-softGray uppercase">cost</p>
            </div>
            <div class="text-textPrimary font-light space-y-1 flex flex-col items-center justify-center">
                <h4 class="font-semibold text-2xl">3</h4>
                <p class="text-sm text-softGray uppercase">Recipients</p>
            </div>
            <div class="text-textPrimary font-light space-y-1 flex flex-col items-center justify-center">
                <h4 class="font-semibold text-2xl">1</h4>
                <p class="text-sm text-softGray uppercase">Page</p>
            </div>
        </div>

        <div class="pt-8">
            <label class="text-gray-800 text-sm mb-2 block">Sender</label>
            <input type="text" autocomplete="off" wire:model="name"
                   class="w-1/4 px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                   placeholder="Sender">
        </div>

        <div>
            <label class="text-gray-800 text-sm mb-2 block">Phone</label>
            <textarea autocomplete="off" wire:model="name"
                      class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                      placeholder="Sender"></textarea>
        </div>

        <div>
            <label class="text-gray-800 text-sm mb-2 block">Text</label>
            <textarea autocomplete="off" wire:model="name"
                      class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                      placeholder="Sender"></textarea>
        </div>

        <div class="pt-4 text-center" wire:click.prevent="sendMessage">
            <button class="bg-blue ms:w-full py-3 px-12 rounded-lg text-white text-base">
                Send Message
            </button>
        </div>
    </form>
</div>
