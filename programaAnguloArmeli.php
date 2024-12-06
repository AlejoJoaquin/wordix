<?php
include_once("wordix.php");

/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/

/* Angulo Alejo - FAI-5288 - Tecnicatura en Desarrollo Web - alejojoaquin011@gmail.com - Usuario: AnguloJoaquin */
/* Armeli Enzo  - FAI-4038 - Tecnicatura en Desarrollo Web - enzoarmeli@outlook.com - Usuario: enzoarmeli */

/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/

/**
 * Muestra estadísticas de un jugador basado en las partidas jugadas.
 * @param string $nombreJugador Nombre del jugador
 * @param array $partidas Colección de partidas
 */
// Función para calcular estadísticas
function obtenerEstadisticasJugador($nombreJugador, $partidas)
{
    $estadisticas = [
        "nombre" => ucfirst($nombreJugador),
        "partidas" => 0,
        "puntajeTotal" => 0,
        "victorias" => 0,
        "adivinadas" => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
        "porcentajeVictorias" => 0
    ];

    foreach ($partidas as $partida) {
        if (strtolower($partida["jugador"]) === strtolower($nombreJugador)) {
            $estadisticas["partidas"]++;
            $estadisticas["puntajeTotal"] += $partida["puntaje"];
            
            if ($partida["puntaje"] > 0) {
                $estadisticas["victorias"]++;
                $intentos = $partida["intentos"];
                if ($intentos <= 5) {
                    $estadisticas["adivinadas"][$intentos]++;
                }
            }
        }
    }

    if ($estadisticas["partidas"] > 0) {
        $estadisticas["porcentajeVictorias"] = round(($estadisticas["victorias"] / $estadisticas["partidas"]) * 100);
    }

    return $estadisticas;
}

// Función para mostrar las estadísticas
function mostrarEstadisticasJugador($estadisticas)
{
    echo "*******************\n";
    echo "Jugador: " . $estadisticas["nombre"] . "\n";
    echo "Partidas: " . $estadisticas["partidas"] . "\n";
    echo "Puntaje total: " . $estadisticas["puntajeTotal"] . "\n";
    echo "Porcentaje victorias: " . $estadisticas["porcentajeVictorias"] . "%\n";
    echo "Adivinadas:\n";

    foreach ($estadisticas["adivinadas"] as $intento => $cantidad) {
        echo "    Intento $intento: $cantidad\n";
    }

    echo "********************\n";
}

/**
 * Obtiene una colección de palabras
 * @return array $coleccionPalabras
 */
function cargarColeccionPalabras()
{
    //inicializamos el arreglo que contendra las palabras
    $coleccionPalabras = [
        "MUJER", "QUESO", "FUEGO", "CASAS", "RASGO",
        "GATOS", "GOTAS", "HUEVO", "TINTO", "NAVES",
        "VERDE", "MELON", "YUYOS", "PIANO", "PISOS",
        "MOTOS", "COLOR", "ACTOR", "AGUDO", "MUNDO",
    ];
    return $coleccionPalabras;
}

/**
 * Inicializara una coleccion de partidas con ejemplos de partidas y que retornara la coleccion de partidas
 * @return array $coleccionPartidas
 */
function cargarPartidas(){
    //inicializamos el array que contendra las partidas 
    $coleccionPartidas = [
        ["palabraWordix" => "BEBER", "jugador" => "Lautaro", "intentos" => 5, "puntaje" => 14],
        ["palabraWordix" => "NUBES", "jugador" => "Marcos", "intentos" => 1, "puntaje" => 16],
        ["palabraWordix" => "JUGAR", "jugador" => "Enzo", "intentos" => 2, "puntaje" => 20],
        ["palabraWordix" => "RAMAS", "jugador" => "Lucas", "intentos" => 5, "puntaje" => 5],
        ["palabraWordix" => "CAMPO", "jugador" => "Nahuel", "intentos" => 3, "puntaje" => 15],
        ["palabraWordix" => "PLUMA", "jugador" => "Federico", "intentos" => 3, "puntaje" => 13],
        ["palabraWordix" => "PERROS", "jugador" => "Juan", "intentos" => 1, "puntaje" => 25],
        ["palabraWordix" => "HUEVO", "jugador" => "Juliana", "intentos" => 3, "puntaje" => 12],
        ["palabraWordix" => "SALSA", "jugador" => "Antonela", "intentos" => 0, "puntaje" => 0],
        ["palabraWordix" => "RANAS", "jugador" => "Agustin", "intentos" => 3, "puntaje" => 15],
    ];
    return $coleccionPartidas;
}

/**
 * MODULO que muestra al usuario el menu de opciones y le solicitara una opcion valida
 * @param string $usuario
 * @return int $opcion
 */
