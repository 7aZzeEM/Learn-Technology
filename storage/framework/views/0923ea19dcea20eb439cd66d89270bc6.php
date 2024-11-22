<?php $__env->startSection('content2'); ?>

<?php echo app('Illuminate\Foundation\Vite')('resources/js/JScomponents/watch.js'); ?>

<script>
    window.videos = <?php echo json_encode(json_decode($videos), 15, 512) ?>;
    window.course = '<?php echo e($Course); ?>'
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.web', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/brittany/Desktop/Courses/Programming/Full-Stack/APPs/viteApp/resources/views/watch.blade.php ENDPATH**/ ?>