<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/rss.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>Lector de feeds</title>
</head>
<body>
    <!--Encabezado-->
    <div class="logo">
        <img src="./img/logo.png" alt="lol">
    </div>    
    
    <?php
    //URL a leer por defecto
    $url = "http://feeds.weblogssl.com/xataka2";
    if(isset($_POST['submit'])){
        if($_POST['feedurl'] != ''){
            $url = $_POST['feedurl'];
        }
    }
    $invalidurl = false;
    //Comprobamos si la URL es correcta. 
    if(@simplexml_load_file($url)){
        $feeds = simplexml_load_file($url);
    }else{
        $invalidurl = true;
        echo '<h2>URL de feed RSS incorrecto.</h2>';
        echo '<h3>No te olvides de incluir el protocolo http(s)</h3>';
    }
    $i=0;
    //Comprobamos si la URL está vacía. Continúa si no está vacía. De lo contrario pasa al else.
    if(!empty($feeds)){
        //Descripción del canal
        $site = $feeds->channel->title;
        $sitelink = $feeds->channel->link;
        //Por cada noticia:
        foreach ($feeds->channel->item as $item) {
            //Creamos variables con información de la noticia
            $title = $item->title;
            $link = $item->link;
            $description = $item->description;
            $postDate = $item->pubDate;
            $pubDate = date('D, d M Y',strtotime($postDate));
            if($i>=20) break; 
            
            echo '<div class="noticia">';  
            echo implode(' ', array_slice(explode(' ', $description), 0, 8)) . "..."; 
            echo '<div>';   
            echo '<h2><a href="'.$link.'">'.$title.'</a></h2>';
            echo '<div>';   
            echo '<span>'.$pubDate.'</span>';
            echo '</div>';   
            echo '</div>';
            echo '</div>';
            
            $i++;
        }
    }else{
        //Error que se muestra si no hay nada que mostrar
        if(!$invalidurl){
            echo '<h2>No se encontró nada que mostrar</h2>';
        }
    }
    ?>

    
</body>
</html>