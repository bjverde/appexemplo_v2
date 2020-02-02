<?php

class MarcaForm extends TPage
{
    protected $form;      // form
    protected $datagrid;  // datagrid
    protected $loaded;
    protected $pageNavigation;  // pagination component
    
    // trait with onSave, onEdit, onDelete, onReload, onSearch...
    use Adianti\Base\AdiantiStandardFormListTrait;

    public function __construct()
    {
        parent::__construct();

        $this->setDatabase('form_exemplo'); // define the database
        $this->setActiveRecord('Marca'); // define the Active Record
        $this->setDefaultOrder('idmarca', 'asc'); // define the default order
        
        // create the form
        $formDin = new TFormDin(__CLASS__,'Marca');
        $this->form = $formDin->getAdiantiObj();

        // create the form fields
        $t1     = new TEntry('t1');
        $t2     = new TEntry('t2');
        $t3     = new TEntry('t3');
        
        $descricaoLabel = 't1 FormDin';
        $formDinTextField = new TFormDinTextField('t1fd',$descricaoLabel,3,true,null,'xxxxi');
        $descricao = $formDinTextField->getAdiantiObj();
               
        // add the form fields
        $this->form->addFields( [new TLabel('T1, req, min(1), max(3)', 'red')],    [$t1] );
        $this->form->addFields( [new TLabel('T2')],    [$t2] );
        $this->form->addFields( [new TLabel('T3 req, max(5)', 'red')],    [$t3] );
        $this->form->addFields( [new TLabel($descricaoLabel, 'red')],    [$descricao] );
        
        $t1->addValidation('T1', new TMinLengthValidator, array(1));
        $t1->addValidation('T1', new TMaxLengthValidator, array(3));
        $t1->addValidation('T3', new TRequiredValidator);
        
        $t3->addValidation('T3', new TMaxLengthValidator, array(5));
        $t3->addValidation('T3', new TRequiredValidator);
        
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
            new TMessage('error', $e->getMessage() );
        }
    }

}