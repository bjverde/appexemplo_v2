<?php

class TFormDinTextField
{
    protected $adiantiObj;
    

    /**
     * Campo de entrada de dados texto livre
     * Reconstruido FormDin 4 Sobre o Adianti 7
     *
     * @param string $id            - 1: ID do campo
     * @param string $strLabel      - 2: Label do campo, usado para validações
     * @param integer $intMaxLength - 3: Tamanho máximo de caracteres
     * @param boolean $boolRequired - 4: Obrigatorio. DEFAULT = False.
     * @return TCombo
     */
    public function __construct(string $id
                               ,string $strLabel
                               ,int $intMaxLength = null
                               ,$boolRequired = false)
    {
        $this->adiantiObj = new TEntry($id);
        if($boolRequired){
            $strLabel = empty($strLabel)?$id:$strLabel;
            $this->adiantiObj->addValidation($strLabel, new TRequiredValidator);
        }
        if(!empty($intMaxLength) && $intMaxLength>=1){
            $this->adiantiObj->addValidation($strLabel, new TMaxValueValidator, array($intMaxLength));
        }        
        return $this->getAdiantiObj();
    }

    public function getAdiantiObj(){
        return $this->adiantiObj;
    }
}