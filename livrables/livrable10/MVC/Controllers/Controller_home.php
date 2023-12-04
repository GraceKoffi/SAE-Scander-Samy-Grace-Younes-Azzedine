<?php

Class Controller_home extends Controller{

    public function action_home(){
        $tab = [ 'tab' => [
            'value'=> ['Recherche', 'Trouver', 'Rapprochement'],
            'controller'=> ['recherche', 'trouver', 'rapprochement'],
            'action'=>['fom_rechercher', 'fom_trouver','fom_rapprochement']
        ]
        ];
        $this->render("home", $tab);

    }


    public function action_default(){

        $this->action_home();

    }

}