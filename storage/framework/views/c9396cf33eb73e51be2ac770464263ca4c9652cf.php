<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <!--Profile image -->
        <div class="col-3 p-5">
            <img src="<?php echo e($user->profile->profileImage()); ?>" class="rounded-circle w-100" alt="Not found!!!">
        </div>

        <!--Profile info section(post + followers + following + edit and follow buttons -->
        <div class="col-9 pt-5 ">
            <div class=" d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-1">
                    <div class="font-weight-bold mr-4 h1 pt-2"> <?php echo e($user->username); ?> </div>
                        <follow-button></follow-button>
                    <!-- link to new post page -->
                </div>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update',$user->profile)): ?>
                    <a href="/p/create"> Add New Post</a>
                <?php endif; ?>
            </div>
            <!-- link to edit profile page -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update',$user->profile)): ?>
                    <a href="/profile/<?php echo e($user->id); ?>/edit">Edit Profile</a>
            <?php endif; ?>

            <div class="d-flex">
                <!-- count the number of posts -->
                <div class="pr-3"><strong><?php echo e($user->posts->count()); ?></strong> posts</div>
                <div class="pr-3"><strong>25k</strong> followers</div>
                <div class="pr-3"><strong>200</strong> following</div>
            </div>

            <!--Profile description section -->
            <div class="pt-3 font-weight-bold"><?php echo e($user->profile->title); ?></div>
            <div> <?php echo e($user->profile->description); ?> </div>
            <div><a href="#" class="font-weight-light"> <?php echo e($user->profile->url); ?> </a></div>
        </div>
    </div>

    <!--Show posts (at first, just using 3 images  -->
    <div class="row pt-5">
        <!-- show all posts of this user from DB -->
        <?php $__currentLoopData = $user->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-4 pb-4">
            <a href="/p/<?php echo e($post->id); ?>">
                <img src="/storage/<?php echo e($post->image); ?>" class="w-100">
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\default.LAPTOP-3K4NL43V\Desktop\laravel\SocialNetwork\resources\views/profiles/index.blade.php ENDPATH**/ ?>