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
        $this->setDefaultOrder('idtipo', 'desc'); // define the default order
        
        //====================================================================
        //             FORMDIN 5 sobre ADIANTI 7.X
        //====================================================================
        $frm = new TFormDin('Tipo');
        $frm->addHiddenField('idtipo');
        $frm->addTextField('descricao','Nome',30,true,3,'aa');

        $metaTipoController = new MetaTipoController();
        $listMetaTipo = $metaTipoController->getCombo();
        $frm->addSelectField('idmeta_tipo','Meta Tipo', true, $listMetaTipo);
        $frm->addSwitchField('sit_ativo','Ativo',true);

        $frm->setAction( 'Save', 'onSave', $this, null, 'fa:save', 'green' );
        $this->form = $frm->show();

        // define the form actions
        //$this->form->addAction( 'Save', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink( 'Clear',new TAction([$this, 'onClear']), 'fa:eraser red');


        
        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // add the columns
        $col_id    = new TDataGridColumn('idtipo', 'Cod', 'right');
        $col_name  = new TDataGridColumn('descricao', 'Nome', 'left');
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_name);
        $this->datagrid->addColumn(new TDataGridColumn('meta_tipo->descricao', 'Meta Tipo'));
        $this->datagrid->addColumn(new TDataGridColumn('sit_ativo', 'Ativo'));
        
        $col_id->setAction( new TAction([$this, 'onReload']),   ['order' => 'idtipo']);
        $col_name->setAction( new TAction([$this, 'onReload']), ['order' => 'descricao']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'],   ['key' => '{idtipo}'] );
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{idtipo}'] );
        
        $this->datagrid->addAction($action1, 'Edit',   'far:edit blue');
        $this->datagrid->addAction($action2, 'Delete', 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload'))); 

        $panel = new TPanelGroup('Lista de Regiões');
        $panel->add( $this->datagrid );
        $panel->addFooter($this->pageNavigation);

        $panel->addHeaderActionLink( 'Save as PDF', new TAction([$this, 'exportAsPDF'], ['register_state' => 'false']), 'far:file-pdf red' );
        $panel->addHeaderActionLink( 'Save as CSV', new TAction([$this, 'exportAsCSV'], ['register_state' => 'false']), 'fa:table blue' );

        // wrap the page content using vertical box
        $formDinSwitch = new TFormDinBreadCrumb(__CLASS__);
        $vbox = $formDinSwitch->getAdiantiObj();
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