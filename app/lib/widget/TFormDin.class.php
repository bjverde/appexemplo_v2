<?php

/**
 * Classe para criação de formulários web para entrada de dados
 * Reconstruido FormDin 4 Sobre o Adianti 7.1
 * 
 * @author Reinaldo A. Barrêto Junior
 */
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

    protected function getLabelField($strLabel,$boolRequired)
    {
        $formDinLabelField = new TFormDinLabelField($strLabel,$boolRequired);
        $label = $formDinLabelField->getAdiantiObj();
        return $label;
    }

    /**
    * Adiciona um campo oculto ao layout
    * Reconstruido FormDin 4 Sobre o Adianti 7
    *
    * @param string $strName       - 1: Id do Campo
    * @param string $strValue      - 2: Valor inicial
    * @param boolean $boolRequired - 3: True = Obrigatorio; False (Defalt) = Não Obrigatorio  
    * @return THidden
    */
    public function addHiddenField(string $id
                                ,string $strValue=null
                                ,$boolRequired = false)
    {
        $formField = new TFormDinHiddenField($id,$strValue,$boolRequired);
        $objField = $formField->getAdiantiObj();
        $this->adiantiObj->addFields([$objField]);
        return $objField;
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
                                ,string $strExampleText =null)
    {
        $formDinTextField = new TFormDinTextField($id,$strLabel,$intMaxLength,$boolRequired,$strValue,$strExampleText);
        $objField = $formDinTextField->getAdiantiObj();
        $label = $this->getLabelField($strLabel,$boolRequired);
        $this->addFields([$label], [$objField]);
    }

    /**
     * Cria um RadioGroup com efeito visual de Switch
     * Reconstruido FormDin 4 Sobre o Adianti 7
     * 
     * @param string $id            - 1: ID do campo
     * @param string $strLabel      - 2: Label do campo
     * @param boolean $boolRequired - 3: Obrigatorio
     * @param array $itens
     * @return mixed TRadioGroup
     */
    public function addSwitchField(string $id
                                  ,string $strLabel
                                  ,$boolRequired = false
                                  ,array $itens= null)
    {
        $formDinSwitch = new TFormDinSwitch($id,$strLabel,$boolRequired,$itens);
        $objField = $formDinSwitch->getAdiantiObj();
        $label = $this->getLabelField($strLabel,$boolRequired);
        $this->addFields([$label], [$objField]);
    }

    /**
     * Campo do tipo SelectField ou Combo Simples
     * Reconstruido FormDin 4 Sobre o Adianti 7
     *
     * @param string $id            - 1: ID do campo
     * @param string $strLabel      - 2: Label do campo
     * @param boolean $boolRequired - 3: Obrigatorio
     * @param array $mixOptions     - 4: array dos valores. no formato "key=>value"
     * @return TCombo
     */
    public function addSelectField(string $id
                                  ,string $strLabel
                                  ,$boolRequired = false
                                  , array $mixOptions)
    {
        $formDinSelectField = new TFormDinSelectField($id,$strLabel,$boolRequired,$mixOptions);
        $objField = $formDinSelectField->getAdiantiObj();
        $label = $this->getLabelField($strLabel,$boolRequired);
        $this->addFields([$label], [$objField]);
    }

    //----------------------------------------------------------------
    //----------------------------------------------------------------
    //----------------------------------------------------------------
    //----------------------------------------------------------------s    

    /**
     * @deprecated version
     * @return void
     */
    public function setShowCloseButton(){        
    }

    /**
     * @deprecated version
     * @return void
     */
    public function setFlat(){        
    }

    /**
     * @deprecated version
     * @return void
     */
    public function setMaximize(){        
    }

    /**
     * @deprecated version
     * @return void
     */
    public function setHelpOnLine(){        
    }
}