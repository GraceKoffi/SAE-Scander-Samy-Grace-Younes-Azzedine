<?php require "Views/view_navbar.php"; ?>
<style>
    .titleContact{
    margin-top:100px
 }
 .paragrapheTrouver{
    padding-top: 20px;
    margin-bottom: 50px
 }

 .top{
    margin-top: 20px;
 }

 .left{
    margin-left: 300px;
 }

 .bottom{
    margin-bottom: 50px;
 }

 .bottom-form{
    margin-bottom: 200px;
 }
 
</style>    
<div id="liens" class="container bottom top">
    <div class="row align-items-center">   
            <h1 class="titleContact">Contactez-nous</h1>
            
    </div>
</div>

   <div class="container-fluid bottom-form"> 
        <div class="d-flex align-items-center">
            <div class="row align-items-center">
                <div class="mx-auto col">
                    <form action="?controller=contact&action=send" method="post">
                        <?php
                            if(isset($tab)){
                                $email = $tab[0];
                                $name = $tab[1];
                            }
                        ?>
                        <div class="container top bottom">
                            <div class="row mx-auto">
                                <div class="mx-auto col">
                                    <label for="nom">Nom :</label>
                                </div>
                            </div>
                            <div class="row mx-auto">
                                <div class="col">
                                    <input type="text" id="nom" name="nom" value="<?php echo $name[0] ?? ''; ?>" required>
                                </div>
                            </div>
                        </div>
            
                        <div class="container bottom">
                            <div class="row mx-auto">
                                <div class="mx-auto col">
                                    <label for="Email">Email :</label>
                                </div>
                            </div>
                            <div class="row mx-auto">
                                <div class="col">
                                    <input type="email" id="email" name="email" value="<?php echo $email[0] ?? ''; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="container bottom">
                            <div class="row mx-auto">
                                <div class="mx-auto col">
                                    <label for="message">Message :</label>
                                </div>
                            </div>
                            <div class="row mx-auto">
                                <div class="col">
                                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                                </div>
                            </div>
                        </div>

                        

                        <button type="submit" class="btn btn-warning mt-2 mx-auto" style =" color: white;display: block; margin-bottom:10px;" >Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>






<?php require "Views/view_footer.php"; ?>