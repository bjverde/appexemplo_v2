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
        
        //====================================================================
        //             FORMDIN 5 sobre ADIANTI 7.X
        //====================================================================
        $frm = new TFormDin('Região');
        
        $frm->addTextField('cod_uf','Cod',30,true);
        $frm->addTextField('nom_uf','Nome',30,true);
        $frm->addTextField('sig_uf','Sigla',30,true);

        $regiaoController = new RegiaoController();
        $listRegiao = $regiaoController->getCombo();
        $frm->addSelectField('cod_regiao','Região', true, $listRegiao);

        $frm->setAction( 'Save', 'onSave', $this, null, 'fa:save', 'green' );
        $this->form = $frm->show();
        $this->form->addActionLink( 'Clear',new TAction([$this, 'onClear']), 'fa:eraser red');

        //====================================================================
        //             FORM ADIANTI 7.X PADAO
        //====================================================================  
        /*
        $this->form = new BootstrapFormBuilder('form_uf');
        $this->form->setFormTitle('Uf');

        $regiaoController = new RegiaoController();
        $listRegiao = $regiaoController->getCombo();

        // create the form fields
        $id     = new TEntry('cod_uf');
        $name   = new TEntry('nom_uf');
        $sig_uf   = new TEntry('sig_uf');
        $cod_regiao = new TCombo('cod_regiao');
        $cod_regiao->addItems($listRegiao);
        
        
        // add the form fields
        $this->form->addFields( [new TLabel('Cod', 'red')],    [$id] );
        $this->form->addFields( [new TLabel('Nome', 'red')],  [$name] );
        $this->form->addFields( [new TLabel('Sigla', 'red')],  [$sig_uf], [new TLabel('Região', 'red')],  [$cod_regiao] );
        
        $id->addValidation('Cod', new TRequiredValidator);
        $name->addValidation('Name', new TRequiredValidator);
        //$name->addValidation('Sigla', new TRequiredValidator);        
        // define the form actions
        $this->form->addAction( 'Save', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink( 'Clear',new TAction([$this, 'onClear']), 'fa:eraser red');

        // make id not editable
        //$id->setEditable(FALSE);
        */
        
        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // add the columns
        $col_id   = new TDataGridColumn('cod_uf', 'Cod', 'right', '10%');
        $col_name = new TDataGridColumn('nom_uf', 'Nome','left');
        $sig_uf   = new TDataGridColumn('sig_uf', 'Sigla','left');
        $cod_regiao = new TDataGridColumn('regiao->nom_regiao', 'Região','left');
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_name);
        $this->datagrid->addColumn($sig_uf);
        $this->datagrid->addColumn($cod_regiao);
        
        $col_id->setAction( new TAction([$this, 'onReload']),   ['order' => 'cod_regiao']);
        $col_name->setAction( new TAction([$this, 'onReload']), ['order' => 'nom_regiao']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'],   ['key' => '{cod_uf}'] );
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{cod_uf}'] );
        
        $this->datagrid->addAction($action1, 'Edit',   'far:edit blue');
        $this->datagrid->addAction($action2, 'Delete', 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));        

        $panel = new TPanelGroup('Lista de UF');
        $panel->add( $this->datagrid );
        $panel->addFooter($this->pageNavigation);
        
        //$panel->addHeaderActionLink( 'Save as PDF', new TAction([$this, 'exportAsPDF'], ['register_state' => 'false']), 'far:file-pdf red' );
        //$panel->addHeaderActionLink( 'Save as CSV', new TAction([$this, 'exportAsCSV'], ['register_state' => 'false']), 'fa:table blue' );

        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        $vbox->add($panel);
        
        parent::add($vbox);
    }
}