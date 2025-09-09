<?php

function contar_palabras_repetidas($texto)
{

    $palabras = [];
    $contador = [];
    $j = 0;

    $texto = trim(strtolower($texto));

    $palabras = explode(" ", $texto);

    for ($i = 0; $i < count($palabras); $i++) {
        if ($palabras[$i] !== "") {
            $contador[$j] = 1;
            for ($k = $i + 1; $k < count($palabras); $k++) {
                if ($palabras[$i] === $palabras[$k]) {
                    $contador[$j]++;
                    $palabras[$k] = "";
                }
            }
            echo "La palabra '" . $palabras[$i] . "' se repite " . $contador[$j] . " veces.<br>";
            $j++;
        }
    }
}

function capitalizar_palabras($texto)
{

    $palabras = [];

    $texto = trim(strtolower($texto));

    $palabras = explode(" ", $texto);

    for ($i = 0; $i < count($palabras); $i++) {
        if ($palabras[$i] !== "") {
            $palabras[$i] = strtoupper(substr($palabras[$i], 0, 1)) . substr($palabras[$i], 1);
        }
    }
    $fraseModificada = implode(" ", $palabras);

    return $fraseModificada;
}

