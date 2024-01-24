<?php
/*
* Uso: Usar os métodos públicos estáticos da classe, por exemplo:
*
* $l = AntiInjection::campo($login);
* $s = AntiInjection::campo($senha);
*
* O método texto é pra áreas de texto, o campo é para inputs como text e password, o numero é para números inteiros.
*
* A classe limpa strings para evitar SQL Injection e Ataques XSS.
*/

<?php
class AntiInjection {
    private static $limpa;
    private static $inteiro;
    private static $listaNegra = array("select", "update", "drop", "truncate", "insert", "delete", "alter", "from", "where", "table", "tables", "database", "union", "--", "%", "<", ">", "[", "]", ":", "?", "`", "|", "*");

    public static function texto($frase) : string {
        self::$limpa = str_ireplace(";", "&#59;", $frase);
        self::$limpa = str_ireplace("--", "&#45;&#45;", self::$limpa);
        self::$limpa = str_ireplace("*", "&#42;", self::$limpa);
        self::$limpa = str_ireplace("=", "&#61;", self::$limpa);
        self::$limpa = htmlentities(self::$limpa, ENT_QUOTES);
        self::$limpa = str_ireplace("amp;", "", self::$limpa);
        self::$limpa = str_ireplace("&&", "&amp;&amp;", self::$limpa);
        self::$limpa = str_ireplace("||", "&#124;&#124;", self::$limpa);
        self::$limpa = str_ireplace("!", "&#33;", self::$limpa);
        self::$limpa = strip_tags(self::$limpa);
        self::$limpa = trim(self::$limpa);

        return self::$limpa;
    }

    public static function campo($frase) : string {
        self::$limpa = self::texto($frase);
        self::$limpa = str_ireplace(self::$listaNegra, "", self::$limpa);

        return self::$limpa;
    }

    public static function numero($num) : int {
        self::$inteiro = (int)self::campo($num);

        return self::$inteiro;
    }
}