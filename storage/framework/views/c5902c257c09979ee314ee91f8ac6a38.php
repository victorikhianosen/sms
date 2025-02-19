<div x-data="{ showModal: <?php if ((object) ('showModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showModal'->value()); ?>')<?php echo e('showModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('showModal'); ?>')<?php endif; ?> }">

    <div class="flex flex-col bg-white rounded-lg py-6 p-6 md:px-8">
        <div class="pt-4 pb-10 ">
            <h3 class="font-bold text-2xl ">Send SMS</h3>
        </div>
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-x-auto">
                    <form class="space-y-4">
                        <div class="">
                            <label class="block text-start text-base font-light text-textPrimary">Sender</label>
                            <select autocomplete="off" wire:model="sender"
                                class="w-full lg:w-2/5 px-3 py-4 border-2 text-sm border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue">
                                <option>Select a sender</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allSender; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item['name']); ?>"><?php echo e($item['name']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>

                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['sender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-sm text-red-600 block text-start italic pt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <div class="">
                            <label class="block text-start text-base font-light text-textPrimary">Message</label>
                            <textarea wire:model="message"
                                class="w-full lg:w-2/5 px-3 py-2 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue placeholder:text-sm"
                                placeholder="Enter your message" cols="20" rows="3"></textarea>

                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-sm text-red-600 block text-start italic pt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div x-data="{ phone_number: '' }">
                            <label class="block text-start text-base font-light text-textPrimary">Phone Number</label>
                            <input type="text" autocomplete="off" wire:model="phone_number" maxlength="11"
                                x-model="phone_number"
                                x-on:input="phone_number = phone_number.replace(/\D/g, '').slice(0, 11)"
                                class="w-full lg:w-2/5 px-3 py-4 border-2 border-softGray rounded-md focus:outline-none focus:ring-blue focus:border-blue placeholder:text-sm"
                                placeholder="Receiver's phone number">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-sm text-red-600 block text-start italic pt-1"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>


                        <div class="pt-6">
                            <button wire:click.prevent="Sendsms" wire:loading.remove
                                class="w-1/2 md:w-2/5 bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                 Send
                            </button>


                            <button type="submit" wire:loading wire:target="Sendsms"
                                class="w-1/2 md:w-2/5 bg-blue py-3 px-6 rounded-lg text-white transition-all duration-200 hover:opacity-90">
                                <i class="fa-solid fa-spinner animate-spin "></i> Loading...
                            </button>
                        </div>


                        
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    
</div>
<?php /**PATH C:\Users\HP\Documents\GGT\sms\resources\views/livewire/admin/admin-send-sms.blade.php ENDPATH**/ ?>