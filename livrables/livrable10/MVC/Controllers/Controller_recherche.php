<?php
Class Controller_recherche extends Controller{

    public function action_fom_rechercher(){  

        $this->render("recherche");

    }

    public function action_afficher(){
        if((isset($_POST['nom']) && preg_match("/^[A-Za-z\s\-\'']+$/", $_POST['nom'])) || (isset($_POST['titre']) && preg_match("/^[A-Za-z0-9\s\-\'']+$/", $_POST['titre']))){
            $db = Model::getModel();
            $tab = $db->from_recherche($_POST['nom'], $_POST['titre']);
            
            if(sizeof($tab) == 0){

                $this->render("error");


            }
            else{

                $data = ["data" => $tab];
                $this->render("afficher", $data);

            }

        }
        else{
            
            $this->render("error");

        }


    }

    public function action_form_avancer(){

        $this->render("formAvancer");

    }


public function action_afficher_form_avancer(){
    if (
        (isset($_POST['nom']) && preg_match("/^[A-Za-z\s\-\'']+$/", $_POST['nom'])) ||
        (isset($_POST['titre']) && preg_match("/^[A-Za-z0-9\s\-\'']+$/", $_POST['titre'])) ||
        (isset($_POST['startBirthYear']) && is_numeric($_POST['startBirthYear'])) ||
        (isset($_POST['endBirthYear']) && is_numeric($_POST['endBirthYear'])) ||
        (isset($_POST['startFilmYear']) && is_numeric($_POST['startFilmYear'])) ||
        (isset($_POST['endFilmYear']) && is_numeric($_POST['endFilmYear'])) ||
        (isset($_POST['order']) && in_array($_POST['order'], ['name', 'titre', 'birthYear', 'startYear']))
    ) {
        $db = Model::getModel();
        $tab = $db->form_recherche_avancer(
            $_POST['nom'],
            $_POST['titre'],
            $_POST['startBirthYear'],
            $_POST['endBirthYear'],
            $_POST['startFilmYear'],
            $_POST['endFilmYear'],
            $_POST['order']
        );

        if (sizeof($tab) == 0) {
            $this->render("error");
        } else {
            $data = ["data" => $tab];
            $this->render("afficher", $data);
        }
    } else {
        $this->render("error");
    }
}


    public function action_afficher_acteur(){
        $db = Model::getModel();
        $data = ["data" => $db->get_info(e($_GET['nom']))];
        $this->render("afficher", $data);


    }




    public function action_default()
    {
        $this->action_fom_rechercher() ;
    }

}
