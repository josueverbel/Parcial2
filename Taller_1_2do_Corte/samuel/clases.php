<?php
class Continent{
    public $ID;
    public $Name;
    public $Description;
    public $Countries = [];

    function __construct($ID = null, $Name = null, $Description = null){
        $this-> ID = $ID;
        $this-> Name = $Name;
        $this-> Description = $Description;
    }

    public function AddCountry(Country $Country){
       $Exists = in_array($Country->ID,array_column($this->Countries, 'ID'), false);
        if ($Exists) {
            return !$Exists;
        }
        else{
            array_push($this->Countries,$Country);
            return $Exists;
        }
       
    }

    public function DeleteCountry($ID){
        $CountryIndex = array_search($ID,array_column($this->Countries, 'ID'),false);
        unset($this->Countries[$CountryIndex]);
        $this->Countries = array_values($this->Countries);
    }

    public function EditCountry($ID, $NewName, $NewDesc){
        $CountryIndex =  array_search($ID,array_column($this->Countries, 'ID'),false);
        $this->Countries[$CountryIndex]->Name = $NewName;
        $this->Countries[$CountryIndex]->Description = $NewDesc;
    }
}

class Country{
    public $ID;
    public $Name;
    public $Description;

    function __construct($ID = null, $Name = null, $Description = null){
        $this-> ID = $ID;
        $this-> Name = $Name;
        $this-> Description = $Description;
    }
}
