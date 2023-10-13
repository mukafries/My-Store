<?php if(!empty($errors)): ?>

<div class="alert alert-danger" role="alert">
    <?php foreach($errors as $error): ?>
        <div><?= $error ?></div>
    <?php endforeach ?>
</div>

<?php endif; ?>

<!-- submittingn this form reloads the same  either the update or create form and the data entered is submitted to the same page -->
<?php
/*
if it's the UPDATE page using either the get or post method:
    GET: this can only be done from the homepage
    1. The hompepage sends the id of the data to be  updated to this form and the details of the poroduct are auto filled in, ready for editing
*/
?>
<form action="" method="post" enctype="multipart/form-data">
<?php if($product->image_path):?>
    <img class="update-image" src= "/<?= $product->image_path ?>">
<?php endif; ?>

<div class="mb-3">
    <label class="form-label">Image</label>
    <input type="file" name="image" class="form-control" >
</div>
<div class="mb-3">
    <label  class="form-label">Title</label>
    <input type="text" name="title" value="<?= $product->title ?>" class="form-control" >
</div>
<div class="mb-3">
    <label  class="form-label">Description</label>
    <textarea type="text" name="description" class="form-control" ><?= $product->description ?></textarea>
</div>
<div class="mb-3">
    <label  class="form-label">Price</label>
    <input type="number" name="price" value="<?= $product->price ?>" step=".01" class="form-control">
</div>
<button type="submit" class="btn btn-primary">submit</button>
</form>