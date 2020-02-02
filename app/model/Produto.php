<?php
/**
 * Produto Active Record
 * @author  <your-name-here>
 */
class Produto extends TRecord
{
    const TABLENAME = 'produto';
    const PRIMARYKEY= 'idproduto';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    private $marca;
    private $tipo;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nom_produto');
        parent::addAttribute('modelo');
        parent::addAttribute('versao');
        parent::addAttribute('idmarca');
        parent::addAttribute('idtipo_produto');
    }

    
    /**
     * Method set_marca
     * Sample of usage: $produto->marca = $object;
     * @param $object Instance of Marca
     */
    public function set_marca(Marca $object)
    {
        $this->marca = $object;
        $this->idmarca = $object->id;
    }
    
    /**
     * Method get_marca
     * Sample of usage: $produto->marca->attribute;
     * @returns Marca instance
     */
    public function get_marca()
    {
        // loads the associated object
        if (empty($this->marca))
            $this->marca = new Marca($this->idmarca);
    
        // returns the associated object
        return $this->marca;
    }
    
    
    /**
     * Method set_tipo
     * Sample of usage: $produto->tipo = $object;
     * @param $object Instance of Tipo
     */
    public function set_tipo(Tipo $object)
    {
        $this->tipo = $object;
        $this->idtipo = $object->id;
    }
    
    /**
     * Method get_tipo
     * Sample of usage: $produto->tipo->attribute;
     * @returns Tipo instance
     */
    public function get_tipo()
    {
        // loads the associated object
        if (empty($this->tipo))
            $this->tipo = new Tipo($this->idtipo_produto);
    
        // returns the associated object
        return $this->tipo;
    }
    


}
