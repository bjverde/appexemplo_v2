<?php
/**
 * Municipio Active Record
 * @author  <your-name-here>
 */
class Municipio extends TRecord
{
    const TABLENAME = 'municipio';
    const PRIMARYKEY= 'cod_municipio';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cod_uf');
        parent::addAttribute('nom_municipio');
        parent::addAttribute('sit_ativo');
    }


}
