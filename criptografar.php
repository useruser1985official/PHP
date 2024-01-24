<?php
/*
* Uso: Usar o método para criptografar a senha
*
* $senhaSalgada = criptografar("senha", "sal");
*
* Ele gerará um hash único, diferente do que apenas passar o hash uma vez com a senha e sal juntos.
*
* O segundo parâmetro é opcional, ele não salgará a senha caso ele não seja passado.
*/

function criptografar($texto, $sal = "") {
    $texto = trim($texto);
    $sal = trim($sal);

    if($texto == "") {
        throw new Exception("Passe um Valor em Texto!");
    }

    $hashTex = hash("sha1", $texto);
    $hashSal = "";

    if($sal != "") {
        $hashSal = hash("md5", $sal);
    }

    $cript = hash("sha256", $hashTex . $hashSal);

    return $cript;
}