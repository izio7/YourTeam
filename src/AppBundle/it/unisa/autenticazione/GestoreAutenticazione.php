<?php
/**
 * Created by PhpStorm.
 * User: Raffaele
 * Date: 17/12/2016
 * Time: 09:50
 */

namespace AppBundle\it\unisa\autenticazione;


use AppBundle\it\unisa\account\GestoreAccount;
use AppBundle\Utility\DB;

/**
 * Class GestioneAutenticazione
 * @package AppBundle\it\unisa\autenticazione
 */
class GestoreAutenticazione
{

    /**
     * @var \mysqli
     */
    private $conn;
    /**
     * @var DB
     */
    private $db;

    /**
     * GestioneAutenticazione constructor.
     */
    public function __construct()
    {
        $this->db=new DB();
        $this->conn=$this->db->connect();
    }

    /**
     * @param $username
     * @param $password
     * @return bool : true se esiste:
     *                              crea una sessione con tre info:
     *                                      -useranme
     *                                      -squadra appartenenza
     *                                      - tipo(calciatore,allenatore,staff,tisofo)
     *                false se non esiste l'account
     */
    public function login($username , $password){
        if(!isset($_SESSION)) {
            $g = new GestoreAccount();
            try {
                    $acc = $g->ricercaAccount_A_T_S($username);
                    $check = $this->checkPassword($password, $acc->getPassword());
                    if ($check) {
                        $this->creaSession($acc->getUsernameCodiceContratto(), $acc->getTipo(), $acc->getSquadra());
                        return TRUE;
                        }
                        else return false;
                }
            catch (\Exception $e){
                    /*perchè non è stato trovato un account di tipo allenatore, staff o tifoso vediamo se è un calciatore*/
                    //DA IMPLEMENTARE
                    try{
                        //implementare il metodo ricerca AccountC
                        $acc = $g->ricercaAccount_G($username);
                        $check = $this->checkPassword($password, $acc->getPassword());
                            if ($check) {
                                $this->creaSession($acc->getUsernameCodiceContratto(),"calciatore", $acc->getSquadra());
                                return TRUE;
                                }
                                else return false;
                        }
                        catch (\Exception $e){
                        return false;
                        }

            }

            }
            else return -1;

    }

    /**
     * @param $username
     * @param $tipo
     * @param $squadra
     */
    private function creaSession($username, $tipo, $squadra){
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["tipo"] = $tipo;
        $_SESSION["squadra"] = $squadra;
    }

    /**
     * @param $passwordInserita
     * @param $passwordSalvata
     * @return bool
     */
    private function checkPassword($passwordInserita, $passwordSalvata){
        //if(strcmp(md5($passwordInserita),$passwordSalvata) == 0){
        if(strcmp($passwordInserita,$passwordSalvata) == 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @param $ogg
     */
    public function check($rotta){

      $rotteStabilite=$this->inizializzazioneRotte();
      foreach ($rotteStabilite as $r){
         if($r->getRotta()==$rotta){
             foreach ($r->getAttori() as $a)
                 if($a==$_SESSION["tipo"])
                     return true;
         }
         return false;


        }
    }

    private function inizializzazioneRotte(){
        $rotte=array(new RottaUtente("/account/calciatore/aggiungi",array("staff")),
            new RottaUtente("/account/calciatore/aggiungi",array("staff")),
        );
        return $rotte;
    }


    /**
     * @return bool
     */
    public function logout(){
        if(isset($_SESSION)){
            /*
            setcookie("PHPSESSID","",time()-3600,"/");
            return session_destroy();
            */

            $_SESSION = array();

            if (ini_get("session.use_cookies"))
            {
                $params = session_get_cookie_params();

                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            return session_destroy();

        }
        else
            return FALSE;
    }

    /**
     *
     */
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->db->close($this->conn);
    }

}