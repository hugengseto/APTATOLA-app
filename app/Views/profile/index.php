<?= $this->extend('layouts/template_admin'); ?>

<?= $this->section('content'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="swal" data-swalIcon="<?= session()->getFlashdata('icon'); ?>" data-swalTitle="<?= session()->getFlashdata('titleMessage'); ?>" data-swalMessage="<?= session()->getFlashdata('message'); ?>"></div>

                <!-- Profile -->
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Profile Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <img src="/profile/<?= $user['photo']; ?>" class="img-thumbnail" alt="<?= $user['photo']; ?>">
                                </div>
                                <div class="col-sm-7">
                                    <table>
                                        <tr>
                                            <td class="font-weight-bold">Username</td>
                                            <td>:</td>
                                            <td><?= $user['username']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Fullname</td>
                                            <td>:</td>
                                            <td><?= $user['fullname']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Phone</td>
                                            <td>:</td>
                                            <td><?= $user['whatsapp']; ?></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Email</td>
                                            <td>:</td>
                                            <td><?= $user['email']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning btn-sm my-3" data-toggle="modal" data-target="#profileModal">
                                Update Profile <i class="fas fa-edit"></i>
                            </button>

                        </div>
                    </div>
                </div>
                <!-- EndProfile -->

                <!-- Change Password -->
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Change Password
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="/profile/updatePassword/<?= session()->get('username') ?>" method="POST">
                                <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                                </div>
                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                                </div>

                                <button type="submit" class="btn btn-danger btn-sm">Change Password <i class="fas fa-key"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Change Password -->
            </div>
        </div>
    </section>
</div>


<!-- Modal -->
<form action="/profile/update" method="post" enctype="multipart/form-data">
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Profile Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- form -->
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fullname" class="col-sm-2 col-form-label">Fullname</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?= $user['fullname'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="phone" name="phone" value="<?= $user['whatsapp'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="photo" class="col-sm-2 col-form-label">Photo</label>
                        <div class="col-sm-10">
                            <input type="text" name="oldPhoto" value="<?= $user['photo']; ?>" hidden>
                            <div class="custom-file mb-2">
                                <input type="file" class="custom-file-input" id="photo" name="photo" onchange="previewImg()">
                                <label class="custom-file-label" for="photo"><?= $user['photo']; ?></label>
                            </div>
                            <img src="/profile/<?= $user['photo']; ?>" class="img-thumbnail img-preview" alt="<?= $user['photo']; ?>">
                        </div>
                    </div>


                    <!-- end form -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning btn-sm">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>



<?= $this->endSection(); ?>