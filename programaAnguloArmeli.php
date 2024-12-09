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
 * Obtiene una colección de palabras
 * @return array $coleccionPalabras
 */
function cargarColeccionPalabras() {
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
function cargarPartidas() {
    //inicializamos el array que contendra las partidas 
    $coleccionPartidas = [
        ["palabraWordix" => "MUNDO", "jugador" => "Lautaro", "intentos" => 5, "puntaje" => 11],
        ["palabraWordix" => "CASAS", "jugador" => "Marcos", "intentos" => 1, "puntaje" => 16],
        ["palabraWordix" => "RASGO", "jugador" => "Enzo", "intentos" => 2, "puntaje" => 15],
        ["palabraWordix" => "AGUDO", "jugador" => "Lucas", "intentos" => 5, "puntaje" => 9],
        ["palabraWordix" => "COLOR", "jugador" => "Nahuel", "intentos" => 6, "puntaje" => 10],
        ["palabraWordix" => "MOTOS", "jugador" => "Federico", "intentos" => 3, "puntaje" => 14],
        ["palabraWordix" => "VERDE", "jugador" => "Juan", "intentos" => 1, "puntaje" => 16],
        ["palabraWordix" => "HUEVO", "jugador" => "Juliana", "intentos" => 3, "puntaje" => 12],
        ["palabraWordix" => "TINTO", "jugador" => "Antonela", "intentos" => 0, "puntaje" => 0],
        ["palabraWordix" => "PIANO", "jugador" => "Agustin", "intentos" => 3, "puntaje" => 13],
    ];
    return $coleccionPartidas;
}

/**
 * Función que muestra estadísticas de un jugador basado en las partidas jugadas.
 * @param string $nombreJugador 
 * @param array $partidas 
 * @return array $estadísticas
 */
function obtenerEstadisticasJugador($nombreJugador, $partidas) {
    // array $partidas
    $estadisticas = [
        "nombre" => ucfirst($nombreJugador),
        "partidas" => 0,
        "puntajeTotal" => 0,
        "victorias" => 0,
        "adivinadas" => [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0],
        "porcentajeVictorias" => 0
    ];

    foreach ($partidas as $partida) {
        // Verificamos si el jugador de la partida es el buscado
        if (strtolower($partida["jugador"]) === strtolower($nombreJugador)) {
            // Actualizamos las estadísticas de partidas y puntaje total
            $estadisticas["partidas"]++;
            $estadisticas["puntajeTotal"] += $partida["puntaje"];

            // Condición combinada para victoria y conteo de intentos
            if ($partida["puntaje"] > 0 && $partida["intentos"] <= 5) {
                $estadisticas["victorias"]++;
                $estadisticas["adivinadas"][$partida["intentos"]]++;
            }
        }
    }

    // Calculamos el porcentaje de victorias, si se han jugado partidas
    if ($estadisticas["partidas"] > 0) {
        $estadisticas["porcentajeVictorias"] = round(($estadisticas["victorias"] / $estadisticas["partidas"]) * 100);
    }

    return $estadisticas;
}

/**
 * Función para mostrar las estadisticas de un jugador
 * @param array $estadisticas
 */
function mostrarEstadisticasJugador($estadisticas) {
    // int $intento, $cantidad
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
 * funcion que muestra al usuario el menu de opciones y le solicitara una opcion valida
 * @param string $usuario
 * @return int $opcion
 */
function seleccionarOpcion(){
    //int $opcion
    echo "********** Menu de opciones, seleccione una opcion del 1 al 8 **********\n";
    echo "1. Jugar al wordix con una palabra elegida\n";
    echo "2. Jugar al wordix con una palabra aleatoria\n";
    echo "3. Mostrar partida\n";
    echo "4. Mostrar la primer partida ganada\n";
    echo "5. Mostrar resumen de Jugador\n";
    echo "6. Mostrar listado de partidas ordenadas por jugador y por palabra\n";
    echo "7. Agregar una palabra de 5 letras a Wordix\n";
    echo "8. Salir del menu\n";
        
    $opcion = solicitarNumeroEntre(1,8);
    
    return $opcion;
}

/**
 * funcion que dado un numero de partidas, mostrara al usuario en pantalla los datos de la partida
 * @param int $numPartida
 * @param array $coleccionPartidas
 */
function mostrarPartida($numPartida, $coleccionPartidas){
    //int $indice
    //array $partida
    $indice = $numPartida - 1;

    //verifica si el indice esta dentro del rango valido
    if ($indice >= 0 && $indice < count($coleccionPartidas)) {
        //guardamos la partida que es corrspondiente con el indice
        $partida = $coleccionPartidas[$indice];
        //se le mostrara en pantalla los datos al usuario
        echo "Palabra Wordix: " . $partida['palabraWordix'] . "\n";
        echo "Jugador: " . $partida['jugador'] . "\n";
        echo "Puntaje: " . $partida['puntaje'] . "\n";
        echo "Intentos: " . $partida['intentos'] . "\n";
    } else {
        //si el indice no esta dentro del rango permitido, se le mostrara por pantalla el siguiente mensaje
        echo "El numero que ingreso es invalido. Por favor, ingrese un número entre 1 y " . count($coleccionPartidas) . ".\n";
    }
}

/**
 * Agrega la palabra que ingresó el usuario a la colección si no está repetida
 * @param array $coleccionPalabras
 * @param string $nuevaPalabra
 * @return array $coleccionPalabras
 */
function agregarPalabra($coleccionPalabras, $nuevaPalabra) {
    //boolean $existe 
    //variable para verificar si la palabra ya existe si ponemos "true" es como que esta desde un principio desde los tiempos
    $existe = false;
    $i = 0;//creamos esta nueva variable para que pueda recorrer el arreglo

    // Usamos un ciclo while para recorrer la coleccion
    while($i < count($coleccionPalabras)) {
        //verificaremos si la palabra que ingreso el usuario existe en la coleccion
        if ($coleccionPalabras[$i] === $nuevaPalabra) {
            $existe = true;
        // Si encontramos que la palabra existe, salimos del ciclo y no agregamos la palabra
        }
        $i++;//incrementamos la variable para el recorrido
    }

    // Si la palabra no existe en la colección
    if (!$existe) {
        // Agregar la nueva palabra a la colección
        $coleccionPalabras[] = $nuevaPalabra;
        echo "La palabra " . $nuevaPalabra . " fue agregada exitosamente a la colección.\n";
    } else {
        // Si la palabra ya existe, pedimos una nueva palabra
        echo "Esta palabra ya está en la colección. Intente con otra palabra:\n";
        $nuevaPalabra = leerPalabra5Letras(); // Le solicitamos una nueva palabra
        // Volver a llamar a la función con la nueva palabra
        $coleccionPalabras = agregarPalabra($coleccionPalabras, $nuevaPalabra);
    }

    return $coleccionPalabras;
}

/**
 * Retorna el índice de la primera partida ganada por el jugador o retornará -1 si no ganó ninguna partida
 * @param array $coleccionPartidas
 * @param string $nombreJugador
 * @return int $indice
 */
function obtenerIndiceDePrimeraPartidaGanada($coleccionPartidas, $nombreJugador) {
    // int $i
    // Inicializamos el índice en -1, que indica que no se ha encontrado ninguna partida ganada
    $indice = -1;
    $i = 0;

    // Recorremos la colección de partidas con un while
    while ($i < count($coleccionPartidas) && $indice === -1) {
        // Comprobamos si el jugador es el mismo que ingresamos y si su puntaje es mayor a 0
        if (strtolower($coleccionPartidas[$i]['jugador']) == $nombreJugador && $coleccionPartidas[$i]['puntaje'] > 0) {
            // Si se encuentra una victoria del jugador, almacenamos el índice y salimos del bucle
            $indice = $i;
        }
        $i++; // Incrementamos $i para evitar un bucle infinito
    }
    
    // Retorna el índice si encontró una partida ganada, si no retornará -1
    return $indice;
}

/**
 * Se le solicitara al usuario que ingrese el nombre de un jugador y que retorne el nombre en minuscula
 * @return string
 */
function solicitarJugador(){
    //string $nombreJugador
    
    do {
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
 * funcion que muestra un listado de partidas ordenadas por jugador y por palabra.
 *@param array $coleccionPartidas 
*/
function ordenarPartidas($coleccionPartidas){
    //ordenamos la coleccion de partidas utilizando uasort
    uasort($coleccionPartidas, function ($a, $b) {
        //comparara los nombre de los jugadores pero de manera alfabeticamente 
        $comparacionJugador = strcmp($a['jugador'], $b['jugador']);
        if ($comparacionJugador === 0) {
            // Si los jugadores son iguales, comparara las palabras en orden 
            return strcmp($a['palabraWordix'], $b['palabraWordix']);
        }
        //retorna el resultado de la comparacion de los jugadores si los jugadores no son iguales
        return $comparacionJugador;
    });

    //imprimimos la coleccion de partidas
    print_r($coleccionPartidas);     
}

/**
 * función para seleccionar una palabra no utilizada previamente
 * @param string $nombreJugador 
 * @param array $coleccionPalabras 
 * @param array $coleccionPartidas 
 * @return array $coleccionPalabras
*/
function seleccionarPalabra($nombreJugador, $coleccionPalabras, $coleccionPartidas) {
    // int $cantPalabras, $eleccion
    // bool $indiceUtilizado

    $cantPalabras = count($coleccionPalabras); // Número total de palabras disponibles

    do {
        echo "Ingrese por favor el número de la palabra (1 a " . $cantPalabras . "): ";
        $eleccion = solicitarNumeroEntre(1, $cantPalabras); // Solicita un número válido
       //verificamos si la palabra ya fue usada por el jugador
        $indiceUtilizado = verificarPalabraUtilizada($nombreJugador, $coleccionPalabras[$eleccion - 1], $coleccionPartidas);
       //si la palabra ya fue usada anteriormente, le saltara un mensaje de error al usuario y pidiendole que vuelva a solicitar otro numero
        if ($indiceUtilizado) {
            echo "Ya has utilizado la palabra número " . $eleccion . ". Por favor, elige otro número.\n";
        }
    } while ($indiceUtilizado);
    //retorna la palabra seleccionada
    return $coleccionPalabras[$eleccion - 1];
}

/** 
 * función para verificar si una palabra ya fue utilizada
 * @param string $nombreJugador Nombre del jugador a verificar.
 * @param string $palabra Palabra que se desea comprobar.
 * @param array $coleccionPartidas
 * @return bool 
 **/
function verificarPalabraUtilizada($nombreJugador, $palabra, $coleccionPartidas) {
    foreach ($coleccionPartidas as $partida) {
        if (
            strtolower($partida['jugador']) === strtolower($nombreJugador) &&
            $partida['palabraWordix'] === $palabra
        ) {
            return true; // La palabra ya fue utilizada
        }
    }
    return false; // La palabra no fue utilizada
}

/**
 * función para agregar una partida a la colección
 * @param array $coleccionPartidas
 * @param array $partida
 */
function agregarPartida(&$coleccionPartidas, $partida) {
    $coleccionPartidas[] = [
        "palabraWordix" => $partida["palabraWordix"],
        "jugador" => $partida["jugador"],
        "intentos" => $partida["intentos"],
        "puntaje" => $partida["puntaje"]
    ];
}

/**
 * funcion que selecciona una palabra aleatoria de la colección que el jugador no haya utilizado en partidas anteriores.
 * @param string $jugador
 * @param array $coleccionPalabras
 * @param array $coleccionPartidas
 * @return string $palabraSeleccionada
 */
function seleccionarPalabraAleatoria($jugador, $coleccionPalabras, $coleccionPartidas) {
    $palabraJugada = true; // Inicializa la variable en `true` para entrar al bucle
    $palabraSeleccionada = ""; // Inicializa la palabra seleccionada

    while ($palabraJugada) {
        $indiceAleatorio = rand(0, count($coleccionPalabras) - 1); // Selecciona un índice aleatorio
        $palabraSeleccionada = $coleccionPalabras[$indiceAleatorio];
        $palabraJugada = verificarPalabraUtilizada($jugador, $palabraSeleccionada, $coleccionPartidas); // Reutiliza función compartida
    }

    return $palabraSeleccionada;
}

/**
 * Muestra los detalles de la primera partida ganada por un jugador.
 * @param array $coleccionPartidas 
 * @param string $nombreJugador
 */
function mostrarPrimeraPartidaGanada($coleccionPartidas, $nombreJugador) {
    $indicePartidaGanada = obtenerIndiceDePrimeraPartidaGanada($coleccionPartidas, $nombreJugador);

    if ($indicePartidaGanada != -1) {
        $partidaGanada = $coleccionPartidas[$indicePartidaGanada];
        echo "********** Primera Partida Ganada **********\n";
        echo "Partida Wordix " . ($indicePartidaGanada + 1) . " palabra: " . $partidaGanada['palabraWordix'] . "\n";
        echo "Jugador: " . ucfirst($nombreJugador) . "\n";
        echo "Puntaje: " . $partidaGanada['puntaje'] . " puntos \n";
        echo "Intentos: Adivinó la palabra en " . $partidaGanada['intentos'] . " intentos\n";
    } else {
        echo "El jugador " . ucfirst($nombreJugador) . " no ganó ninguna partida\n";
    }
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
            $nombreJugador = solicitarJugador(); // Solicita el nombre del jugador
            $palabraElegida = seleccionarPalabra($nombreJugador, $coleccionPalabras, $coleccionPartidas); // Selecciona una palabra válida
            $partida = jugarWordix($palabraElegida, strtolower($nombreJugador)); // Juega la partida con la palabra seleccionada
            agregarPartida($coleccionPartidas, $partida); // Agrega los datos de la partida a la colección
        break;
        case 2: 
            $jugador = solicitarJugador(); // Solicita el nombre del jugador
            $palabraSeleccionada = seleccionarPalabraAleatoria($jugador, $coleccionPalabras, $coleccionPartidas); // Selecciona una palabra aleatoria no jugada
            $partida = jugarWordix($palabraSeleccionada, strtolower($jugador)); // Juega la partida con la palabra seleccionada
            agregarPartida($coleccionPartidas, $partida);  // Agrega los datos de la partida a la colección
            break;
        case 3: 
            do {
                echo "Ingrese el número de partida: "; 
                $numPartida = trim(fgets(STDIN)); // Solicitar número de partida al usuario
                mostrarPartida($numPartida, $coleccionPartidas); //mostrara los datos correspondiente al numero ingresado
    
                // Validar si existe la partida
                $indice = $numPartida - 1;//ajusta el numero de partida para que coincida con l indice d arreglo
            } while ($indice < 0 || $indice >= count($coleccionPartidas));//se repetira si el numero esta fura de rango
            break;
        case 4:
            $nombreJugador = solicitarJugador(); // Solicita el nombre del jugador
            mostrarPrimeraPartidaGanada($coleccionPartidas, $nombreJugador);
            break;
        case 5:                  
            $jugador = solicitarJugador(); // Solicita el nombre del jugador
            $estadisticas = obtenerEstadisticasJugador($jugador, $coleccionPartidas);
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