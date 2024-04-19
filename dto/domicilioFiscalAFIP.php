<?php
include_once (__DIR__ . '/enums/tipoDomicilioAFIP.php');

class DomicilioFiscalAFIP {
    
    public $tipoDomicilio;
    public $direccion = "";
    public $localidad = "";
    public $codPostal = 0;
    public $idProvincia = 0;
    public $descripcionProvincia = "";
    public $piso = "";
	public $departamento = "";
	public $provLetra = "";
    // public $tipoDatoAdicional;
    // public $datoAdicional = "";

    public function __construct($responseObject)
    {
        $this->_map($responseObject);
    }

    private function _map($responseObject) {
        $this->tipoDomicilio = $responseObject->tipoDomicilio;
        $this->direccion = mb_strtoupper(html_entity_decode($responseObject->direccion), 'UTF-8');
		if (strpos($this->direccion, 'PISO:') !== false) { //tiene PISO en la dirección
			$aux=explode('PISO:', $this->direccion);
			$this->direccion=trim($aux[0]);
			$aux[1]=trim(str_replace('PISO:', '', $aux[1]));
			if (strpos($aux[1], 'DPTO:') !== false) { //tiene DPTO en la dirección
				$aux=explode('DPTO:', $aux[1]);
				$this->piso=trim($aux[0]);
				$this->departamento=trim(str_replace('DPTO:', '', $aux[1]));
			} else {
				$this->piso=trim($aux[1]);
			}
		}
        $this->localidad = $responseObject->localidad;

        if (isset($responseObject->codPostal)) {
            // Compataibilidad con PadronA5
            $this->codPostal = $responseObject->codPostal;
        } else if (isset($responseObject->codigoPostal)) {
            $this->codPostal = $responseObject->codigoPostal;
        }

        $this->idProvincia = $responseObject->idProvincia;
		switch ($this->idProvincia) {
			case "0": //Ciudad Autónoma de Buenos Aires
				$this->provLetra="C";
				$this->localidad='Ciudad Autonoma de Buenos Aires'; //si es C no trae localidad AFIP
				break;
			case "1": //Buenos Aires
				$this->provLetra="B";
				break;
			case "2": //Catamarca
				$this->provLetra="K";
				break;
			case "3": //Córdoba
				$this->provLetra="X";
				break;
			case "4": //Corrientes
				$this->provLetra="W";
				break;
			case "5": //Entre Ríos
				$this->provLetra="E";
				break;
			case "6": //Jujuy
				$this->provLetra="Y";
				break;
			case "7": //Mendoza
				$this->provLetra="M";
				break;
			case "8": //La Rioja
				$this->provLetra="f";
				break;
			case "9": //Salta
				$this->provLetra="A";
				break;
			case "10": //San Juan
				$this->provLetra="J";
				break;
			case "11": //San Luis
				$this->provLetra="D";
				break;
			case "12": //Santa Fe
				$this->provLetra="S";
				break;
			case "13": //Santiago del Estero
				$this->provLetra="G";
				break;
			case "14": //Tucumán
				$this->provLetra="T";
				break;
			case "16": //Chaco
				$this->provLetra="H";
				break;
			case "17": //Chubut
				$this->provLetra="U";
				break;
			case "18": //Formosa
				$this->provLetra="P";
				break;
			case "19": //Misiones
				$this->provLetra="N";
				break;
			case "20": //Neuquén
				$this->provLetra="Q";
				break;
			case "21": //La Pampa
				$this->provLetra="L";
				break;
			case "22": //Río Negro
				$this->provLetra="R";
				break;
			case "23": //Santa Cruz
				$this->provLetra="Z";
				break;
			case "24": //Tierra del Fuego
				$this->provLetra="V";
				break;
		}
        $this->descripcionProvincia = $responseObject->descripcionProvincia;
    }
}
