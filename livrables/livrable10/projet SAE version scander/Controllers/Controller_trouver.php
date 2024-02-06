<?php
class Controller_trouver extends Controller{
    public function action_fom_trouver()
    {
        $tab = [];
        $this->render("trouver", $tab);

    }

 
    public function action_trouver()
    {
        if(isset($_POST['champ1']) && isset($_POST['champ2']) && isset($_POST['type'])){
            $m = Model::getModel();
            
            if($_POST['type'] == "Film"){
               

                $tab = ["result" => $m->ActeurEnCommun(trim($_POST['champ1']), trim($_POST['champ2']))];
                $this->render("trouver_result", $tab);
             }
            else{
                
                $tab = ["result" => $m->FilmEnCommun(trim($_POST['champ1']), trim($_POST['champ2']))];
                $this->render("trouver_result", $tab);

        

                $this->render("trouver_result", $tab);
            }
           
            

        }
        else{
            $tab = ["tab" => "Pas tout les champs saisie"];
            $this->render("error", $tab);
        }
    }


    public function action_default()
    {
        $this->action_fom_trouver();
    }
}