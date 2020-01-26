<?php

class TSwitch
{
    protected $sitch;
    
    public function __construct($id,$itens= null)
    {
        $this->sit_ativos = new TRadioGroup($id);
        $this->sit_ativo->setLayout('horizontal');
        $this->sit_ativo->setUseButton();
        $items = ['S'=>'Sim', 'N'=>'Não'];
        $this->sit_ativo->addItems($items);
        return $this->sit_ativo;
    }
}