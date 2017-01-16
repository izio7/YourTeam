<?php
/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 15/01/2017
 * Time: 16:22
 */

namespace Tests\AppBundle\it\unisa\comunicazione;

use AppBundle\it\unisa\comunicazione\GestoreComunicazione;
use AppBundle\it\unisa\comunicazione\Messaggio;

class GestoreComunicazioneTest extends \PHPUnit_Framework_TestCase
{
    private $gestoreComunicazione;

    protected function setUp()
    {
        $this->gestoreComunicazione = GestoreComunicazione::getInstance();
    }

    public function testInviaMessaggio()
    {
        $testo = "Ciao";
        $allenatore = "allentore";
        $calciatore = "123456";
        $mittente = "allenatore";
        $data = new \DateTime();
        $tipo = "chat";

        $messaggio = new Messaggio($testo, $allenatore, $calciatore, $mittente, $data, $tipo);

        $this->assertTrue($this->gestoreComunicazione->inviaMessaggio($messaggio));
    }

    public function testGetNuoviMessaggi()
    {
        $allenatore = "allentore";
        $calciatore = "123456";
        $tipo = "chat";
        $data = "2015-01-15 15:52:37";

        $messaggi = $this->gestoreComunicazione->getNuoviMessaggi($allenatore, $calciatore, $tipo, $data);

        //var_dump($messaggi);

        $this->assertGreaterThan(0, count($messaggi));
    }
}