function seleccionarOpcion(){
    //int $opcion

        //este es el menu de ususario que se le mostrara al usuario
        echo "********** Menu de opciones, seleccione una opcion del 1 al 8 **********\n";
        echo "1. Jugar al wordix con una palabra elegida\n";
        echo "2. Jugar al wordix con una palabra aleatoria\n";
        echo "3. Mostrar partida\n";
        echo "4. Mostrar la primer partida ganada\n";
        echo "5. Mostrar resumen de Jugador\n";
        echo "6. Mostrar listado de partidas ordenadas por jugador y por palabra\n";
        echo "7. Agregar una palabra de 5 letras a Wordix\n";
        echo "8. Salir del menu\n";
        
        //llamamos a la funcion solicitarNumeroEntre para que nos de una opcion valida
        $opcion = solicitarNumeroEntre(1,8);
    
    return $opcion;
}

/**
 * MODULO que dado un numero de partidas, mostrara al usuario en pantalla los datos de la partida
 * @param int $numPartida
 * @param array $coleccionPartidas
 */
function mostrarPartida($numPartida, $coleccionPartidas){
    //int $indice
    //array $partida
    //calcula el indice correspondiente al numero de partida ingresado
    $indice = $numPartida - 1;

    //verifica si el indice esta dentro del rango valido
    if ($indice >= 0 && $indice < count($coleccionPartidas)) {
        //se obtiene la partida correspondiente al indice calculado
        $partida = $coleccionPartidas[$indice];

        //muestra el mensaje por pantalla al usuario
        echo "Palabra Wordix: " . $partida['palabraWordix'] . "\n";
        echo "Jugador: " . $partida['jugador'] . "\n";
        echo "Puntaje: " . $partida['puntaje'] . "\n";
        echo "Intentos: " . $partida['intentos'] . "\n";
    } else {
        //este mensaje se le mostrara al usuario si el indice es invalido
        echo "El numero que ingreso es invalido. Por favor, ingrese un número entre 1 y " . count($coleccionPartidas) . ".\n";
    }
}

/**
 * Agregara la palabra que ingreso el usuario a la coleccion si es que no esta repetida
 * @param array $coleccionPalabras
 * @param string $nuevaPalabra
 * @return array
 */
function agregarPalabra($coleccionPalabras, $nuevaPalabra){
    //int $cantPalabras
    //boolean $existe
    //obtenemos la cantidad de palabras
    $cantPalabras = count($coleccionPalabras);
    $palabraValida = false;//creamos esta nueva variable para controlar el bucle principal
    
    while(!true){
       //verificamos aca si la palabra existe recorriendo to
        $existe = false;
        $i = 0;
        //recorre el arreglo hasta que encuentre la misma palabra en la coleccion
        while (!$existe && $i < count($coleccionPalabras)){
            if ($coleccionPalabras[$i] === $nuevaPalabra) {
                $existe = true;
            }
            $i++;
        }

        if (!$existe) {
            $palabraValida = true;//si la palabra no esta repetida, se cambia a true
        } else {
            //si la palabra ya esta en la coleccion, 
            echo "Esta palabra ya está en la colección. Intente con otra palabra:\n";
            $nuevaPalabra = leerPalabra5Letras(); //le solicitara nueva palabra
        }
    }
    //agregara la nueva palabra a la coleccion
    $coleccionPalabras[] = $nuevaPalabra;
    echo "La palabra " . $nuevaPalabra . " fue agregada exitosamente a la colección.\n";

    return $coleccionPalabras;
}

/** 
 *Retorna el indice de la primera partida ganada por el jugador o retornara -1 si no gano ninguna partida
 *@param array $coleccionPartidas
 *@param string $nombreJugador
 *@return int
*/
function obtenerIndiceDePrimeraPartidaGanada($coleccionPartidas, $nombreJugador){
    //int $indice
    //inicializamos el indice en -1, que indica que no se ha encontrado ninguna partida ganada
    $indice = -1;

    //recorremos sobre cada partida
    for ($i = 0; $i < count($coleccionPartidas); $i++) {
        //comprobamos si el jugador es el mismo que ingresamos y si su puntaje es mayor a 0
        if (strtolower($coleccionPartidas[$i]['jugador']) == strtolower($nombreJugador) && $coleccionPartidas[$i]['puntaje'] > 0) {
            //se el jugador gano una partida, se guarda el indice y se sale del bucle
            $indice = $i;
            break; 
        }
    }
    //retorna el indice si encontro una partida ganada, si no retornara en -1
    return $indice;
}



/**
 * Se le solicitara al usuario que ingrese el nombre de un jugador y que retorne el nombre en minuscula
 * @return string
 */
