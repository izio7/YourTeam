<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 30/12/2016
 * Time: 23:02
 */

namespace AppBundle\Controller\it\unisa\statistiche;


use AppBundle\it\unisa\autenticazione\GestoreAutenticazione;
use AppBundle\it\unisa\formazione\GestioneRosa;
use AppBundle\it\unisa\partite\GestorePartite;
use AppBundle\it\unisa\statistiche\GestoreStatisticheCalciatore;
use AppBundle\it\unisa\statistiche\GestoreStatistichePartita;
use AppBundle\it\unisa\statistiche\StatistichePartita;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ControllerStatistichePartitaStaff extends Controller
{
    /**
     * @Route("/statistiche/staff/partita/insert/submit", name = "inserisciStatistichePartita")
     * @Method("POST")
     */
    public function inserisciStatistiche(Request $request)
    {
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {
            $autenticazione = GestoreAutenticazione::getInstance();
            if ($autenticazione->check($request->get("_route"))) {
                $squadra = $_SESSION["squadra"];
                /*$values = $request->get("values");

                $array = json_decode($values, true);
                //var_dump($array);

                $marcatori = $array["marcatori"];
                $assistmen = $array["assistmen"];
                $ammonizioni = $array["ammonizioni"];
                $espulsioni = $array["espulsioni"];

                //var_dump($marcatori);
                //var_dump($assistmen);
                //var_dump($ammonizioni);
                //var_dump($espulsioni);

                //var_dump(count($espulsioni));

                $nomePartita = $array["nome"];
                $dataPartita = $array["data"];
                $golFatti = $array["golfatti"];
                $golSubiti = $array["golsubiti"];
                $possessoPalla = $array["possessopalla"];*/

                $nome = $request->get("nome");
                $data = $request->get("data");
                $golFatti = $request->get("golfatti");
                $golSubiti = $request->get("golsubiti");
                $possessoPalla = $request->get("possessopalla");

                $marcatori = $request->get("marcatori") ? $request->get("marcatori") : array();
                $assistmen = $request->get("assistmen") ? $request->get("assistmen") : array();
                $ammonizioni = $request->get("ammonizioni") ? $request->get("ammonizioni") : array();
                $espulsioni = $request->get("espulsioni") ? $request->get("espulsioni") : array();

                //var_dump($nome);
                //var_dump($data);
                //var_dump($golFatti);
                //var_dump($golSubiti);
                //var_dump($possessoPalla);
                //var_dump($marcatori);

                $gestorePartite = GestorePartite::getInstance();
                $partita = $gestorePartite->getPartita($nome, $data, $squadra);

                //__construct($golFatti, $golSubiti, $possessoPalla,
                // array $marcatori, array $assistMen, array $ammonizioni, array $espulsioni)
                $statistiche = new StatistichePartita($golFatti, $golSubiti, $possessoPalla, $marcatori, $assistmen, $ammonizioni, $espulsioni);
                $partita->setStatistiche($statistiche);

                $gestoreStatistichePartita = GestoreStatistichePartita::getInstance();
                $executed = $gestoreStatistichePartita->inserisciStatistiche($partita);

                if ($executed) {
                    return $this->redirectToRoute("lista_statistiche_calciatori_partita", array("nome" => $nome, "data" => $data));
                } else {
                    return $this->redirectToRoute("lista_statistiche_partite");
                }
            } else {
                return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Azione non consentita."));
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Effettuare il login."));
        }
    }

    /**
     * @Route("/statistiche/staff/partita/edit/submit", name = "modificaStatistichePartita")
     * @Method("POST")
     */
    public function modificaStatistiche(Request $request)
    {
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {
            $autenticazione = GestoreAutenticazione::getInstance();
            if ($autenticazione->check($request->get("_route"))) {
                $squadra = $_SESSION["squadra"];
                $nome = $request->get("nome");
                $data = $request->get("data");
                $golFatti = $request->get("golfatti");
                $golSubiti = $request->get("golsubiti");
                $possessoPalla = $request->get("possessopalla");

                $marcatori = $request->get("marcatori") ? $request->get("marcatori") : array();
                $assistmen = $request->get("assistmen") ? $request->get("assistmen") : array();
                $ammonizioni = $request->get("ammonizioni") ? $request->get("ammonizioni") : array();
                $espulsioni = $request->get("espulsioni") ? $request->get("espulsioni") : array();

                $gestorePartite = GestorePartite::getInstance();
                $partita = $gestorePartite->getPartita($nome, $data, $squadra);

                $statistiche = new StatistichePartita($golFatti, $golSubiti, $possessoPalla, $marcatori, $assistmen, $ammonizioni, $espulsioni);
                $partita->setStatistiche($statistiche);

                $gestoreStatistichePartita = GestoreStatistichePartita::getInstance();
                $executed = $gestoreStatistichePartita->modificaStatistiche($partita);

                if ($executed) {
                    return $this->redirectToRoute("lista_statistiche_calciatori_partita", array("nome" => $nome, "data" => $data));
                } else {
                    return $this->redirectToRoute("lista_statistiche_partite");
                }
            } else {
                return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Azione non consentita."));
            }
        } else {
            return $this->render("guest/accountNonAttivo.html.twig", array('messaggio' => "Effettuare il login."));
        }
    }

    /**
     * @Route("/test/marcatori/{nome}/{data}/{squadra}", name = "getMarcatoriPartita")
     * @Method("GET")
     */
    public function getMarcatori($nome, $data, $squadra)
    {
        $gestorePartite = GestorePartite::getInstance();
        $partita = $gestorePartite->getPartita($nome, $data, $squadra);

        $gestoreStatistichePartita = GestoreStatistichePartita::getInstance();
        $marcatori = $gestoreStatistichePartita->getMarcatori($partita);

        return new JsonResponse($marcatori);
    }

    /**
     * Restituisce i convocati per la partita.
     * @Route("/statistiche/convocati/{nome}/{data}", name = "getConvocatiPartita")
     */
    public function getConvocati(Request $request, $nome, $data)
    {
        if (isset($_SESSION) && isset($_SESSION["squadra"]) && isset($_SESSION["tipo"])) {
            $autenticazione = GestoreAutenticazione::getInstance();
            if ($autenticazione->check($request->get("_route"))) {
                $convocati = array();

                try {
                    $gestorePartite = GestorePartite::getInstance();
                    $partita = $gestorePartite->getPartita($nome, $data, $_SESSION["squadra"]);
                    if ($partita->hasConvocati()) {
                        $convocati = $partita->getConvocati();
                    }
                } catch (\Exception $e1) {
                    return new JsonResponse(array("convocati" => $convocati));
                }

                return new JsonResponse(array("convocati" => $convocati));
            } else {
                return new JsonResponse(array("convocati" => array()));
            }
        } else {
            return new JsonResponse(array("convocati" => array()));
        }
    }
}