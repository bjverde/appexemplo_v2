<?php
/**
 * Regiao Active Record
 * @author  <your-name-here>
 */
class Regiao extends TRecord
{
    const TABLENAME = 'regiao';
    const PRIMARYKEY= 'cod_regiao';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    private $uf;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nom_regiao');
    }

    
    /**
     * Method set_uf
     * Sample of usage: $regiao->uf = $object;
     * @param $object Instance of Uf
     */
    public function set_uf(Uf $object)
    {
        $this->uf = $object;
        $this->cod_uf = $object->id;
    }
    
    /**
     * Method get_uf
     * Sample of usage: $regiao->uf->attribute;
     * @returns Uf instance
     */
    public function get_uf()
    {
        // loads the associated object
        if (empty($this->uf))
            $this->uf = new Uf($this->cod_uf);
    
        // returns the associated object
        return $this->uf;
    }
    


}
