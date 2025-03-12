<div class="flex flex-col bg-white rounded-lg pt-8 mt-8 px-6 space-y-2">
    <div class="flex justify-between items-center">
        <h3 class="font-bold text-2xl">Schedule Message</h3>
    </div>

    <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead>
                        <tr class="bg-blue text-white">
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">User</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Sender</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Destination</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Amount</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Status</th>
                            <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-60">Date</th>

                            <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                <th class="px-4 py-3 text-start text-xs font-semibold uppercase w-40">Action</th>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tr>
                    </thead>

                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php if($allSchedule && $allSchedule->isEmpty()): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-600">No Payment Found</td>
                            </tr>
                        <?php else: ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allSchedule ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($schedule->user->email); ?>

                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($schedule->sender); ?>

                                    </td>
                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e(is_string($schedule->destination) ? count(json_decode($schedule->destination, true)) : (is_array($schedule->destination) ? count($schedule->destination) : 0)); ?>

                                    </td>

                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($schedule->amount); ?>

                                    </td>
                                    <td
                                        class="px-4 py-4 whitespace-normal text-sm 
                                        <?php if($schedule->status == 'sent'): ?> text-green-600 
                                        <?php elseif($schedule->status == 'failed'): ?> text-red-600 
                                        <?php elseif($schedule->status == 'pending'): ?> text-yellow-600 
                                        <?php elseif($schedule->status == 'cancel'): ?> text-gray-600 
                                        <?php else: ?> text-gray-600 <?php endif; ?>">
                                        <?php echo e(ucfirst($schedule->status)); ?>

                                    </td>

                                    <td class="px-4 py-4 whitespace-normal text-sm text-gray">
                                        <?php echo e($schedule->created_at); ?>

                                    </td>

                                    <!--[if BLOCK]><![endif]--><?php if (\Illuminate\Support\Facades\Blade::check('adminOrSuperAdmin')): ?>
                                        <td class="px-4 py-4 whitespace-normal flex items-center gap-2">
                                            <button type="button" wire:click.prevent="viewSchedule(<?php echo e($schedule->id); ?>)"
                                                class="bg-green-600 py-2 px-2 text-sm text-white rounded-lg cursor-pointer">
                                                View
                                            </button>

                                            <!--[if BLOCK]><![endif]--><?php if($schedule->status !== 'sent' && $schedule->status !== 'cancel'): ?>
                                                <!--[if BLOCK]><![endif]--><?php if($schedule->status !== 'pending'): ?>
                                                    <button type="button"
                                                        wire:click.prevent="PendSchedule(<?php echo e($schedule->id); ?>)"
                                                        class="bg-blue py-2 px-2 text-sm text-white rounded-lg cursor-pointer">
                                                        Pending
                                                    </button>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                                <button type="button"
                                                    wire:click.prevent="CancelSchedule(<?php echo e($schedule->id); ?>)"
                                                    class="bg-red-600 py-2 px-2 text-sm text-white rounded-lg cursor-pointer">
                                                    Cancel
                                                </button>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </td>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>

            <div class="py-8">
                <?php echo e($allSchedule->links()); ?>

            </div>
        </div>
    </div>


    <!--[if BLOCK]><![endif]--><?php if($showModal): ?>
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
            <div
                class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-screen sm:w-[600px] lg:w-[600px] xl:w-[1000px] max-w-6xl">
                <div class="flex justify-between items-center border-b-2 border-softGray pb-4">
                    <h3 class="text-2xl font-bold">Schedule Message Details</h3>
                    <button class="text-black text-2xl" wire:click="closeModal">
                        <i class="fas fa-times hover:text-red-600"></i>
                    </button>
                </div>
                <form class="mt-4 text-gray-700 space-y-6 pt-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Email -->
                        <div>
                            <label class="font-medium text-gray-700">Email</label>
                            <input type="text" value="<?php echo e($email); ?>"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Sender -->
                        <div>
                            <label class="font-medium text-gray-700">Sender</label>
                            <input type="text" value="<?php echo e($sender); ?>"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Description -->
                        <div>
                            <label class="font-medium text-gray-700">Description</label>
                            <input type="text" value="<?php echo e($description); ?>"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Page Number -->
                        <div>
                            <label class="font-medium text-gray-700">Page Number</label>
                            <input type="text" value="<?php echo e($page_number); ?>"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Page Rate -->
                        <div>
                            <label class="font-medium text-gray-700">Page Rate</label>
                            <input type="text" value="<?php echo e($page_rate); ?>"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Message -->
                        <div>
                            <label class="font-medium text-gray-700">Message</label>
                            <input type="text" value="<?php echo e($message); ?>"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Status -->
                        <div>
                            <label class="font-medium text-gray-700">Status</label>
                            <input type="text" value="<?php echo e($status); ?>"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Amount -->
                        <div>
                            <label class="font-medium text-gray-700">Amount</label>
                            <input type="text" value="<?php echo e($amount); ?>"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Destination Count -->


                        <div>
                            <label class="font-medium text-gray-700">Destination Count</label>
                            <input type="text"
                                value="<?php echo e($destination ? count(array_filter(explode(', ', $destination))) : 0); ?>"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>




                        <div>
                            <label class="font-medium text-gray-700">Route</label>
                            <input type="text" value="<?php echo e($route); ?>"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Scheduled Time -->
                        <div>
                            <label class="font-medium text-gray-700">Scheduled Time</label>
                            <input type="text" value="<?php echo e($scheduled_time); ?>"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                        <!-- Created At -->
                        <div>
                            <label class="font-medium text-gray-700">Created At</label>
                            <input type="text" value="<?php echo e($created_at); ?>"
                                class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600" readonly>
                        </div>
                    </div>



                    <div class="">
                        <label class="font-medium text-gray-700">Messages</label>
                        <textarea wire:model="message" readonly class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600"></textarea>
                    </div>



                    <div class="">
                        <label class="font-medium text-gray-700">Destination</label>
                        <textarea wire:model="destination" readonly class="w-full px-4 py-2 border rounded-md bg-gray-100 text-gray-600"></textarea>
                    </div>

                </form>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


</div>
<?php /**PATH /home/victor/Documents/GGT/sms/resources/views/livewire/admin/schedule-message-list.blade.php ENDPATH**/ ?>