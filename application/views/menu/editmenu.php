<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-md-8">

             <!-- <?= form_open_multipart('menu'); ?> -->

             <!-- edit menu by ramdan -->
             <form action="<?= base_url(); ?>menu/editmenu/<?= $menu->id; ?>" method="post">

            <div class="form-group row">
                <label for="menu" class="col-sm-2 col-form-label">New Menu</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="menu" name="menu" value="<?= $menu->menu; ?>">
                </div>
            </div>
            
            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <button class="btn btn-primary">Edit</button>
                </div>
            </div>

            </form>

        </div>
    </div>

</div>
</div>