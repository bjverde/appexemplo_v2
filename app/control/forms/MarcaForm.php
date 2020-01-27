<?php

class MarcaForm extends TPage
{
    protected $form;      // form
    protected $datagrid;  // datagrid
    protected $loaded;
    protected $pageNavigation;  // pagination component
    

    public function __construct()
    {
        parent::__construct();
        
        // create the form
        $this->form = new BootstrapFormBuilder(__CLASS__);
        $this->form->setFormTitle('Marca');

        $metaTipoController = new MetaTipoController();
        $listMetaTipo = $metaTipoController->getCombo();

        // create the form fields
        $id     = new TEntry('idtipo');
        $t2     = new TEntry('t2');
        
        $descricaoLabel = 'Nome';
        $formDinTextField = new TFormDinTextField('descricao',$descricaoLabel,3,true,null,'xxxxi');
        $descricao = $formDinTextField->getAdiantiObj();
        
        $formDinSelectField = new TFormDinSelectField('idmeta_tipo','Meta Tipo', true, $listMetaTipo);
        $idmeta_tipo = $formDinSelectField->getAdiantiObj();
        
        $sit_ativosLabel = 'Ativo';
        $formDinSwitch = new TFormDinSwitch('sit_ativo',$sit_ativosLabel,true);
        $sit_ativos = $formDinSwitch->getAdiantiObj();
        
        // add the form fields
        //$this->form->addFields( [new TLabel('Cod', 'red')],    [$id] );
        //$this->form->addFields( [new TLabel($descricaoLabel, 'red')],  [$descricao] );
        //$this->form->addFields( [new TLabel('Meta Tipo', 'red')],  [$idmeta_tipo], [new TLabel($sit_ativosLabel, 'red')],  [$sit_ativos] );
        $this->form->addFields( [new TLabel('T1')],    [$t1] );
        $this->form->addFields( [new TLabel('T2', 'red')],    [$t2] );
        
        //$id->addValidation('Cod', new TRequiredValidator);

        $t2->addValidation('T2', new TMaxValueValidator, array(3));
        
        // define the form action 
        $this->form->addAction('Send', new TAction(array($this, 'onSend')), 'far:check-circle green');
        $this->form->addHeaderAction('Send', new TAction(array($this, 'onSend')), 'fa:rocket orange');
        

        // wrap the page content using vertical box
        $formDinSwitch = new TFormDinBreadCrumb(__CLASS__);
        $vbox = $formDinSwitch->getAdiantiObj();
        $vbox->add($this->form);
        
        parent::add($vbox);
    }

    /**
     * Get the post data
     */
    public function onSend($param)
    {
        try{
        // run form validation
        $this->form->validate();

        $data = $this->form->getData();
        $this->form->setData($data);
        
        new TMessage('info', str_replace(',', '<br>', json_encode($data)));
        } catch (Exception $e){
            new TMessage('error', json_encode($e->getMessage()) );
        }
    }

}