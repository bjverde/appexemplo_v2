<?php
/**
 * Uf Active Record
 * @author  <your-name-here>
 */
class Uf extends TRecord
{
    const TABLENAME = 'uf';
    const PRIMARYKEY= 'cod_uf';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nom_uf');
        parent::addAttribute('sig_uf');
        parent::addAttribute('cod_regiao');
    }


}
