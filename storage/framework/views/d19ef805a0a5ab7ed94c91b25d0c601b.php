<div wire:poll.1000ms>
    <div class="pt-4 pb-10 px-6 flex justify-between items-center">
        <h3 class="font-bold text-2xl">All Schedules</h3>
        <a href="<?php echo e(route('schedule')); ?>" wire:navigate.hover
            class="mt-6 px-5 py-2.5 rounded-lg text-white text-xs tracking-wider font-medium border-none outline-none bg-blue hover:opacity-90">
            Add Schedule
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">


        <!--[if BLOCK]><![endif]--><?php if($allSchedule->isEmpty()): ?>
            <p class="text-center text-gray-500 text-sm">No scheduled messages yet.</p>
        <?php else: ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allSchedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $statusColor = match ($item['status']) {
                        'pending' => 'bg-yellow-500',
                        'sent' => 'bg-green-500',
                        'failed' => 'bg-red-500',
                        default => 'bg-gray-500',
                    };
                ?>
                <div class="relative p-6 text-center shadow-sm bg-white space-y-3 rounded-lg">
                    <h3 class="text-lg font-medium"><?php echo e($item['description']); ?></h3>
                    <p class="text-textPrimary font-light text-sm leading-relaxed"></p>
                    <div class="pt-3 flex justify-center items-center gap-2">
                        
                        <button type="button" wire:click.prevent="cancelSchedule(<?php echo e($item['id']); ?>)"
                            class="mt-6 px-5 py-2 w-full rounded-lg text-white text-xs tracking-wider font-light border-none outline-none bg-red-600 hover:opacity-90">Cancel</button>
                    </div>
                    <span
                        class="block absolute top-0 right-4 <?php echo e($statusColor); ?> text-white py-1 px-2 rounded-lg text-[12px]">
                        <?php echo e($item['status']); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


    </div>

      <div class="mt-12">
        <?php echo e($allSchedule->links()); ?>

    </div>


</div>
<?php /**PATH /home/victor/Documents/GGT/sms/resources/views/livewire/user/schedule-sms-view.blade.php ENDPATH**/ ?>