<?php

class TFormDinNumericField
{
    protected $adiantiObj;
    

    /**
     * Campo de entrada de dados texto livre
     * Reconstruido FormDin 4 Sobre o Adianti 7
     *
     * @param string $id                 - 1: ID do campo
     * @param string $strLabel           - 2: Label do campo, que irá aparecer na tela do usuario
     * @param integer $intMaxLength      - 3: Quantidade maxima de digitos.
     * @param boolean $boolRequired      - 4: Obrigatorio
     * @param integer $decimalPlaces     - 5: Quantidade de casas decimais.
     * @param boolean $boolNewLine       - 6: Campo em nova linha. Default = true = inicia em nova linha, false = continua na linha anterior 
     * @param string $strValue           - 7: valor inicial do campo
     * @param string $strMinValue        - 8: valor minimo permitido. Null = não tem limite.
     * @param string $strMaxValue        - 9: valor maxima permitido. Null = não tem limite.
     * @param boolean $boolFormatInteger -10: Inteiros com ou sem ponto de separação
     * @param string $strDirection
     * @param boolean $boolAllowZero
     * @param boolean $boolAllowNull
     * @param boolean $boolLabelAbove
     * @param boolean $boolNoWrapLabel
     * @param string $strHint
     * @return TNumber
     */ 
    public function __construct(string $id
                               ,string $strLabel
                               ,int $intMaxLength = null
                               ,$boolRequired = false
                               ,int $decimalPlaces=null
                               ,$boolNewLine=null
                               ,$strValue=null
                               ,$strMinValue=null
                               ,$strMaxValue=null
                               ,$boolFormatInteger=null
                               ,$strDirection=null
                               ,$boolAllowZero=null
                               ,$boolAllowNull=null
                               ,$boolLabelAbove=null
                               ,$boolNoWrapLabel=null
                               ,$strHint=null)
    {
        $this->adiantiObj = new TNumeric($strLabel, $decimalPlaces, $decimalsSeparator, $thousandSeparator, $replaceOnPost = true);
        $this->adiantiObj->setId($id);
        if($intMaxLength>=1){
            $this->adiantiObj->addValidation($strLabel, new TMaxLengthValidator, array($intMaxLength));
        }
        if($boolRequired){
            $strLabel = empty($strLabel)?$id:$strLabel;
            $this->adiantiObj->addValidation($strLabel, new TRequiredValidator);
        }
        if(!empty($strValue)){
            $this->adiantiObj->setValue($strValue);
        }
        if(!empty($strExampleText)){
            $this->adiantiObj->placeholder = $strExampleText;
        } 
        return $this->getAdiantiObj();
    }

    public function getAdiantiObj(){
        return $this->adiantiObj;
    }
}