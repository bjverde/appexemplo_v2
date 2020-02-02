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
    
    private $uf;
    
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

    /**
    * Atribui uma Regiao
    * @param $regiao Objeto da classe Regiao
    */
    public function set_uf(Uf $uf)
    {
        $this->uf = $uf; // armazena o objeto
        $this->uf = $uf->cod_uf; // armazena o ID do objeto
    }

    /**
    * Retorna a Regiao associada
    * @return Objeto da classe Regiao
    */
    public function get_uf()
    {
        if (empty($this->uf)){
            $this->uf = new Uf($this->cod_uf);
        }
        return $this->uf;
    }

}
