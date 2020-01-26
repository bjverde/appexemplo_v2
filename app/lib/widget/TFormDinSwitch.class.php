<?php

class TFormDinSwitch
{
    protected $adiantiObj;
    
    public function __construct($id,$itens= null)
    {
        $this->adiantiObj = new TRadioGroup($id);
        $this->adiantiObj->setLayout('horizontal');
        $this->adiantiObj->setUseButton();
        $items = ['S'=>'Sim', 'N'=>'Não'];
        $this->adiantiObj->addItems($items);
        return $this->getAdiantiObj();
    }

    public function getAdiantiObj(){
        return $this->adiantiObj;
    }
}