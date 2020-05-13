<?php
/**
 * SystemProgram Active Record
 * @author  <your-name-here>
 */
class SystemProgram extends TRecord
{
    const TABLENAME = 'system_program';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('name');
        parent::addAttribute('controller');
    }


}
