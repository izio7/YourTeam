<?php
/**
 * Created by PhpStorm.
 * User: Carmine
 * Date: 22/12/2016
 * Time: 14:10
 */

namespace AppBundle\Controller\it\unisa\contenuti;


class ControllerContenutiUtenteGuest
{
    /**
     * @Route("/contenuti/staff/visualizzaElencoContenuti/utenteGuest/")
     * @Method("GET")
     */
    public function visualizzaElencoContenuti()
    {
        $gestore = new GestioneContenuti();
        try {
            $gestore->visualizzaElencoContenuti();
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        return new Response();
    }

    /**
     * @Route("/contenuti/staff/visualizzaContenutoView/utenteGuest{id}")
     * @Method("GET")
     */
    public function visualizzaContenutoView($id){
        $gestore = new GestioneContenuti();

        try {
            $gestore->visualizzaContenuto($id);
            return new Response("<br/> visualizzazione andata a buon fine <br/>");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 404);
        }
        return new Response();
    }
}