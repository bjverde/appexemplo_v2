<?php

class TFormDin
{
    protected $adiantiObj;
    
    /**
     * Formulario Padronizado em BoorStrap
     * Reconstruido FormDin 4 Sobre o Adianti 7
     *
     * @param string $strName       - 1: Name do Form
     * @param string $strTitle      - 2: Titulo que irá aparecer no Form
     * @param boolean $boolRequired - 3: Se vai fazer validação no Cliente (Navegador)
     * @return BootstrapFormBuilder
     */
    public function __construct(string $strName
                               ,string $strTitle
                               ,$boolClientValidation = true)
    {
        $this->adiantiObj = new BootstrapFormBuilder($strName);
        $this->adiantiObj->setFormTitle($strTitle);
        $this->adiantiObj->setClientValidation($boolClientValidation);
        return $this->getAdiantiObj();
    }

    public function getAdiantiObj(){
        return $this->adiantiObj;
    }

    /**
     * Inclusão 
     * @param array $label - label que será incluido com o campo
     * @param array $campo - campo que será incluido
     */
    public function addFields(array $label, array $campo){
        $this->adiantiObj->addFields($label, $campo);
    }

    /**
     * Campo de entrada de dados texto livre
     * Reconstruido FormDin 4 Sobre o Adianti 7
     *
     * @param string $id            - 1: ID do campo
     * @param string $strLabel      - 2: Label do campo, usado para validações
     * @param integer $intMaxLength - 3: Tamanho máximo de caracteres
     * @param boolean $boolRequired - 4: Obrigatorio. DEFAULT = False.
     * @param string $strValue      - 5: Texto preenchido ou valor default
     * @param string $strExampleText- 6: Texto de exemplo ou placeholder 
     * @return TEntry
     */
    public function addTextField(string $id
                                ,string $strLabel
                                ,int $intMaxLength = null
                                ,$boolRequired = false
                                ,string $strValue=null
                                ,string $strExampleText =null){
        $formDinTextField = new TFormDinTextField($id,$strLabel,$intMaxLength,$boolRequired,$strValue,$strExampleText);
        $objField = $formDinTextField->getAdiantiObj();
        $formDinLabelField = new TFormDinLabelField($strLabel,$boolRequired);
        $label = $formDinLabelField->getAdiantiObj();
        $this->addFields([$label], [$objField]);
    }
}