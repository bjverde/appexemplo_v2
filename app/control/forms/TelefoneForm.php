<?php

class TelefoneForm extends TPage
{
    protected $form;      // form

    public function __construct()
    {
        parent::__construct();
        
        // create the form
        $this->form = new BootstrapFormBuilder(__CLASS__);
        $this->form->setFormTitle('Testa telefone');
        
        $codLabel = 'Codigo Area';
        $formDinCod = new TFormDinNumericField('code',$codLabel,'2',true,2,null,null,00,99);
        $cod = $formDinCod->getAdiantiObj();

        $telefoneLabel = 'Telefone';
        $formDinTextField = new TFormDinFoneField('tel',$telefoneLabel,true);
        $telefone = $formDinTextField->getAdiantiObj();
        
        // add the form fields
        $this->form->addFields( [new TLabel($codLabel, 'red')],    [$cod], [new TLabel($telefoneLabel, 'red')],  [$telefone] );
        
        // define the form actions
        $this->form->addAction( 'Buscar', new TAction([$this, 'onTelefone']), 'fa:save green');

        // wrap the page content using vertical box
        $formDinSwitch = new TFormDinBreadCrumb(__CLASS__);
        $vbox = $formDinSwitch->getAdiantiObj();
        $vbox->add($this->form);
        
        parent::add($vbox);
    }

    public function onTelefone($param)    
    {           
        if (isset($param))
        {
          $html = $this->getHtml($param['code'],$param['tel']);
          $dom = new DOMDocument();
          $htmlBodyDom = $this->getBodyDom($html,$dom);
          $nodeDom = $this->getElementsByClass($htmlBodyDom, 'div', 'resultado');
          //$stringbody = $dom->saveHTML($nodeDom); //Converte novamente em string
          var_dump($nodeDom);
          exit();
        }
    }

    /**
     * Recebe o numero de telefone e retorna a string html da pagina
     *
     * @param string $code
     * @param string $tel
     * @return string 
     */
    public function getHtml($code,$tel)
    {
        $link = 'https://qualoperadora.info/consulta';
        $dados = array
        (
         'tel'=> preg_replace('/[^0-9]/','',$code.$tel)
         ,'bto'=>'Descobrir Operadora'
        );

        $ch = curl_init($link);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Para funcionar com SSL 
        //https://stackoverflow.com/questions/9774349/php-curl-not-working-with-https
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $dados);

        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }

    /**
     * Pega o conteudo de um HTML
     * https://stackoverflow.com/questions/24415544/php-get-body-from-html-page
     * @param [type] $html
     */
    public function getBodyDom($html,$dom) {      
        
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_use_internal_errors(false);
        $bodies = $dom->getElementsByTagName('body');
        $body = $bodies->item(0);
        //$stringbody = $dom->saveHTML($body); //Converte novamente em string
        //var_dump($stringbody);
        return $body;
      }

      /**
       * Busca a tag com um determinada classe
       * https://stackoverflow.com/questions/20728839/get-element-by-classname-with-domdocument-method
       * @param DOMDocument $parentNode
       * @param string $tagName
       * @param string $className
       * @return array
       */
      public function getElementsByClass(&$parentNode, $tagName, $className) {
        $nodes=array();
    
        $childNodeList = $parentNode->getElementsByTagName($tagName);
        for ($i = 0; $i < $childNodeList->length; $i++) {
            $temp = $childNodeList->item($i);
            if (stripos($temp->getAttribute('class'), $className) !== false) {
                $nodes[]=$temp;
            }
        }
    
        return $nodes;
    }
}