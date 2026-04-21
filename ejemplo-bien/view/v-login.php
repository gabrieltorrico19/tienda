<?php

/**
 * @author		Miguel Angel Macias Burgos
 * @company 	WBT
 * @copyright 	2026
 * @version     1.0
 */



?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv='content-type' content='text/html' charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />
    
	<title><?php echo $appTitle; ?></title>
        
    <!-- CSS -->
    <link rel='stylesheet' href='../view/css/main.css' />
</head>

<body>

<!-- Main Page -->
<div class='ctn-form'>
    <!-- Header -->
    <div class='form-header'>
        <div class='ctn-icon'><div class='icon'></div></div>
        <div class='form-title'><?php echo $appTitle; ?></div>
        <div class='form-subtitle'><?php echo $appSubtitle ?></div>
        <div class='bar'><div class='step'></div></div>        
        <a href='index.php'><div class='btn-back'></div></a>
    </div>
    <!-- Body -->
    <div class='form-content'>
            <form action='c-auth.php' method='POST'> 
                                
                <div class='x-2'>                
                    <input type='text' name='user' placeholder="Ingrese su nombre de usuario">
                    <div class='label'>Username</div>
                </div>
                <div class='x-2'>                
                    <input type='password' name='pass' placeholder="Ingrese su contraseña">
                    <div class='label'>Constraseña</div>
                </div>
                <div class='x-1'>                
                    <input type='submit' value='Ingresar'>
                </div>
            </form>
        <div class='clear'></div>
    </div>
</div>

</body>
</html>