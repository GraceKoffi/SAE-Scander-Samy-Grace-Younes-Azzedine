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


<div class="container light-style flex-grow-1 container-p-y">
    <h4 class="font-weight-bold py-3 mb-4">
        Account settings
    </h4>
    <div class="card overflow-hidden">
        <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-3 pt-0">
                <div class="list-group list-group-flush account-settings-links">
                    <a class="list-group-item list-group-item-action active" data-toggle="list"
                        href="#account-general">General</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list"
                        href="#account-change-password">Change password</a>
                    <a class="list-group-item list-group-item-action" data-toggle="list"
                        href="#account-info">Info</a>
                </div>
            </div>
            <form id="account-settings-form" action="?controller=Connect&action=updateSettings" method="post">
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mb-1" value="<?php echo $_SESSION['username'];?>" id="username" disabled>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="edit-username">Edit</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?php echo $tab["name"];?>" id="Name" disabled>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="edit-name">Edit</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">E-mail</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control mb-1" value="<?php echo $tab["email"];?>" id="email" disabled>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="edit-email">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Current password</label>
                                    <div class="form-group">
                                    <div class="input-group">
                                    <input type="text" class="form-control" value="<?php echo $_SESSION['password'];?>" 
                                        id="password" disabled>
                                    </div>
                                </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">New password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="newPassword" id="newPassword" disabled>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="edit-new-password">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-info">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <label class="form-label">Country</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?php echo $tab["country"]?>" id="country" disabled>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="edit-country">Edit</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Last Connection</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?php echo $formattedDateTime;?>" 
                                        id="last-connection" disabled>
                                        <span class="input-group-addon">
                                            <i class="far fa-calendar"></i> <!-- Vous pouvez ajouter une icône de calendrier ici -->
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="text-right mt-3">
        <button type="submit" class="btn btn-primary" id="save-changes">Save changes</button>&nbsp;
        <a href="?controller=connect" class="btn btn-default" id="cancel-changes">Cancel</a>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Fonction pour activer le champ et ajouter l'attribut "name"
        function enableField(fieldId) {
            var field = document.getElementById(fieldId);
            field.removeAttribute("disabled");
            field.setAttribute("name", fieldId);
        }

        // Ajoutez des événements de clic pour chaque bouton "Edit"
        document.getElementById("edit-username").addEventListener("click", function () {
            enableField("username");
        });

        document.getElementById("edit-name").addEventListener("click", function () {
            enableField("Name");
        });

        document.getElementById("edit-email").addEventListener("click", function () {
            enableField("email");
        });

        document.getElementById("edit-new-password").addEventListener("click", function () {
            enableField("newPassword");
        });

        document.getElementById("edit-country").addEventListener("click", function () {
            enableField("country");
        });

        // Ajoutez un événement pour le bouton "Save changes"
        document.getElementById("save-changes").addEventListener("click", function () {
            // Soumettez le formulaire une fois que l'utilisateur a effectué les modifications
            document.getElementById("account-settings-form").submit();
        });
    });
</script>

</div>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
    </script>
</body>

</html>