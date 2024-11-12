<?php

class Reserva {
    private $hotel;
    private $nombre;
    private $apellido;
    private $telefono;
    private $fechaReserva;
    private $observaciones;
    private static $rutaArchivoReservas = "../datos/reservas.txt";

    public function __construct($hotel, $nombre, $apellido, $telefono, $fechaReserva, $observaciones) {
        $this->hotel = $this->validarRequerido($hotel, 'Hotel');
        $this->nombre = $this->validarRequerido($nombre, 'Nombre');
        $this->apellido = $this->validarRequerido($apellido, 'Apellido');
        $this->telefono = $this->validarRequerido($telefono, 'Teléfono');
        $this->fechaReserva = $this->validarRequerido($fechaReserva, 'Fecha de Reserva');
        $this->observaciones = $this->validarRequerido($observaciones, 'Observaciones');
    }

    private function validarRequerido($valor, $nombreCampo) {
        if (empty($valor)) {
            throw new Exception("El campo $nombreCampo es requerido.");
        }
        return $valor;
    }

    public function guardarEnArchivo() {
        $datos = "$this->hotel,$this->nombre,$this->apellido,$this->telefono,$this->fechaReserva,$this->observaciones\n";
        file_put_contents(self::$rutaArchivoReservas, $datos, FILE_APPEND);
    }

    public static function obtenerTodasLasReservas() {
        $archivo =self::$rutaArchivoReservas;
        $reservas = [];
        if (file_exists($archivo)) {
            $contenido = file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($contenido as $linea) {
                list($hotel, $nombre, $apellido, $telefono, $fechaReserva, $observaciones) = explode(',', $linea);
                $reservas[] = new self($hotel, $nombre, $apellido, $telefono, $fechaReserva, $observaciones);
            }
        }
        return $reservas;
    }

    public function aArray() {
        return [
            'hotel' => $this->hotel,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'telefono' => $this->telefono,
            'fechaReserva' => $this->fechaReserva,
            'observaciones' => $this->observaciones,
        ];
    }
}
?>
