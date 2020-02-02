<?php
/**
 * Marca Active Record
 * @author  <your-name-here>
 */
class Marca extends TRecord
{
    const TABLENAME = 'marca';
    const PRIMARYKEY= 'idmarca';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    private $pessoa;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nom_marca');
        parent::addAttribute('idpessoa');
    }

    
    /**
     * Method set_pessoa
     * Sample of usage: $marca->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_pessoa(Pessoa $object)
    {
        $this->pessoa = $object;
        $this->idpessoa = $object->id;
    }
    
    /**
     * Method get_pessoa
     * Sample of usage: $marca->pessoa->attribute;
     * @returns Pessoa instance
     */
    public function get_pessoa()
    {
        // loads the associated object
        if (empty($this->pessoa))
            $this->pessoa = new Pessoa($this->idpessoa);
    
        // returns the associated object
        return $this->pessoa;
    }
    


}
