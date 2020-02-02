<?php
/**
 * Tipo Active Record
 * @author  <your-name-here>
 */
class Tipo extends TRecord
{
    const TABLENAME = 'tipo';
    const PRIMARYKEY= 'idtipo';
    const IDPOLICY =  'serial'; // {max, serial}
    
    
    private $meta_tipo;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('descricao');
        parent::addAttribute('idmeta_tipo');
        parent::addAttribute('sit_ativo');
    }

    
    /**
     * Method set_meta_tipo
     * Sample of usage: $tipo->meta_tipo = $object;
     * @param $object Instance of MetaTipo
     */
    public function set_meta_tipo(MetaTipo $object)
    {
        $this->meta_tipo = $object;
        $this->meta_tipo_id = $object->id;
    }
    
    /**
     * Method get_meta_tipo
     * Sample of usage: $tipo->meta_tipo->attribute;
     * @returns MetaTipo instance
     */
    public function get_meta_tipo()
    {
        // loads the associated object
        if (empty($this->meta_tipo))
            $this->meta_tipo = new MetaTipo($this->idmeta_tipo);
    
        // returns the associated object
        return $this->meta_tipo;
    }
    


}
