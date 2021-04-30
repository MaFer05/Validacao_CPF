<?php
/* Código/script de validação para CPFs*/
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resultado = 'Válido';
    $invalidos = [];
    for($i = 1; $i < 10;$i++) {
        $val = '';
        for($j = 0;$j < 11; $j++)
            $val .= $i;
        $invalidos[] =$val;
    }
    $cpf = $_POST['cpf'];
    if(in_array($cpf, $invalidos))
        $resultado = 'Inválido';
    if($resultado == 'Válido') {
        foreach(str_split($cpf) as $d)
            if (!is_numeric($d))
                $resultado = 'Inválido';
    }

    if($resultado == 'Válido') {
        $multiplicador = 10;
        $soma = 0;
        for($i = 0;$i < 9;$i++)
            $soma += $cpf[$i] * $multiplicador--;
        $resto = ($soma * 10) % 11;
        $digito = 0;
        if($resto < 10)
            $digito = $resto;

        if($cpf[9] != $digito)
            $resultado = 'Inválido';

        $log = ['soma' => $soma, 'resto' => $resto, 'digito' => $digito, 'resultado' => $resultado];
    }

    if($resultado == 'Válido') {
        $multiplicador = 11;
        $soma = 0;
        for($i = 0;$i < 10;$i++)
            $soma += $cpf[$i] * $multiplicador--;
        $resto = ($soma * 10) % 11;
        $digito = 0;
        if($resto < 10)
            $digito = $resto;
        
        if($cpf[10] != $digito)
            $resultado = 'Inválido';

        $log2 = ['soma' => $soma, 'resto' => $resto, 'digito' => $digito, 'resultado' => $resultado];
    }
}
/* O modelo de um CPF é: "###.###.###-##"
 *Nos códigos anteriores fizemos a validação que ocorre em duas etapas sendo que o primeiro valor
 * calculado (Dígito 10) é utilizado no cálculo do segundo (Dígito 11)*/
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Validação CPF</title>
    </head>
    <body>
        <form action="index.php" method="post">
            <label for="cpf">CPF: </label>
            <input type="text" name="cpf" />
            <button type="submit">Validar</button>
        </form>
        <hr />
        <?php if(isset($resultado)): ?>
            <p>O CPF "<?= $cpf ?>" é <?= $resultado ?></p>

            <pre>
                <?php print_r($log) ?>

                <?php print_r($log2) ?>

                <?php print_r($invalidos) ?>
            </pre>
        <?php endif ?>
    </body>
</html>