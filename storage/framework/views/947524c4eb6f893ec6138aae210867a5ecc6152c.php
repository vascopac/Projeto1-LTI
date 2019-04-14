<?php /* /home/vagrant/lti/projeto1/resources/views/app.blade.php */ ?>
<?php $__env->startSection('title', 'Open Flow'); ?>

<?php $__env->startSection('content'); ?>
<page> </page>
<v-app> 
    <v-content>
        <v-container fluid>
        </v-container>
    </v-content>
    <v-footer app></v-footer>
</v-app>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('pagescript'); ?>
<script src="js/app.js"></script>    
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>
 <?php $__env->stopSection(); ?>  
<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>