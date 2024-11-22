<?php $__env->startSection('content2'); ?>

<?php echo app('Illuminate\Foundation\Vite')('resources/js/JScomponents/search.js'); ?>

<script>
    window.q = '<?php echo e($q); ?>';
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.web', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/brittany/Desktop/Courses/Programming/Full-Stack/APPs/viteApp/resources/views/search.blade.php ENDPATH**/ ?>