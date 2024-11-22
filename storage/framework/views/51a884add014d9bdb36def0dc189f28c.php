<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="learn technology to learn programming and network">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <title>learntechnology</title>
    <?php echo app('Illuminate\Foundation\Vite')([
        'resources/style/normalize.css',
        'resources/style/framework.scss',
        'resources/js/app.js',
    ]); ?>
</head>
<body>
    <div id="app">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</body>
</html><?php /**PATH /home/brittany/Desktop/Courses/Programming/Full-Stack/APPs/viteApp/resources/views/layout/app.blade.php ENDPATH**/ ?>