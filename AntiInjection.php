<?php
/*
* Uso: Criar objeto dessa classe e usar os métodos públicos, por exemplo:
*
* $anti = new AntiInjection();
*
* $anti->campo($login);
* $anti->campo($senha);
*
* O método texto é pra áreas de texto, o campo é para inputs como text e password, o numero é para números inteiros.
*
* A classe limpa strings para evitar SQL Injection e Ataques XSS.
*/

class AntiInjection {
    private $limpa;
    private $inteiro;
    private static $listaNegra = array("select", "update", "drop", "truncate", "insert", "delete", "alter", "from", "where", "table", "tables", "database", "union", "--", "%", "<", ">", "[", "]", ":", "?", "`", "|", "*");

    public function texto($frase) : string {
        $this->limpa = str_ireplace(";", "&#59;", $frase);
        $this->limpa = str_ireplace("--", "&#45;&#45;", $this->limpa);
        $this->limpa = str_ireplace("*", "&#42;", $this->limpa);
        $this->limpa = str_ireplace("=", "&#61;", $this->limpa);
        $this->limpa = htmlentities($this->limpa, ENT_QUOTES);
        $this->limpa = str_ireplace("amp;", "", $this->limpa);
        $this->limpa = str_ireplace("&&", "&amp;&amp;", $this->limpa);
        $this->limpa = str_ireplace("||", "&#124;&#124;", $this->limpa);
        $this->limpa = str_ireplace("!", "&#33;", $this->limpa);
        $this->limpa = strip_tags($this->limpa);
        $this->limpa = trim($this->limpa);

        return $this->limpa;
    }

    public function campo($frase) : string {
        $this->limpa = $this->texto($frase);
        $this->limpa = str_ireplace(self::$listaNegra, "", $this->limpa);

        return $this->limpa;
    }

    public function numero($num) : int {
        $this->inteiro = (int)$this->campo($num);

        return $this->inteiro;
    }
}