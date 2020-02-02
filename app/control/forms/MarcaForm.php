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

        $nom_marcaLabel = 'Nome';
        $formDinTextField = new TFormDinTextField('nom_marca',$nom_marcaLabel,3,true,null,'um nome para a Marca');
        $nom_marca = $formDinTextField->getAdiantiObj();
               
        // add the form fields
        $this->form->addFields( [new TLabel($nom_marcaLabel, 'red')],    [$nom_marca] );
        
        // create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        
        // add the columns
        $col_id    = new TDataGridColumn('idmarca', 'id', 'right');
        $col_name  = new TDataGridColumn('nom_marca', 'Nome', 'left');
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_name);
        $this->datagrid->addColumn(new TDataGridColumn('pessoa->nome', 'Pessoa'));
        
        $col_id->setAction( new TAction([$this, 'onReload']),   ['order' => 'idmarca']);
        $col_name->setAction( new TAction([$this, 'onReload']), ['order' => 'nom_marca']);
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'],   ['key' => '{idmarca}'] );
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{idmarca}'] );
        
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