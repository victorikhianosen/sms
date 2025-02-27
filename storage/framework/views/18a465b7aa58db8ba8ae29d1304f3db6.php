<div x-data="{ copied: false }">
    <div class="pt-4 pb-6 px-6">
        <h3 class="font-bold text-2xl text-gray-800">Bank Transfer Payment</h3>
    </div>

    <div
        class="bg-gradient-to-r from-blue to-indigo w-full mx-auto px-4 lg:px-6 py-8 shadow-lg rounded-md flex flex-col md:flex-row gap-6 items-center">
        <div class="w-full md:w-full lg:pl-8">
            <div
                class="w-full max-w-md bg-gradient-to-r from-blue to-indigo text-white p-6 rounded-xl shadow-md relative">
                <!-- Copy Icon at Top Right -->
                <button @click="copyToClipboard(); clicked = true; setTimeout(() => clicked = false, 1000)"
                    :class="{ 'translate-x-2': clicked }"
                    class="absolute py-1 px-2 rounded-lg shadow-md top-4 right-4 bg-blue p-2 text-white flex items-center transition-all duration-200">
                    copy
                </button>

                <h2 class="text-2xl font-semibold mb-4 pb-4">Account Details</h2>
                <div class="space-y-2">
                    <p class="text-lg">
                        <span class="font-bold">Account Name:</span>
                        <span id="account-name"><?php echo e($firstName); ?> <?php echo e($lastName); ?></span>
                    </p>
                    <p class="text-lg flex items-center">
                        <span class="font-bold">Account Number:</span>
                        <span id="account-number"
                            class="ml-2 text-white bg-gray-800 px-3 py-1 rounded-md tracking-widest whitespace-nowrap">
                            <?php echo e($accountNumber); ?>

                        </span>
                    </p>
                    <p class="text-lg">
                        <span class="font-bold">Bank Name:</span>
                        <span id="bank-name">Asset Matrix MFB</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard() {
        const accountName = document.getElementById("account-name").innerText;
        const accountNumber = document.getElementById("account-number").innerText;
        const bankName = document.getElementById("bank-name").innerText;

        const fullDetails = `Account Name: ${accountName}\nAccount Number: ${accountNumber}\nBank Name: ${bankName}`;

        navigator.clipboard.writeText(fullDetails).then(() => {
            Alpine.store('copied', true);
            setTimeout(() => Alpine.store('copied', false), 2000);
        });
    }
</script>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/livewire/user/bank-transfer-payment.blade.php ENDPATH**/ ?>