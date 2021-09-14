<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site de Projetos da in9" />

    <title>Gerardor de cardápio pR whatsapp</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora&family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="assets/css/style.css" media="all" />
</head>
<body>


<h1>CASA GOURMET</h1>
<h2>Gerador de cardápio</h2>
<form id="gerador" method="post">
    <p class="telefone">
        <input type="number" name="tel" value="<?php echo ( isset( $_REQUEST['tel'] ) ) ? $_REQUEST['tel'] : '21980903244'; ?>">
    </p>
    <fieldset>
        <legend>Saudação inicial</legend>
        <p class="form-fiel field-textarea">
            <textarea name="saudacao" rows="3" cols="80"><?php echo ( isset( $_REQUEST['saudacao'] ) && $_REQUEST['saudacao'] != '' ) ? $_REQUEST['saudacao'] : 'Bom dia'; ?></textarea>
        </p>
        <p class="form-fiel field-select">
            <label>Separador de linhas</label>
            <?php $separador_before = isset( $_REQUEST['separador_before'] ) ? $_REQUEST['separador_before'] : 'linha'; ?>
            <select name="separador_before">
                <option value="linha"<?php echo ($separador_before == 'linha') ? ' selected' : ''; ?>>Linha em branco</option>
                <option value="================================="<?php echo ($separador_before == "=================================") ? ' selected' : ''; ?>>==</option>
                <option value="---------------------------------"<?php echo ($separador_before == "---------------------------------") ? ' selected' : ''; ?>>--</option>
            </select>
        </p>
    </fieldset>
    <div id="pratos">
        <?php
            $campos = ( !empty($_REQUEST) ) ? count($_REQUEST['prato']) : 1;

            for( $n = 0; $n < $campos; $n++ ){ ?>
                <fieldset class="prato">
                    <p class="form-fiel field-text">
                        <label>Nome do prato <span class="req">*</span>
                            <input type="text" name="prato[0][nome_do_prato]" value="<?php echo isset( $_REQUEST['prato'][$n]['nome_do_prato'] ) ? $_REQUEST['prato'][$n]['nome_do_prato'] : ''; ?>" required placeholder="Nome do prato">
                        </label>
                    </p>
                    <p class="form-fiel field-text">
                        <label>Descrição do prato <span class="req">*</span>
                            <input type="text" name="prato[0][prato_description]" value="<?php echo isset( $_REQUEST['prato'][$n]['prato_description'] ) ? $_REQUEST['prato'][$n]['prato_description'] : ''; ?>" required placeholder="Acompanhamento">
                        </label>
                    </p>
                    <p class="form-fiel field-text">
                        <label>Preços <span class="req">*</span>
                            <textarea rows="3" cols="80" name="prato[0][precos]"><?php echo isset( $_REQUEST['prato'][$n]['prato_description'] ) ? $_REQUEST['prato'][$n]['prato_description'] : "Pequena: R$ 10,00 \nGrande: 15,00"; ?></textarea>
                        </label>
                    </p>
                    <p class="form-fiel field-select">
                        <label>Separador de linhas</label>
                        <?php $select = isset( $_REQUEST['prato'][$n]['separador'] ) ? $_REQUEST['prato'][$n]['separador'] : 'linha'; ?>
                        <select name="prato[0][separador]">
                            <option value="linha"<?php echo ($select == 'linha') ? ' selected' : ''; ?>>Linha em branco</option>
                            <option value="================================="<?php echo ($select == "===========================") ? ' selected' : ''; ?>>==</option>
                            <option value="---------------------------------"<?php echo ($select == "---------------------------") ? ' selected' : ''; ?>>--</option>
                        </select>
                    </p>
                </fieldset>
            <?php } ?>
    </div>




    <p class="form-fiel field-button-add">
        <button type="button" id="add-prato" name="add-prato">Adicionar prato</button>
    </p>
    <fieldset>
        <legend>Considerações finais</legend>
        <p class="form-fiel field-textarea">
            <textarea rows="3" cols="80" name="fechamento"><?php echo ( isset( $_REQUEST['fechamento'] ) && $_REQUEST['fechamento'] != '' ) ? $_REQUEST['fechamento'] : 'Um ótimo dia a todos e um bom apetite!!!'; ?></textarea>
        </p>
    </fieldset>
    <p class="form-fiel field-button">
        <button type="submit" name="gerar-cardapio">Gerar Cardápio</button>
    </p>
</form>


<?php
    $resultado  = '';

    if( isset( $_REQUEST['gerar-cardapio'] ) ){

        $resultado  .= $_REQUEST['saudacao']."\n";

        if( isset( $_REQUEST['separador_before'] ) && $_REQUEST['separador_before'] == 'linha' ){
            $resultado .= "\n";
        } else {
            $resultado .= $_REQUEST['separador_before'] . "\n";
        }

        foreach( $_REQUEST['prato'] as $field ){

            if( $field['nome_do_prato'] ){
                $resultado .= "<b>".trim($field['nome_do_prato'])."</b>\n";
            }
            if( $field['prato_description'] ){
                $resultado .= "<em>".trim($field['prato_description'])."</em>\n";
            }
            if( $field['precos'] ){
                $resultado .= trim($field['precos'])."\n";
            }
            if( $field['separador'] == 'linha' ){
                $resultado .= "\n";
            } else {
                $resultado .= $field['separador'] . "\n";
            }
        }

        if( isset( $_REQUEST['fechamento'] ) && $_REQUEST['fechamento'] != '' ){
            $resultado .= $_REQUEST['fechamento'];
        }


        $tel = isset( $_REQUEST['tel'] ) && $_REQUEST['tel'] != '' ? $_REQUEST['tel'] : '21980903244';
    ?>
            <div id="resultado-popup">
                <h3>Resultado</h3>
                <a id="close-popup" href="#"><img src="assets/images/close.svg" width="20" height="20" /></a>
                <pre id="resultado"><code><?php echo $resultado; ?></code></pre>

                <?php
                    /**
                     * Transformando as tags html em markdown do whatsapp.
                     */
                    $shortcode_array = array(
                        "<b>"  => '*',
                        "</b>" => '*',
                        "<em>" => '_',
                        "</em>" => '_',
                    );
                    $resultado = strtr($resultado, $shortcode_array);
                ?>

                <p id="whatsapp-action">
                    <a class="button" href="https://wa.me/55<?php echo $tel; ?>?text=<?php echo rawurlencode(trim(strip_tags($resultado))); ?>" target="_blank">Enviar para o whatsapp</a>
                    <a class="button" href="https://web.whatsapp.com/send?phone=55<?php echo $tel; ?>&text=<?php echo rawurlencode(trim(strip_tags($resultado))); ?>" target="_blank">Enviar para o whatsapp</a>
                </p>
            </div>
        <?php
    }
?>

    <script type="text/javascript" src="assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="assets/js/script-main.js"></script>
</body>
</html>