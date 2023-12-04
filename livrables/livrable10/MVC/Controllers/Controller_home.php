<?php

Class Controller_home extends Controller{

    public function action_home(){
        $tab = [ 'tab' => [
            0=> ['Recherche', 'Trouver', 'Rapprochement'],
            1=> ['recherche', 'trouver', 'rapprochement']
        ]
        ];
        $this->render("home", $tab);

    }


    public function action_default(){

        $this->action_home();

    }

}