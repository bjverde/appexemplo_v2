<?php

class TipoForm extends TPage
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
        $this->setActiveRecord('Tipo'); // define the Active Record
        $this->setDefaultOrder('idtipo', 'asc'); // define the default order
        $this->setLimit(-1); // turn off limit for datagrid
        
        // create the form
        $this->form = new BootstrapFormBuilder(__CLASS__);
        $this->form->setFormTitle('Tipo');

        $metaTipoController = new MetaTipoController();
        $listMetaTipo = $metaTipoController->getCombo();

        // create the form fields
        $id     = new TEntry('idtipo');
        $name   = new TEntry('descricao');
        $formDinSelectField = new TFormDinSelectField('idmeta_tipo','Meta Tipo', true, $listMetaTipo);
        $idmeta_tipo = $formDinSelectField->getAdiantiObj();
        $formDinSwitch = new TFormDinSwitch('sit_ativo');
        $sit_ativos = $formDinSwitch->getAdiantiObj();
        
        // add the form fields
        $this->form->addFields( [new TLabel('Cod', 'red')],    [$id] );
        $this->form->addFields( [new TLabel('Nome', 'red')],  [$name] );
        $this->form->addFields( [new TLabel('Meta Tipo', 'red')],  [$idmeta_tipo], [new TLabel('Ativo', 'red')],  [$sit_ativos] );
        
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
        $col_id    = new TDataGridColumn('idtipo', 'Cod', 'right', '10%');
        $col_name  = new TDataGridColumn('descricao', 'Nome', 'left', '90%');
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_name);
        
        $col_id->setAction( new TAction([$this, 'onReload']),   ['order' => 'idtipo']);
        $col_name->setAction( new TAction([$this, 'onReload']), ['order' => 'descricao']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'],   ['key' => '{idtipo}'] );
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{idtipo}'] );
        
        $this->datagrid->addAction($action1, 'Edit',   'far:edit blue');
        $this->datagrid->addAction($action2, 'Delete', 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();

        $panel = new TPanelGroup('Lista de Regiões');
        $panel->add( $this->datagrid );
        //$panel->addFooter('footer');

        $panel->addHeaderActionLink( 'Save as PDF', new TAction([$this, 'exportAsPDF'], ['register_state' => 'false']), 'far:file-pdf red' );
        $panel->addHeaderActionLink( 'Save as CSV', new TAction([$this, 'exportAsCSV'], ['register_state' => 'false']), 'fa:table blue' );

        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
        $vbox->add($panel);
        
        parent::add($vbox);
    }

    /**
     * Export datagrid as PDF
     */
    public function exportAsPDF($param)
    {
        try
        {
            // string with HTML contents
            $html = clone $this->datagrid;
            $contents = file_get_contents('app/resources/styles-print.html') . $html->getContents();
            
            // converts the HTML template into PDF
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($contents);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            $file = 'app/output/datagrid-export.pdf';
            
            // write and open file
            file_put_contents($file, $dompdf->output());
            
            $window = TWindow::create('Export', 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $file;
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    /**
     * Export datagrid as CSV
     */
    public function exportAsCSV($param)
    {
        try
        {
            // get datagrid raw data
            $data = $this->datagrid->getOutputData();
            
            if ($data)
            {
                $file    = 'app/output/datagrid-export.csv';
                $handler = fopen($file, 'w');
                foreach ($data as $row)
                {
                    fputcsv($handler, $row);
                }
                
                fclose($handler);
                parent::openFile($file);
            }
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

}