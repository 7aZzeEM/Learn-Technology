<?php $__env->startSection('content'); ?>

<div id="head">
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/JScomponents/admin/header/header.js'); ?>
</div>

<div id="container">
    <?php echo $__env->yieldContent('container'); ?>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/brittany/Desktop/Courses/Programming/Full-Stack/APPs/viteApp/resources/views/admin/layout/web.blade.php ENDPATH**/ ?>