function solicitarJugador(){
    //string $nombreJugador
    
    do{
    echo "ingrese un nombre de un jugador: ";
    $nombreJugador = trim(fgets(STDIN));
    
    //verificamos si el primer caracter del nombre del jugador es una letra
      if (!ctype_alpha($nombreJugador[0])){
        //si no es un caracter, mostrara este mensaje a continuacion
        echo "Error. debe ingresar un nombre que empieze con una letra\n";
      }
     //se estara repitiendo hasta que ingrese un nombre valido
    }while(!ctype_alpha($nombreJugador[0]));
     //retorna el nombre en minusculas
     return strtolower($nombreJugador);
}


/** 
 *Muestra un listado de partidas ordenadas por jugador y por palabra.
 *
 *@param array $coleccionPartidas 
*/
function ordenarPartidas($coleccionPartidas){
    //ordenamos la coleccion de partidas
    uasort($coleccionPartidas, function ($a, $b) {
        // Ordenar por jugador alfabéticamente
        $comparacionJugador = strcmp($a['jugador'], $b['jugador']);
        if ($comparacionJugador === 0) {
            // Si los jugadores son iguales, ordenar por palabra
            return strcmp($a['palabraWordix'], $b['palabraWordix']);
        }
        //retorna el resultado de la comparacion de los jugadores
        return $comparacionJugador;
    });

    //imprimimos la coleccion de partidas
    print_r($coleccionPartidas);     
}

/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:
//int $opcion
//int $eleccion
//int $indice
//string $nombreJugador
//string $palabraElegida
//array $estadisticas
//array $partidaJugador
//array $coleccionPalabras
//array $PartidasPorJugador
//array $coleccionPartidas


//Inicialización de variables:
$coleccionPalabras = cargarColeccionPalabras();
$coleccionPartidas = cargarPartidas();
$indicesUtilizadas = [];
$partidas = cargarPartidas();
//Proceso:

//$partida = jugarWordix("MELON", strtolower("MaJo"));
//print_r($partida);
//imprimirResultado($partida);

