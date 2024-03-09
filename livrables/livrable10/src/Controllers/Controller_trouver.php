<?php
class Controller_trouver extends Controller {
    public function action_fom_trouver() {
        $m = Model::getModel();
        $tab = [ 'caroussel' => $m->filmpopulaire()]; 
        $this->render("trouver", $tab);
    }

    public function action_trouver() {
        if(isset($_POST['typeselection']) && isset($_POST['typeselectionLiens'])) { // S'assure que 'typeselection' est bien défini.
            $m = Model::getModel();
            $apiUrl = "http://127.0.0.1:5001/trouver";
            $typeSelection = $_POST['typeselection']; // Type de recherche : 'titre' ou 'personne'
            $_SESSION['typeSelectionLiens'] = $_POST['typeselectionLiens'];
            if($typeSelection == "titre" && isset($_POST['titre1']) && isset($_POST['titre2'])) {
                $category1 = $_POST['categorytitre1'] ; // Utilise l'opérateur null coalesce pour éviter des erreurs non définies.
                $category2 = $_POST['categorytitre2'] ;
                $_SESSION['search1'] = $_POST['titre1'];
                $_SESSION['search2'] = $_POST['titre2'];
                if($_SESSION['typeSelectionLiens'] == "hard"){
                    $nombrededoublon1 = $m->doublonFilm($_POST['titre1']);
                    $nombrededoublon2 = $m->doublonFilm($_POST['titre2']);
                }
                else if($_SESSION['typeSelectionLiens'] == "soft") {
                    $nombrededoublon1 = $m->doublonFilm($_POST['titre1'], $category1);
                    $nombrededoublon2 = $m->doublonFilm($_POST['titre2'], $category2);
                }
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
                }
                if ($nombrededoublon1 == 1 && $nombrededoublon2 == 1) {
                    // Logique pour quand il y a exactement un doublon pour chaque titre
                    if($_SESSION['typeSelectionLiens'] == "hard"){
                        $tconst1 = $m->getTconst(e($_POST['titre1']))[0];
                        $tconst2 = $m->getTconst(e($_POST['titre2']))[0];
                        $array = [
                            "element1" => $tconst1,
                            "element2" => $tconst2
                        ];
                        $jsonData = json_encode($array);
                        $options = array(
                            'http' => array(
                                'header'  => "Content-type: application/json",
                                'method'  => 'POST',
                                'content' => $jsonData
                            ),
                        );
                        $context  = stream_context_create($options);
    
                        // Exécuter la requête HTTP POST et récupérer la réponse
                        $apiResponse = @file_get_contents($apiUrl, false, $context); // Utilisation de @ pour supprimer les avertissements
                    
                        if ($apiResponse !== false) {
                            // Traiter la réponse de l'API (la réponse est généralement en format JSON)
                            $result = json_decode($apiResponse, true);
                            $arraySearch = array(
                                "search1" =>$_SESSION['search1'],
                                "search2" =>$_SESSION['search2']
                            );
                            $result[] = $arraySearch;
                            $tab = ["result" => $result];
                            $this->render("trouver_result_hard", $tab);
                        }
                        else{
                            $tab = ["tab" => $array];
                            $this->render("error", $tab);
                        }
                    
                    }
                    else if($_SESSION['typeSelectionLiens'] == "soft"){
                        $tconst1 = $m->gettconstunique($_POST['titre1'],$category1) ;
                        $tconst2 = $m->gettconstunique($_POST['titre2'],$catgory2) ;
                        $tab = [
                            "result" => $m->ActeurEnCommun($tconst1, $tconst2),
                            "titre1" => $_POST['titre1'],
                            "titre2" => $_POST['titre2'],
                            
                        ];
                        $this->render("trouver_result", $tab);
                    }

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
                $_SESSION['search1'] = $_POST['personne1'];
                $_SESSION['search2'] = $_POST['personne2'];
                
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
                
                }
                
                if ($nombrededoublon1 == 1 && $nombrededoublon2 == 1) {

                    if($_SESSION['typeSelectionLiens'] == "hard"){
                        $nconst1 = $m->getNcont(e($_POST['personne1']))[0];
                        $nconst2 = $m->getNcont(e($_POST['personne2']))[0];
                        $array = [
                            "element1" => $nconst1,
                            "element2" => $nconst2
                        ];
                        $jsonData = json_encode($array);
                        $options = array(
                            'http' => array(
                                'header'  => "Content-type: application/json",
                                'method'  => 'POST',
                                'content' => $jsonData
                            ),
                        );
                        $context  = stream_context_create($options);
    
                        // Exécuter la requête HTTP POST et récupérer la réponse
                        $apiResponse = @file_get_contents($apiUrl, false, $context); // Utilisation de @ pour supprimer les avertissements
                    
                        if ($apiResponse !== false) {
                            // Traiter la réponse de l'API (la réponse est généralement en format JSON)
                            $result = json_decode($apiResponse, true);
                            $arraySearch = array(
                                "search1" =>$_SESSION['search1'],
                                "search2" =>$_SESSION['search2']
                            );
                            $result[] = $arraySearch;
                            $tab = ["result" => $result];
                            $this->render("trouver_result_hard", $tab);
                        }
                        else{
                            $tab = ["tab" => $array];
                            $this->render("error", $tab);
                        }
                    
                    }else if($_SESSION['typeSelectionLiens'] == "soft"){
                            $nconst1 = $m->getnconstunique($_POST['personne1']) ;
                            $nconst2 = $m->getnconstunique($_POST['personne2']) ;
                            $tab = [
                                "result" => $m->FilmEnCommun($nconst1, $nconst2),
                                "personne1" => $_POST['personne1'],
                                "personne2" => $_POST['personne2'],
                            ];
                            $this->render("trouver_resultfilm", $tab);
                        }
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

        }else {
            $tab = ["tab" => "Une Erreur est survenu"];
            $this->render("error", $tab);
        }

    }


    public function action_acteurcommun(){
        $m = Model::getModel();
        if(isset($_POST['selectedTconst1']) && isset($_POST['selectedTconst2'])){
            if($_SESSION['typeSelectionLiens'] == "soft") {
                $tab = [
                    "result" => $m->ActeurEnCommun($_POST['selectedTconst1'], $_POST['selectedTconst2']),
                    "titre1"=>$_POST['titre1'],
                    "titre2"=>$_POST['titre2'],
                ];
                $this->render("trouver_result", $tab);
            }
            else if($_SESSION['typeSelectionLiens']){
                $array = [
                    "element1" => $_POST['selectedTconst1'],
                    "element2" => $_POST['selectedTconst2']
                ];
                $jsonData = json_encode($array);
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/json",
                        'method'  => 'POST',
                        'content' => $jsonData
                    ),
                );
                $context  = stream_context_create($options);

                // Exécuter la requête HTTP POST et récupérer la réponse
                $apiResponse = @file_get_contents($apiUrl, false, $context); // Utilisation de @ pour supprimer les avertissements
            
                if ($apiResponse !== false) {
                    // Traiter la réponse de l'API (la réponse est généralement en format JSON)
                    $result = json_decode($apiResponse, true);
                    $arraySearch = array(
                        "search1" =>$_SESSION['search1'],
                        "search2" =>$_SESSION['search2']
                    );
                    $result[] = $arraySearch;
                    $tab = ["result" => $result];
                    $this->render("trouver_result_hard", $tab);
                }
                else{
                    $tab = ["tab" => $array];
                    $this->render("error", $tab);
                }
            }

        }
    }

    public function action_titrecommun(){
        $m = Model::getModel();
        if(isset($_POST['selectednconst1']) && isset($_POST['selectednconst2'])){
            if($_SESSION['typeSelectionLiens'] == "soft"){
                $tab = [
                    "result" => $m->FilmEnCommun($_POST['selectednconst1'], $_POST['selectednconst2']),
                     "personne1"=>$_POST['personne1'],
                    "personne2"=>$_POST['personne2'],
                ];
                $this->render("trouver_resultfilm", $tab);
            }
            else if($_SESSION['typeSelectionLiens'] == "hard"){
                $array = [
                    "element1" => $_POST['selectednconst1'],
                    "element2" => $_POST['selectednconst2']
                ];
                $jsonData = json_encode($array);
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/json",
                        'method'  => 'POST',
                        'content' => $jsonData
                    ),
                );
                $context  = stream_context_create($options);

                // Exécuter la requête HTTP POST et récupérer la réponse
                $apiResponse = @file_get_contents($apiUrl, false, $context); // Utilisation de @ pour supprimer les avertissements
            
                if ($apiResponse !== false) {
                    // Traiter la réponse de l'API (la réponse est généralement en format JSON)
                    $result = json_decode($apiResponse, true);
                    $arraySearch = array(
                        "search1" =>$_SESSION['search1'],
                        "search2" =>$_SESSION['search2']
                    );
                    $result[] = $arraySearch;
                    $tab = ["result" => $result];
                    $this->render("trouver_result_hard", $tab);
                }
                else{
                    $tab = ["tab" => $array];
                    $this->render("error", $tab);
                }
            }

        }
    }
    
    public function action_default() {
        $this->action_fom_trouver();
    }
}
