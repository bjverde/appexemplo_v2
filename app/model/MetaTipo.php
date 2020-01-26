<?php
/**
 * MetaTipo Active Record
 * @author  <your-name-here>
 */
class MetaTipo extends TRecord
{
    const TABLENAME = 'meta_tipo';
    const PRIMARYKEY= 'idMetaTipo';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
        parent::addAttribute('sit_ativo');
    }


}
