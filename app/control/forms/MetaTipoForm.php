<?php

class MetaTipoForm extends TPage
{
    protected $form;      // form
    protected $datagrid;  // datagrid
    protected $loaded;
    protected $pageNavigation;  // pagination component
    
    use Adianti\Base\AdiantiStandardFormTrait {
		onSave as traitOnSave;
	}
    use Adianti\base\AdiantiStandardListTrait;

    public function __construct()
    {
        parent::__construct();

        $this->setDatabase('form_exemplo'); // define the database
        $this->setActiveRecord('MetaTipo'); // define the Active Record
        $this->setDefaultOrder('idMetaTipo', 'asc'); // define the default order
        $this->setLimit(-1); // turn off limit for datagrid
        
        // create the form
        $frm = new TFormDin('Meta Tipo');
        $frm->addHiddenField('idMetaTipo');
        $descricao = $frm->addTextField('descricao','Descrição',30,true);
        $descricao->setPlaceHolder('Informe uma descrição para o Meta tipo');
        $frm->addSwitchField('sit_ativo','Ativo',true);

        $frm->setAction( 'Save', 'onSave', $this, null, 'fa:save', 'green' );
        $this->form = $frm->show();

        
        // define the form actions
        //$this->form->addAction( 'Save', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink( 'Clear',new TAction([$this, 'onClear']), 'fa:eraser red');

        // make id not editable
        //$id->setEditable(FALSE);
        
        // create the datagrid
        $formDinGrid = new TFormDinGrid($this,__CLASS__,'Lista de Meta Tipos','idMetaTipo');
        $formDinGrid->addColumn('idMetaTipo', 'Cod', 'right');
        $formDinGrid->addColumn('descricao', 'Nome');
        $columnAtivo = $formDinGrid->addColumn('sit_ativo', 'Ativo');
        $columnAtivo->setTransformer( function ($value) {
            if ($value=='S')
            {
                return "Sim";
            }else{
                return "Não";
            }
            return $value;
        });
        $this->datagrid = $formDinGrid->getAdiantiObj();
        
        // define row actions
        $action1 = new TDataGridAction([$this, 'onEdit'],   ['key' => '{idMetaTipo}'] );
        $action2 = new TDataGridAction([$this, 'onDelete'], ['key' => '{idMetaTipo}'] );
        $action2->class='btn btn-default btn-sm';
        $action2->style='float:right;';
        $action2->setLabel('Delete');
        $action2->setImage('far:edit blue');
        
        $this->datagrid->addAction($action1, 'Edit',   'far:edit blue');
        $this->datagrid->addAction($action2, 'Delete', 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();

        $panel = new TPanelGroup('Lista de Meta Tipos');
        $panel->add( $this->datagrid );
        //$panel->addFooter('footer');

        $panel->addHeaderActionLink( 'Save as PDF', new TAction([$this, 'exportAsPDF'], ['register_state' => 'false']), 'far:file-pdf red' );
        $panel->addHeaderActionLink( 'Save as CSV', new TAction([$this, 'exportAsCSV'], ['register_state' => 'false']), 'fa:table blue' );

        // wrap the page content using vertical box
        $formDinSwitch = new TFormDinBreadCrumb(__CLASS__);
        $vbox = $formDinSwitch->getAdiantiObj();
        $vbox->add($this->form);
        $vbox->add($panel);
        
        parent::add($vbox);
    }

    function onSave()
    {
        $this->traitOnSave();
        $this->clear();
    }

    /**
     * Clear filters
     */
    function clear()
    {
        $this->clearFilters();
        $this->onReload();
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