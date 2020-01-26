<?php
class RegiaoController
{
    public function selectAll()
    {
        try {
            TTransaction::open('form_exemplo'); // abre uma transação
            $listRegiao = Regiao::orderBy('nom_regiao')->load();
            TTransaction::close(); // fecha a transação.
            return $listRegiao;
        }
        catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }

    public function getCombo()
    {
        $listRegiaoObj = $this->selectAll();
        $listRegiao = array();
        foreach ($listRegiaoObj as $obj) {
            $data = $obj->toArray();
            $listRegiao[$data['cod_regiao']]=$data['nom_regiao'];
        }
        return $listRegiao;
    }


}
