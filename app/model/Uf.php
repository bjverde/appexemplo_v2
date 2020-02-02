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

    private $regiao;
    
    
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

    /**
    * Atribui uma Regiao
    * @param $regiao Objeto da classe Regiao
    */
    public function set_regiao(Regiao $regiao)
    {
        $this->regiao = $regiao; // armazena o objeto
        $this->regiao = $regiao->id; // armazena o ID do objeto
    }

    /**
    * Retorna a Regiao associada
    * @return Objeto da classe Regiao
    */
    public function get_regiao()
    {
        if (empty($this->regiao)){
            $this->regiao = new Regiao($this->cod_regiao);
        }
        return $this->regiao;
    }


}
