<?php

class Noticia {
    public $id;
    public $fechaComienzo;
    public $fechaFin;
    public $duracion;
    public $prioridad;
    public $titulo;
    public $perfil;
    public $tipo;
    public $contenido;
    public $url;
    public $formato;

    // Constructor
    public function __construct($id, $fechaComienzo, $fechaFin, $duracion, $prioridad, $titulo, $perfil, $tipo, $contenido, $url, $formato) {
        $this->id = $id;
        $this->fechaComienzo = $fechaComienzo;
        $this->fechaFin = $fechaFin;
        $this->duracion = $duracion;
        $this->prioridad = $prioridad;
        $this->titulo = $titulo;
        $this->perfil = $perfil;
        $this->tipo = $tipo;
        $this->contenido = $contenido;
        $this->url = $url;
        $this->formato = $formato;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getFechaComienzo() {
        return $this->fechaComienzo;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function getDuracion() {
        return $this->duracion;
    }

    public function getPrioridad() {
        return $this->prioridad;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getPerfil() {
        return $this->perfil;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getContenido() {
        return $this->contenido;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getFormato() {
        return $this->formato;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setFechaComienzo($fechaComienzo) {
        $this->fechaComienzo = $fechaComienzo;
    }

    public function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    public function setDuracion($duracion) {
        $this->duracion = $duracion;
    }

    public function setPrioridad($prioridad) {
        $this->prioridad = $prioridad;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setPerfil($perfil) {
        $this->perfil = $perfil;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setContenido($contenido) {
        $this->contenido = $contenido;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setFormato($formato) {
        $this->formato = $formato;
    }
}

?>