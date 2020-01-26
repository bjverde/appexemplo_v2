<?php

class UfForm extends TPage
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
        $this->setActiveRecord('Uf'); // define the Active Record
        $this->setDefaultOrder('cod_uf', 'asc'); // define the default order
        $this->setLimit(-1); // turn off limit for datagrid
        
        // create the form
        $this->form = new BootstrapFormBuilder('form_uf');
        $this->form->setFormTitle('Uf');

        // create the form fields
        $id     = new TEntry('cod_uf');
        $name   = new TEntry('nom_uf');
        $tipo_socio = new TCombo('cod_regiao')->addItems($listipoSocio);
        
        // add the form fields
        $this->form->addFields( [new TLabel('Cod', 'red')],    [$id] );
        $this->form->addFields( [new TLabel('Nome', 'red')],  [$name] );
        
        $id->addValidation('Cod', new TRequiredValidator);
        $name->addValidation('Name', new TRequiredValidator);
        
        // define the form actions
        $this->form->addAction( 'Save', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink( 'Clear',new TAction([$this, 'onClear']), 'fa:eraser red');

        // make id not editable
        //$id->setEditable(FALSE);
        
        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // add the columns
        $col_id    = new TDataGridColumn('cod_uf', 'Cod', 'right', '10%');
        $col_name  = new TDataGridColumn('nom_uf', 'Nome', 'left', '90%');
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_name);
        
        $col_id->setAction( new TAction([$this, 'onReload']),   ['order' => 'cod_regiao']);
        $col_name->setAction( new TAction([$this, 'onReload']), ['order' => 'nom_regiao']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'],   ['key' => '{cod_regiao}'] );
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{cod_regiao}'] );
        
        $this->datagrid->addAction($action1, 'Edit',   'far:edit blue');
        $this->datagrid->addAction($action2, 'Delete', 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();

        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        $vbox->add(TPanelGroup::pack('', $this->datagrid));
        
        parent::add($vbox);
    }
}