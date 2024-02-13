<?php
class Controller_resetFinal extends Controller{
    
    public function action_final(){
        $this->render("reset", []);
    }
    
    public function action_resetFinal(){
        if(isset($_POST['passWord']) && isset($_GET['token'])){
            echo "ok";
            $m = Model::getModel();
            $result = $m->getUserIdWithToken(trim(e($_GET['token'])));
            $data = [
                "userId" => $result["userId"][0],
                "password" => trim(e($_POST['passWord']))
            ];
            $result = $m->updatePassword($data);
            print_r($result);
            $m->removeToken($result["userId"][0], trim(e($_GET['token'])));
            if($result['status'] == "OK"){
                $tab = ["tab" => "message ok"];
                $this->render("isreset", $tab);
            }
            else{
                $tab = ["tab" => "Error dans la modification du mot de passe"];
                $this->render("error", $tab);
            }
        }
        else{
                $tab = ["tab" => "Aucun champ saisie"];
                $this->render("error", $tab);
        }

    }
    
    public function action_default(){
        $this->action_final();
    }
}