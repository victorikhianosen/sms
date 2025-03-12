<div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
    <h3 class="font-bold text-2xl">API Documentation</h3>
    <div class="-m-1.5 overflow-x-auto pt-8">
        <div class="p-1.5 min-w-full inline-block align-middle space-y-8">

            <div class="space-y-4">
                <h2 class="text-xl text-blue font-semibold">Overview</h2>
                <div class="">
                    <p class="text-sm tracking-wide font-light text-textPrimary">
                        The sendsms API allows users to send SMS messages through the GGT Connect SMS gateway. Clients
                        must
                        provide valid credentials (API key and secret) to authenticate and send messages to a specified
                        phone number.
                    </p>
                </div>
            </div>




            <div class="space-y-4">
                <h2 class="text-xl text-blue font-semibold">API Credentials</h2>
                <div class="">


                    <form>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="pb-4 space-y-1">
                                <label class="block text-start text-sm font-medium text-gray">API Key</label>
                                <input type="text" autocomplete="off" wire:model.live="api_key" readonly
                                    class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue">

                                @error('email')
                                    <span
                                        class="text-sm text-red-600 block text-start italic pt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div x-data="{ showPassword: false }" class="pb-2 space-y-1">
                                <label class="block text-start text-sm font-medium text-gray">API Secret</label>

                                <!-- Password Input -->
                                <div class="relative">
                                    <input :type="showPassword ? 'text' : 'password'" wire:model.live="api_secret"
                                        class="w-full px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue"
                                        placeholder="**********" readonly>

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



                        <div class="pt-2">
                            <button wire:click.prevent="updateApiCredentials" wire:loading.remove
                                class="w-1/5 bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                Regenerate
                            </button>


                            <button type="submit" wire:loading wire:target="updateApiCredentials"
                                class="w-1/5 bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                            </button>
                        </div>

                    </form>
                </div>
            </div>




            <div class="space-y-4">
                <h2 class="text-xl text-blue font-semibold">Endpoint</h2>
                <div class="">
                    <h3 class="text-base text">
                        URL:
                    </h3>
                    <p class="text-xl tracking-wide text-textPrimary pt-3 font-semibold">
                        <span class="font-semibold pr-4">POST:</span> https://sms.assetmatrixmfb.com/api/sendsms
                    </p>
                </div>
            </div>



            <div class="space-y-4">
                <h2 class="text-xl text-blue font-semibold">Request Headers</h2>
                <div class="space-y-3">
                    <p class="text-sm tracking-wide font-light text-textPrimary">
                        Ensure that your request includes the following headers:

                    </p>
                    <div class="space-y-1">
                        <h3 class="text-base text">
                            Accept: application/json </h3>

                        <h3 class="text-base text">
                            Content-Type: application/json </h3>
                        </h3>
                    </div>
                </div>
            </div>





            <div class="space-y-4">
                <h2 class="text-xl text-blue font-semibold">Request Body</h2>
                <div class="">
                    <p class="text-sm tracking-wide font-light text-textPrimary">
                        The request body should be a JSON object containing the following parameters:
                    </p>

                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                <thead>
                                    <tr class="bg-blue text-white">
                                        <th scope="col"
                                            class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                            Parameter
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                            Type
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                            Required
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">
                                            Description
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="odd:bg-white even:bg-gray-100 border-b border-gray-300">
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">api_key</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">string</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">Yes</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">The API key provided
                                            for authentication.</td>
                                    </tr>
                                    <tr class="odd:bg-white even:bg-gray-100 border-b border-gray-300">
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">api_secret</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">string</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">Yes</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">The API secret
                                            provided for authentication.</td>
                                    </tr>
                                    <tr class="odd:bg-white even:bg-gray-100 border-b border-gray-300">
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">sender</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">string</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">Yes</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">The sender name that
                                            will appear on the recipient's phone number.</td>
                                    </tr>
                                    <tr class="odd:bg-white even:bg-gray-100 border-b border-gray-300">
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">phone_number</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">string</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">Yes</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">The recipient's phone
                                            number in local format.</td>
                                    </tr>
                                    <tr class="odd:bg-white even:bg-gray-100 border-b border-gray-300">
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">message</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">string</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">Yes</td>
                                        <td class="px-4 py-2 whitespace-normal text-sm text-gray">The text message
                                            content to be sent.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>




            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-blue-600">Request</h2>
                <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                    <!-- Use a preformatted block for Prism.js to highlight -->
                    <pre><code class="language-json">
{
    "api_key": "YkDOxQKqofdIF3jPGO8U73z6mz7qzGjj",
    "api_secret": "PAOxcBHL53mr2b96v4v7pqbMmSMHUu0J",
    "sender": "GGT Connect",
    "phone_number": "07033274155",
    "message": "Testing The API"
}
        </code></pre>
                </div>
            </div>

            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-blue-600">Response</h2>
                <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                    <p class="text-sm font-light text-gray-700">The API responds with a JSON object indicating success
                        or failure.</p>
                </div>

                <h3 class="text-lg font-semibold text-blue-500">Success Response</h3>
                <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                    <pre><code class="language-json">
{
  "status": "success",
  "message": "Message sent successfully",
  "data": {
    "message_id": "adfed204-d201-44d1-b9c0-8771d2981433"
  }
}
        </code></pre>
                </div>

                <h3 class="text-lg font-semibold text-blue-500">Error Responses</h3>
                <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                    <pre><code class="language-json">
{
  "status": "error",
  "message": "Invalid Sender ID"
}
        </code></pre>
                </div>
            </div>

        </div>
    </div>




    <div class="space-y-4">
        <h2 class="text-xl text-blue font-semibold">Note</h2>
        <div class="space-y-2 pb-8">
            <ul class="list-disc pl-6 text-sm tracking-wide font-light text-textPrimary">
                <li>Ensure that the API key and secret are kept secure.</li>
                <li>The sender name should be an approved name from the SMS provider.</li>
                <li>The phone number should be in the correct format.</li>
                <li>Delivery success depends on network conditions and recipient availability.</li>
            </ul>
        </div>

    </div>



    <div class="space-y-4 pb-24">
        <h2 class="text-xl text-blue font-semibold">Contact Support</h2>
        <div class="">
            <p class="text-sm tracking-wide font-light text-textPrimary">
                For any issues, contact GGT Connect API support at <span
                    class="font-semibold">support@ggtconnect.com</span>
            </p>
        </div>
    </div>



</div>
