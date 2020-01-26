<?php
class RegiaoController
{
    public function selectAll()
    {
        try {
            TTransaction::open('form_exemplo'); // abre uma transação
            $listRegiao = Regiao::All();
            TTransaction::close(); // fecha a transação.
            return $listRegiao;
        }
        catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }


}
