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

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nom_regiao');
    }

}