do {
    //mostrara el menu y se le pedira al usuario que ingrese una opcion
    $opcion = seleccionarOpcion();

    switch ($opcion) {
        case 1:
           //Jugar al wordix con una palabra elegida
           $nombreJugador = solicitarJugador();//solicitara el nombre del jugador
           $cantPlabras = count($coleccionPalabras);//nos da la cantidad de palabras diponibles
          //inicializamos el arreglo de partidas de jugadoro si no existe
          if (!isset($partidaJugador)) {
           $partidaJugador = []; 
          }
          //inicializamos el arreglo de partidas por jugador si no existe
          if (!isset($partidasPorJugador[$nombreJugador])) {
           $partidasPorJugador[$nombreJugador] = [];    
       }
       
       do{  
           //le solicitamos al jugador que elija un numero de indice de la palabra
           echo "Ingrese por favor el numero de la palabra (1 a " . $cantPlabras . "): "; 
           $eleccion = solicitarNumeroEntre(1, $cantPlabras);//se valida la eleccion

           $indiceUtilizado = false;//esta variable se verifica para saber si la palabra ya fue utilizada
           $cantidadPartidas = count($partidasPorJugador[$nombreJugador]);//obtenemos la cantidad de partidas por el jugador
            //se verifica si la palabra ya fue verificada por el jugador
            for ($i = 0; $i < $cantidadPartidas; $i++){            
                //comprobamos si la palabra elegida fue utilizada por el jugador
               if ($partidasPorJugador[$nombreJugador][$i] === $eleccion) {
                //si la palabra fue utilizada, se marca el indice utilizado como verdader
                   $indiceUtilizado = true; 
                   break;
               }
             }
             //si la palabra fue utilizada, se le mostrara este mensaje al usuario
             if ($indiceUtilizado) {
                echo "Ya has utilizado la palabra número " . $eleccion . ". Por favor, elige otro número.\n";
               }
           } while($indiceUtilizado);
           //registra la palabra elegida por el usuario y procedera a jugar la partida
           $partidasPorJugador[$nombreJugador][] = $eleccion;
           $palabraElegida = $coleccionPalabras[$eleccion - 1];
           $partida = jugarWordix($palabraElegida, strtolower($nombreJugador));
           //agrega los datos de la partida a la coleccion
           $coleccionPartidas[] = [
            "palabraWordix" => $partida["palabraWordix"],
            "jugador" => $partida["jugador"],
            "intentos" => $partida["intentos"],
            "puntaje" => $partida["puntaje"]
        ];
           print_r($partida);//imprimira los resultados de la partida
        break;
        case 2: 
            //se le solicita al ususario que ingrese el nombre de jugador
            $jugador = solicitarJugador();
            //obtenemos la cantidad de partidas
            $cantidadPartidas = count($coleccionPartidas);
            //variable que verifica si la palabra que selecciono el ususario , ya haya sido juagda anteriormnte
            $palabraJugada = true;

            //bucle que funciona para para seleccionar una palabra que no haya elegido el jugador
            while($palabraJugada){
                //se selecciona un indice aleatorio dentro del rango de palabras disponibles
                $indiceAleatorio = rand(0, count($coleccionPalabras) - 1);
                //obtenemos la palabra seleccionada respecto al indice
                $palabraSeleccionada = $coleccionPalabras[$indiceAleatorio];
               //inicializamos la variable en falso, asumiendo que la palabra no ha sido jugada
                $palabraJugada = false;
                //verificamos si la palabra seleccionada ya ha sido jugada por el jugador
                for ($i = 0; $i < count($coleccionPartidas); $i++){
                    //comparamos el nombre del jugador y la palabra jugada
                    if (strtolower($coleccionPartidas[$i]["jugador"]) === strtolower($jugador) && $coleccionPartidas[$i]["palabraWordix"] === $palabraSeleccionada){
                        //si la palabra ya fue jugada , marcar la variable como true para repetir el proceso
                        $palabraJugada = true;
                        break;
                    }
                }
            }
            //llamamos a la funcion jugarWordix
            $partida = jugarWordix($palabraSeleccionada, strtolower($jugador));
            //obtenemos el numero de intentos y el puntaje de la partida
            $intentos = $partida["intentos"];
            $puntaje = $partida["puntaje"];
            //guarda los resultados de la partida en la coleecion
            $coleccionPartidas[] = [
                "palabraWordix" => $partida["palabraWordix"],
                "jugador" => $partida["jugador"],
                "intentos" => $partida["intentos"],
                "puntaje" => $partida["puntaje"]
            ];
            //mostramos un mensaje al ususario con los resultados de la partida

            echo "Partida guardada: Jugador: ". $jugador . "\n"; 
            echo "Palabra: " . $palabraSeleccionada . "\n"; 
            echo "Intentos: " . $intentos . "\n"; 
            echo "Puntaje: " . $puntaje . "\n";
            
            break;
        case 3: 
            do {
                // Solicitar número de partida al usuario
                echo "Ingrese el número de partida: ";
                $numPartida = intval(trim(fgets(STDIN)));
                //mostrara los datos correspondiente al numero ingresado
                mostrarPartida($numPartida, $coleccionPartidas);
    
                // Validar si existe la partida
                $indice = $numPartida - 1;//ajusta el numero de partida para que coincida con l indice d arreglo
            } while ($indice < 0 || $indice >= count($coleccionPartidas));//se repetira si el numero esta fura de rango
            break;

        case 4:
            $nombreJugador = solicitarJugador();//se le solicita el nombre al usuario 
            $indicePartidaGanada = obtenerIndiceDePrimeraPartidaGanada($coleccionPartidas, $nombreJugador);//obtenemos el indice de la partida ganada
            //verifica si el jugador ha ganado al menos una ártida
            if($indicePartidaGanada != -1){
                //si se encontro una partida ganada, se obtiene la informacion de esa partida
                //muestra los datos de la partida ganada
                $partidaGanada = $coleccionPartidas[$indicePartidaGanada];
                echo "********** Primera Partida Ganada **********\n";
                echo "Partida Wordix " . ($indicePartidaGanada + 1) . " palabra " . $partidaGanada['palabraWordix'] . "\n";
                echo "Jugador " . $nombreJugador . "\n";
                echo "Puntaje " . $partidaGanada['puntaje'] . " puntos \n";
                echo "Inento: Adivino la palabra en " .$partidaGanada['intentos'] . " intentos\n";
            } else {
                //se le mostrata este mensaje al usuario si el jugador no gano ninguna partida
                echo "El jugador " . $nombreJugador . " no gano ninguna partida\n";
            }
            break;
        case 5:                  
            $jugador = solicitarJugador();//se solicita el nombre del jugador 
            // Se obtienen las estadísticas del jugador a partir de su nombre y la colección de partidas
            $estadisticas = obtenerEstadisticasJugador($jugador, $coleccionPartidas);
            //muestra las estadiscticas del jugador
            mostrarEstadisticasJugador($estadisticas);
            break;
        case 6:
            ordenarPartidas($coleccionPartidas);
            break;
        case 7:
             $nuevaPalabra = leerPalabra5Letras();
             $coleccionPalabras = agregarPalabra($coleccionPalabras, $nuevaPalabra);
            break;
        case 8:
            echo "Saliendo del Programa...";
            break; 
    }

} while ($opcion != 8);

?>