<?php
class Biorritme{

    private $nom;
    private $naixement;
    
    private $arrPeriodes = array("físic"=>23, "emotiu"=>28, "intelectual"=>33);

    private $diesDiferencia;
    
    private $fisic;
    private $emotiu;
    private $intelectual;

    private $percentatjeFisic;
    private $percentatjeEmotiu;
    private $percentatjeIntelectual;
  
    public function __construct($naixement, $nom){
        $this->naixement = $naixement;
        $this->nom = $nom;

        $date = new DateTime($naixement);
        $actualDate = new DateTime(date('Y-m-d'));

        $diferencia = date_diff($date, $actualDate);

        $this->diesDiferencia = $diferencia->format("%a");
    }

    public function getNom(){
        return $this->nom;
    }

    public function getNaixement(){
        return $this->naixement;
    }

    public function getFisic() {
        return $this->fisic;
    }

    public function getEmotiu() {
        return $this->emotiu;
    }
    
    public function getIntelectual() {
        return $this->intelectual;
    }
    
    public function getPercentatjeFisic() {
        return $this->percentatjeFisic;
    }

    public function getPercentatjeEmotiu() {
        return $this->percentatjeEmotiu;
    }

    public function getPercentatjeIntelectual() {
        return $this->percentatjeIntelectual;
    }

    public function biorritmeFisic(){
        //Calcula els biorritmes en funció de la data
        //actual i la data de naixement
        //Heu de tenir en compte els periodes

        return $this->biorritme('físic', $this->diesDiferencia);
    }
    public function biorritmeEmotiu(){
        return $this->biorritme('emotiu', $this->diesDiferencia);
    }

    public function biorritmeIntelectual(){
        return $this->biorritme('intelectual', $this->diesDiferencia);
    }

    public function saveCalculBiorritmeToJson(){
        //Metode que enregistre les dades a un arxiu en format Json
        //Cal afegir les noves dades a les existents a l'arxiu
        $file_name="data.json";
        //Recupera el contingut d'un fitxer
        $json_data = file_get_contents($file_name);
        //Decodifica de text a Array
        $data = json_decode($json_data, true);

        $userInformation = array(
            "Nom" => $this->nom,
            "data" => $this->naixement,
            "físic" => $this->fisic,
            "emotiu" => $this->emotiu,
            "intelectual" => $this->intelectual
        );

        array_push($data, $userInformation);

        //Codifica un Array en format Json
        $json_data = json_encode($data, JSON_PRETTY_PRINT); 
        //Enregistra en un fitxer
        file_put_contents($file_name, $json_data);
    }

    public function tableCalculBiorritmeJsonFile(){
        //Metode que llegeix les dades d'un arxiu en format Json
        //Confecciona una taula HTML amb les dades
        //Retorna la taula

        $file_name="data.json";

        $json_data = file_get_contents($file_name);

        $data = json_decode($json_data, true);

        $html_tr = "";

        foreach ($data as $info) {
            $html_tr = $html_tr . "<tr>
                                        <td> " . $info["Nom"] ." </td>
                                        <td> " . $info["data"] . " </td>
                                        <td> " . $info["físic"] . " </td>
                                        <td> " . $info["emotiu"] . " </td>
                                        <td> " . $info["intelectual"] . " </td>
                                    </tr>";
        }

        $html_table="<table class='table table-striped'>
                        <tr>
                            <td>
                                Nom:
                            </td>
                            <td>
                                Data de naixement:
                            </td>
                            <td>
                                Biorritme Físsic:
                            </td>
                            <td>
                                Biorritme Emotiu:
                            </td>
                            <td>
                                Biorritme Intelectual:
                            </td>
                        </tr>
                        " . $html_tr . "
                    </table>";

        $json_data = json_encode($data, JSON_PRETTY_PRINT); 

        file_put_contents($file_name, $json_data);
            
        return $html_table;
    }

    public function calcularBiorritmes() {
        $this->fisic = $this->biorritmeFisic();
        $this->emotiu = $this->biorritmeEmotiu();
        $this->intelectual = $this->biorritmeIntelectual();
        
        $this->percentatjeFisic = $this->percentatjeBiorritme($this->fisic);
        $this->percentatjeEmotiu = $this->percentatjeBiorritme($this->emotiu);
        $this->percentatjeIntelectual = $this->percentatjeBiorritme($this->intelectual);
    }

    public function biorritme($tipus, $dies) {
        $ciclesFets = $dies / $this->arrPeriodes[$tipus];

        $radians = $ciclesFets * 2 * pi();

        return number_format(sin($radians), 2, '.', '');
    }

    public function toString() {
        return "Name: " . $this->nom . ", Brithdate: " . $this->naixement;
    }

    public function percentatjeBiorritme($num) {
        $percentatje = $num * 50 + 50;

        return $percentatje;
    }
}
?>