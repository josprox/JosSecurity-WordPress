<?php
/*
Plugin Name: JosSecurity
Plugin URL: https://jossecurity.josprox.com/
Description: Agrega todas las funcionabilidades de JosSecurity en wordpress, se incluirá not pay, head, footer, etc.
Version: 1.8.2
Author: Jose Luis Melchor Estrada
Author URI: https://josprox.com/
*/
if(file_exists(__DIR__ . DIRECTORY_SEPARATOR ."../../../../jossecurity.php")){
    include (__DIR__ . DIRECTORY_SEPARATOR ."../../../../jossecurity.php");
}

function jossecurity_admin_menu() { 
    add_options_page( 'JosSecurity', 'JosSecurity', 'manage_options', 'jossecurity-wp', 'jossecurity_init' );
}
function jossecurity_mensaje(){
    ?>
    <div class="contenedor">
        <center><h1 style="color: #fff;" class="text-shadow-black"><i class="fa-solid fa-shield-halved"></i> JosSecurity</h1></center>
        <p>El sistema de JosSecurity está funcionando de manera correcta, no tendrás que hacer nada al respecto mas que administrar todo desde el panel de control que viene por defecto al instalarlo.</p>
        <?php
        if(!file_exists(__DIR__ . DIRECTORY_SEPARATOR . "smtp/wp-mail.php")){?>
        <p>Este sistema puede configurar el servidor SMTP que registraste al instalar JosSecurity, con él no debería recibir ningún problema, en el caso que sí lo reciba favor de instalar algún otro plugin, automáticamente el sistema lo detectará y dejará de funcionar el sistema smtp de JosSecurity dentro de WordPress pero no dentro de JosSecurity.</p>
        <?php
        }else{
            ?>
        <p>El sistema SMTP se encuentra activado.</p>
            <?php
        }
        if(!isset($_POST['enviar'])){
        ?>
        <form action="" method="post">
            <div class="flex_center">
                <div class="mb-3">
                    <label for="opcion" class="form-label">¿Qué desea hacer?</label>
                    <select class="form-select form-select-lg" name="opcion" id="opcion">
                        <option selected>Selecciona una</option>
                        <option value="CUW">Crear un usuario para wordpress</option>
                        <option value="GLA">Generar llave alteratorio</option>
                        <?php
                        if (leer_tablas_mysql_custom("SELECT * FROM not_pay") >= 1){
                            ?>
                            <option value="DP">Desactivar didn´t pay</option>
                            <?php
                        }
                        if(!file_exists(__DIR__ . DIRECTORY_SEPARATOR . "smtp/wp-mail.php")){
                            ?>
                            <option value="CSMTP">Activar el sistema SMTP configurado previamente en el sistema JosSecurity</option>
                            <?php
                        }else{
                            ?>
                        <option value="DSMTP">Desactivar el sistema SMTP configurado previamente en el sistema JosSecurity</option>
                        <option value="ECW">Hacer prueba de envíos de correo con WordPress</option>
                            <?php
                        }
                        ?>
                        <option value="ECJ">Hacer prueba de envíos de correo con JosSecurity</option>
                    </select>
                </div>
            </div>
            <div class="flex_center">
                <button type="submit" name="enviar" class="btn btn-primary">Ejecutar</button>
            </div>
        </form>
        <?php
        }
        ?>
    </div>
    <?php
    require_once (__DIR__ . DIRECTORY_SEPARATOR . "basic/opciones.php");
    require_once (__DIR__ . DIRECTORY_SEPARATOR . "basic/solicitudes_secundarias.php");
}
function jossecurity_init(){
    jossecurity_mensaje();
}

if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . "smtp/wp-mail.php")){
    include (__DIR__ . DIRECTORY_SEPARATOR . "smtp/wp-mail.php");
}

add_action('admin_menu', 'jossecurity_admin_menu');
add_action('admin_head', 'head_admin');
add_action('admin_footer', 'footer_admin');
add_action('wp_head', 'head');
add_action('wp_footer', 'footer');
?>