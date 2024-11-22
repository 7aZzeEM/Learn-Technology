<?php $__env->startSection('content'); ?>

<?php echo app('Illuminate\Foundation\Vite')('resources/js/JScomponents/admin/head'); ?>

<div id="AdminApp">
    <?php echo $__env->yieldContent('cont'); ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/brittany/Desktop/Courses/Programming/Full-Stack/APPs/viteApp/resources/views/admin/head.blade.php ENDPATH**/ ?>