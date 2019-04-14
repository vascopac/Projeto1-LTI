<?php /* /home/vagrant/lti/projeto1/resources/views/master.blade.php */ ?>
<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <?php echo $__env->yieldContent('extrastyles'); ?> 
    <!-- Latest compiled and minified CSS & JS -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(URL::asset('css/app.css')); ?>">
  </head> 
  <body>  
    <div id="app">
      <?php echo $__env->yieldContent('content'); ?>
    </div>
    <?php echo $__env->yieldContent('pagescript'); ?> 
  </body>
</html>