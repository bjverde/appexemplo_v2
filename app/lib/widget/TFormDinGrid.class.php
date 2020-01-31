<?php

class TFormDinGrid
{
    protected $adiantiObj;

    protected $idGrid;
    protected $title;
    protected $key;
    
    /**
     * Grid Padronizado em BoorStrap
     * Reconstruido FormDin 4 Sobre o Adianti 7
     *
     * @param string $strName       - 1: ID do Grid
     * @param string $strTitle      - 2: Titulo do Grid
     * @param string $strKeyField   - 3: Id da chave primaria
     * @return BootstrapFormBuilder
     */
    public function __construct(string $idGrid
                               ,string $title
                               ,string $key)
    {
        $this->adiantiObj = new BootstrapDatagridWrapper(new TDataGrid);
        $this->adiantiObj->width = '100%';
        $this->setIdGrid($idGrid);
        $this->setTitle($title);
        $this->setKey($key);
        return $this->getAdiantiObj();
    }

    public function getAdiantiObj(){
        $title = $this->getTitle();
        $panel = new TPanelGroup($title);
        $panel->add( $this->adiantiObj );
        return $panel;
    }

    /**
     * Inclui uma nova coluna
     * @param  string $name  = Name of the column in the database
     * @param  string $label = Text label that will be shown in the header
     * @param  string $align = Column align (left, center, right)
     * @param  string $width = Column Width (pixels)
     */
    public function addColumn($name, $label, $align='left', $width = NULL){
        $column = new TDataGridColumn($name, $label, $align, $width);
        $column->setAction( new TAction([$this, 'onReload']),   ['order' => $name]);
        $this->adiantiObj->addColumn($column);
        return $this->idGrid;
    }

    public function getIdGrid(){
        return $this->idGrid;
    }

    public function setIdGrid(string $idGrid){
        $this->idGrid = $idGrid;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle(string $title){
        $this->title = $title;
    }

    public function getKey(){
        return $this->key;
    }

    public function setKey(string $key){
        $this->key = $key;
    }
}