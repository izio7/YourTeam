<?php
/**
 * Created by PhpStorm.
 * User: luigidurso
 * Date: 20/12/16
 * Time: 12:17
 */

namespace AppBundle\it\unisa\formazione;

use \AppBundle\Utility\DB;
use Symfony\Component\Config\Definition\Exception\Exception;

class GestionePartita
{
    private $db;
    private $connessione;

    public function __construct()
    {
        $this->db=new DB();
        $this->connessione=$this->db->connect();
    }

    /**
     * Controlla la presenza di una partita tra massimo 2 giorni
     * @param $squadra
     * @return Partita|null
     */
    private function disponibilitaPartita($squadra)
    {
        //creazione data odierna e +2 giorni
        $dateStart=date("Y-m-d");
        $dateEnd=date("Y-m-d",strtotime($dateStart."+ 2 days"));
        //prendo partita tra 2 giorni
        $query="SELECT * FROM partita WHERE squadra='$squadra' AND data>='$dateStart' AND data<='$dateEnd'";

        $risultato=$this->connessione->query($query);

        if($risultato->num_rows<=0) throw new Exception("errore query partite per la squadra: ".$squadra);
        //se esiste, ritorna la partita
        if($risultato->num_rows==1)
        {
            $partita=$risultato->fetch_assoc();
            $modelPartita=new Partita($partita["nome"],$partita["data"],$partita["squadra"],$partita["stadio"]);
            return $modelPartita;
        }

        return null;


    }

    /**
     * prende , se presenta , una partita entro 2 giorni e ne controlla la disp. alle convocazioni
     * @param $squadra
     */
    public function disponibilitaConvocazione($squadra)
    {
        $partita=$this->disponibilitaPartita($squadra);
        if(!is_null($partita))
        {
            $query="SELECT * FROM giocare WHERE partita='$partita'";
            $risultato=$this->connessione->query($query);

            if($risultato->num_rows!=0)
            {
                throw new ConvocNonDispException("convocazioni gia diramate per questa partita");
            }
            else
            {
                return $partita;
            }
        }
        else
        {
            throw new PartitaNonDispException("non esiste nessuna partita disponibile alla convocazione!");
        }
    }

    function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->db->close($this->connessione);
    }


}