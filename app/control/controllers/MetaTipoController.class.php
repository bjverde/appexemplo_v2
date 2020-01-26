<?php
class MetaTipoController
{
    public function selectAll()
    {
        try {
            TTransaction::open('form_exemplo'); // abre uma transação
            $listRegiao = MetaTipo::orderBy('descricao')->load();
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
            $listRegiao[$data['idMetaTipo']]=$data['descricao'];
        }
        return $listRegiao;
    }


}
