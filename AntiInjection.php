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
        $this->limpa = str_ireplace(";", "", $frase);
        $this->limpa = str_ireplace("--", "", $this->limpa);
        $this->limpa = str_ireplace("/*", "", $this->limpa);
        $this->limpa = str_ireplace("*/", "", $this->limpa);
        $this->limpa = htmlentities($this->limpa, ENT_QUOTES);
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