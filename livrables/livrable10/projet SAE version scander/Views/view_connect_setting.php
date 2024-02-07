<!--Website: wwww.codingdung.com-->
<?php
$connectionTime = $tab["connectiontime"];
$formattedDateTime = date("d/m/Y H:i", strtotime($connectionTime));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodingDung | Profile Template</title>
    <link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <style>
        body {
    background: #f5f5f5;
    margin-top: 20px;
}

.ui-w-80 {
    width : 80px !important;
    height: auto;
}

.btn-default {
    border-color: rgba(24, 28, 33, 0.1);
    background  : rgba(0, 0, 0, 0);
    color       : #4E5155;
}

label.btn {
    margin-bottom: 0;
}

.btn-outline-primary {
    border-color: #26B4FF;
    background  : transparent;
    color       : #26B4FF;
}

.btn {
    cursor: pointer;
}

.text-light {
    color: #babbbc !important;
}

.btn-facebook {
    border-color: rgba(0, 0, 0, 0);
    background  : #3B5998;
    color       : #fff;
}

.btn-instagram {
    border-color: rgba(0, 0, 0, 0);
    background  : #000;
    color       : #fff;
}

.card {
    background-clip: padding-box;
    box-shadow     : 0 1px 4px rgba(24, 28, 33, 0.012);
}

.row-bordered {
    overflow: hidden;
}

.account-settings-fileinput {
    position  : absolute;
    visibility: hidden;
    width     : 1px;
    height    : 1px;
    opacity   : 0;
}

.account-settings-links .list-group-item.active {
    font-weight: bold !important;
}

html:not(.dark-style) .account-settings-links .list-group-item.active {
    background: transparent !important;
}

.account-settings-multiselect~.select2-container {
    width: 100% !important;
}

.light-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}

.light-style .account-settings-links .list-group-item.active {
    color: #4e5155 !important;
}

.material-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}

.material-style .account-settings-links .list-group-item.active {
    color: #4e5155 !important;
}

.dark-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(255, 255, 255, 0.03) !important;
}

.dark-style .account-settings-links .list-group-item.active {
    color: #fff !important;
}

.light-style .account-settings-links .list-group-item.active {
    color: #4E5155 !important;
}

.light-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}
    </style>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodingDung | Profile Template</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light mt-5">

    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Account settings
        </h4>

        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a>
                    </div>
                </div>

                <div class="col-md-9">
                    <form id="account-settings-form" action="?controller=connect&action=updateSettings" method="post">

                        <div class="tab-content">
                            <!-- General Tab -->
                            <div class="tab-pane fade active show" id="account-general">
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <!-- Username -->
                                    <div class="form-group">
                                        <label class="form-label">Username</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mb-1" value="<?php echo $_SESSION['username']; ?>" id="username" name="username" disabled>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" id="edit-username">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label class="form-label">Name</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?php echo $tab["name"]; ?>" id="Name" name="Name" disabled>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" id="edit-name">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- E-mail -->
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mb-1" value="<?php echo $tab["email"]; ?>" id="email" name="email" disabled>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" id="edit-email">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Change Password Tab -->
                            <div class="tab-pane fade" id="account-change-password">
                                <div class="card-body pb-2">
                                    <!-- Current Password -->
                                    <div class="form-group">
                                        <label class="form-label">Current password</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['password']; ?>" id="password" disabled>
                                        </div>
                                    </div>
                                    <!-- New Password -->
                                    <div class="form-group">
                                        <label class="form-label">New password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="newPassword" id="newPassword" name="newPassword" disabled>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" id="edit-new-password">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Info Tab -->
                            <div class="tab-pane fade" id="account-info">
                                <div class="card-body pb-2">
                                    <!-- Country -->
                                    <div class="form-group">
                                        <label class="form-label">Country</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?php echo $tab["country"] ?>" id="country" name="country" disabled>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" id="edit-country">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Last Connection -->
                                    <div class="form-group">
                                        <label class="form-label">Last Connection</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?php echo $formattedDateTime; ?>" id="last-connection" disabled>
                                            <span class="input-group-addon">
                                                <i class="far fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-primary" id="save-changes">Save changes</button>&nbsp;
                            <a href="?controller=connect" class="btn btn-default" id="cancel-changes">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function toggleFieldAndHideButton(editBtn, inputField) {
                inputField.disabled = !inputField.disabled;
                editBtn.style.display = inputField.disabled ? 'inline-block' : 'none';
            }

            var editUsernameBtn = document.getElementById("edit-username");
            var editNameBtn = document.getElementById("edit-name");
            var editEmailBtn = document.getElementById("edit-email");
            var editNewPasswordBtn = document.getElementById("edit-new-password");
            var editCountryBtn = document.getElementById("edit-country");

            var usernameInput = document.getElementById("username");
            var nameInput = document.getElementById("Name");
            var emailInput = document.getElementById("email");
            var newPasswordInput = document.getElementById("newPassword");
            var countryInput = document.getElementById("country");

            editUsernameBtn.addEventListener("click", function () {
                toggleFieldAndHideButton(editUsernameBtn, usernameInput);
            });

            editNameBtn.addEventListener("click", function () {
                toggleFieldAndHideButton(editNameBtn, nameInput);
            });

            editEmailBtn.addEventListener("click", function () {
                toggleFieldAndHideButton(editEmailBtn, emailInput);
            });

            editNewPasswordBtn.addEventListener("click", function () {
                toggleFieldAndHideButton(editNewPasswordBtn, newPasswordInput);
            });

            editCountryBtn.addEventListener("click", function () {
                toggleFieldAndHideButton(editCountryBtn, countryInput);
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>

</body>


</html>