<?php $__env->startSection('content'); ?>
<div id="head">
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/JScomponents/app/bar.js'); ?>
</div>
<div id="container" class="d-flex m-0">
    <aside>
        <?php echo app('Illuminate\Foundation\Vite')('resources/js/JScomponents/app/aside.js'); ?>
    </aside>
    <script>
        window.user = {
            id: <?php echo e($User->id); ?>,
            image: '<?php echo e($User->photo); ?>',
            first_name: '<?php echo e($User->first_name); ?>',
            last_name: '<?php echo e($User->last_name); ?>',
            email: '<?php echo e($User->email); ?>',
            phone: '<?php echo e($User->phone); ?>',
            photo: '<?php echo e($User->photo); ?>',
            courses_sub: <?php echo json_encode(json_decode($User->courses_sub), 15, 512) ?>,
            courses_end: <?php echo json_encode(json_decode($User->courses_end), 15, 512) ?>,
            category: '<?php echo e($User->category); ?>',
            links: <?php echo json_encode(json_decode($User->links), 15, 512) ?>,
            projects: <?php echo json_encode(json_decode($User->projects), 15, 512) ?>
        };
    </script>
    <main style="flex: 3.5">
        <?php echo $__env->yieldContent('content2'); ?>
    </main>
</div>
<?php if($errors->any()): ?>
    <?php
        $arrErr = [];
    ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $arrErr[] = $error;
        ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <script>
        window.errors = <?php echo json_encode(json_encode($arrErr), 15, 512) ?>
    </script>
<?php endif; ?>

<?php if(session('message')): ?>
    <script>
        window.message = '<?php echo e(session('message')); ?>'
    </script>
<?php endif; ?>

<?php if(session('done')): ?>
    <script>
        window.done = '<?php echo e(session('done')); ?>'
    </script>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/brittany/Desktop/Courses/Programming/Full-Stack/APPs/viteApp/resources/views/layout/web.blade.php ENDPATH**/ ?>