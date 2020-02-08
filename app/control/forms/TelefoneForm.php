<?php

class TelefoneForm extends TPage
{
    protected $form;      // form

    public function __construct()
    {
        parent::__construct();
        
        // create the form
        $this->form = new BootstrapFormBuilder(__CLASS__);
        $this->form->setFormTitle('Testa telefone');
        
        $telefoneLabel = 'Telefone';
        $formDinTextField = new TFormDinFoneField('tel',$telefoneLabel,true);
        $telefone = $formDinTextField->getAdiantiObj();    
        
        // add the form fields
        //$this->form->addFields( [new TLabel('Cod', 'red')],    [$id] );
        $this->form->addFields( [new TLabel($telefoneLabel, 'red')],  [$telefone] );
        
        // define the form actions
        $this->form->addAction( 'Buscar', new TAction([$this, 'onTelefone']), 'fa:save green');

        // wrap the page content using vertical box
        $formDinSwitch = new TFormDinBreadCrumb(__CLASS__);
        $vbox = $formDinSwitch->getAdiantiObj();
        $vbox->add($this->form);
        
        parent::add($vbox);
    }

    public static function onTelefone($param)    
    {   
        var_dump($param);
        if (isset($param))
        {
          $link = 'https://qualoperadora.info/consulta';
          $dados = array
          (
           'tel'=> preg_replace('/[^0-9]/','',$param['code'].$param['tel']),
            'bto'=>'Descobrir Operadora'
          );
          $dados = http_build_query($dados,null,"");
          $ch = curl_init($link);
          curl_setopt($ch, CURLOPT_REFERER, $link);
          curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
          curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch,CURLOPT_POSTFIELDS, $dados);
          //curl_setopt($ch, CURLOPT_COOKIEJAR, $arquivo);
            $html = curl_exec($ch); 
            $txt  = preg_split("/:/", $html);
        
            print_r($txt);
            
          exit();
           curl_close($ch);
        }
    }


}