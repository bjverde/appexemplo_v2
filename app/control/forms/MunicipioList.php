<?php
/**
 * MunicipioList Listing
 * @author  <your name here>
 */
class MunicipioList extends TPage
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    protected $formgrid;
    protected $deleteButton;
    
    use Adianti\base\AdiantiStandardListTrait;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('form_exemplo');            // defines the database
        $this->setActiveRecord('Municipio');   // defines the active record
        $this->setDefaultOrder('cod_municipio', 'asc');         // defines the default order
        $this->setLimit(10);
        // $this->setCriteria($criteria) // define a standard filter

        $this->addFilterField('cod_municipio', 'like', 'cod_municipio'); // filterField, operator, formField
        $this->addFilterField('cod_uf', 'like', 'cod_uf'); // filterField, operator, formField
        $this->addFilterField('nom_municipio', 'like', 'nom_municipio'); // filterField, operator, formField
        $this->addFilterField('sit_ativo', 'like', 'sit_ativo'); // filterField, operator, formField
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_Municipio');
        $this->form->setFormTitle('Municipio');
        

        // create the form fields
        $cod_municipio = new TEntry('cod_municipio');
        $cod_uf = new TDBSelect('cod_uf', 'form_exemplo', 'Uf', 'cod_uf', 'nom_uf');
        $nom_municipio = new TEntry('nom_municipio');
        $sit_ativo = new TEntry('sit_ativo');


        // add the fields
        $this->form->addFields( [ new TLabel('Cod Municipio') ], [ $cod_municipio ] );
        $this->form->addFields( [ new TLabel('Cod Uf') ], [ $cod_uf ] );
        $this->form->addFields( [ new TLabel('Nom Municipio') ], [ $nom_municipio ] );
        $this->form->addFields( [ new TLabel('Sit Ativo') ], [ $sit_ativo ] );


        // set sizes
        $cod_municipio->setSize('100%');
        $cod_uf->setSize('100%');
        $nom_municipio->setSize('100%');
        $sit_ativo->setSize('100%');

        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('New'), new TAction(['MunicipioForm', 'onEdit']), 'fa:plus green');
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        

        // creates the datagrid columns
        $column_cod_municipio = new TDataGridColumn('cod_municipio', 'Cod Municipio', 'right');
        $column_cod_uf = new TDataGridColumn('cod_uf', 'Cod Uf', 'right');
        $column_nom_municipio = new TDataGridColumn('nom_municipio', 'Nom Municipio', 'left');
        $column_sit_ativo = new TDataGridColumn('sit_ativo', 'Sit Ativo', 'left');


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_cod_municipio);
        $this->datagrid->addColumn($column_cod_uf);
        $this->datagrid->addColumn($column_nom_municipio);
        $this->datagrid->addColumn($column_sit_ativo);

        
        $action1 = new TDataGridAction(['MunicipioForm', 'onEdit'], ['cod_municipio'=>'{cod_municipio}']);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['cod_municipio'=>'{cod_municipio}']);
        
        $this->datagrid->addAction($action1, _t('Edit'),   'far:edit blue');
        $this->datagrid->addAction($action2 ,_t('Delete'), 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        
        $panel = new TPanelGroup('', 'white');
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);
        
        // header actions
        $dropdown = new TDropDown(_t('Export'), 'fa:list');
        $dropdown->setPullSide('right');
        $dropdown->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown->addAction( _t('Save as CSV'), new TAction([$this, 'onExportCSV'], ['register_state' => 'false', 'static'=>'1']), 'fa:table blue' );
        $dropdown->addAction( _t('Save as PDF'), new TAction([$this, 'onExportPDF'], ['register_state' => 'false', 'static'=>'1']), 'far:file-pdf red' );
        $panel->addHeaderWidget( $dropdown );
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add($panel);
        
        parent::add($container);
    }
}
