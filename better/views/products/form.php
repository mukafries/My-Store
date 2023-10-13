<?php if(!empty($errors)): ?>

    <div class="alert alert-danger" role="alert">
        <?php foreach($errors as $error): ?>
            <div><?= $error ?></div>
        <?php endforeach ?>
    </div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <?php if($image_path):?>
        <img class="update-image" src= "/<?= $image_path ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" name="image" class="form-control" >
    </div>
    <div class="mb-3">
        <label  class="form-label">Title</label>
        <input type="text" name="title" value="<?= $title ?>" class="form-control" >
    </div>
    <div class="mb-3">
        <label  class="form-label">Description</label>
        <textarea type="text" name="description" class="form-control" ><?= $description ?></textarea>
    </div>
    <div class="mb-3">
        <label  class="form-label">Price</label>
        <input type="number" name="price" value="<?= $price ?>" step=".01" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">submit</button>
</form>