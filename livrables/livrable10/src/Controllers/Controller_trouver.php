<?php
class Controller_trouver extends Controller {
    public function action_fom_trouver() {
        $m = Model::getModel();
        $tab = [ 'caroussel' => $m->filmpopulaire()]; 
        $this->render("trouver", $tab);
    }

    public function action_trouver() {
        if(isset($_POST['typeselection'])) { // S'assure que 'typeselection' est bien défini.
            $m = Model::getModel();
            $typeSelection = $_POST['typeselection']; // Type de recherche : 'titre' ou 'personne'
            if($typeSelection == "titre" && isset($_POST['titre1']) && isset($_POST['titre2'])) {
                $category1 = $_POST['categorytitre1'] ; // Utilise l'opérateur null coalesce pour éviter des erreurs non définies.
                $category2 = $_POST['categorytitre2'] ;
                $nombrededoublon1 = $m->doublonFilm($_POST['titre1'], $category1);
                $nombrededoublon2 = $m->doublonFilm($_POST['titre2'], $category2);
                if(isset($_SESSION['username'])) {
                    $data = [
                        "UserName" => $_SESSION['username'],
                        "TypeRecherche" => "Trouver",
                        "MotsCles" => [
                            $_POST['titre1'],
                            $_POST['titre2']
                        ]
                    ];
                    $result = $m->addUserRecherche($data);
                    if(!empty($result)) {
                        $tab = ["tab" => $result["message"]];
                        $this->render("error", $tab);
                    }
                }
                if ($nombrededoublon1 == 1 && $nombrededoublon2 == 1) {
                    // Logique pour quand il y a exactement un doublon pour chaque titre

                    $tconst1 = $m->gettconstunique($_POST['titre1'],$category1) ;
                    $tconst2 = $m->gettconstunique($_POST['titre2'],$catgory2) ;

                    $tab = [
                        "result" => $m->ActeurEnCommun($tconst1, $tconst2),
                        "titre1" => $_POST['titre1'],
                        "titre2" => $_POST['titre2'],
                       
                    ];
                    $this->render("trouver_result", $tab);
                } else {
                    // Gestion des multiples doublons
                    $tab = [
                        "result1" => $m->listeDoublon($_POST['titre1'], $category1),
                        "result2" => $m->listeDoublon($_POST['titre2'], $category2),
                        "titre1" => $_POST['titre1'],
                        "titre2" => $_POST['titre2'],
                    ];
                    $this->render("selectiondoublon", $tab);
                }
            } elseif($typeSelection == "personne" && isset($_POST['personne1']) && isset($_POST['personne2'])) {
                $nombrededoublon1 = $m->doublonActeur($_POST['personne1']);
                $nombrededoublon2 = $m->doublonActeur($_POST['personne2']);
                
                if(isset($_SESSION['username'])) {
                    $data = [
                        "UserName" => $_SESSION['username'],
                        "TypeRecherche" => "Trouver",
                        "MotsCles" => [
                            $_POST['personne1'],
                            $_POST['personne2']
                        ]
                    ];
                    $result = $m->addUserRecherche($data);
                    if(!empty($result)) {
                        $tab = ["tab" => $result["message"]];
                        $this->render("error", $tab);
                    }
                
                }
                
                if ($nombrededoublon1 == 1 && $nombrededoublon2 == 1) {
                $nconst1 = $m->getnconstunique($_POST['personne1']) ;
                $nconst2 = $m->getnconstunique($_POST['personne2']) ;
                $tab = [
                    "result" => $m->FilmEnCommun($nconst1, $nconst2),
                    "personne1" => $_POST['personne1'],
                    "personne2" => $_POST['personne2'],
                ];
                $this->render("trouver_resultfilm", $tab);
            }
            else{
                $tab = [
                    "result1" => $m->listeDoublonActeur($_POST['personne1']),
                    "result2" => $m->listeDoublonActeur($_POST['personne2']),
                    "personne1" => $_POST['personne1'],
                    "personne2" => $_POST['personne2'],
                ];
                $this->render("selectiondoublonacteur", $tab);

            }

        } 
    }

    }


    public function action_acteurcommun(){
        $m = Model::getModel();
        if(isset($_POST['selectedTconst1']) && isset($_POST['selectedTconst2'])){

            $tab = [
                "result" => $m->ActeurEnCommun($_POST['selectedTconst1'], $_POST['selectedTconst2']),
                "titre1"=>$_POST['titre1'],
                "titre2"=>$_POST['titre2'],
            ];
            $this->render("trouver_result", $tab);

        }


    }

    public function action_titrecommun(){
        $m = Model::getModel();
        if(isset($_POST['selectednconst1']) && isset($_POST['selectednconst2'])){

            $tab = [
                "result" => $m->FilmEnCommun($_POST['selectednconst1'], $_POST['selectednconst2']),
                 "personne1"=>$_POST['personne1'],
                "personne2"=>$_POST['personne2'],
            ];
            $this->render("trouver_resultfilm", $tab);

        }


    }
    
    public function action_default() {
        $this->action_fom_trouver();
    }
}
