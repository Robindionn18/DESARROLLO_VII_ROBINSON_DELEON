<?php
class Books {
    public $id;
    public $title;
    public $category;
    public $releaseAtLibrary;
    public $releaseDate;
    public $aviable;

    // Constructor para crear un objeto Task a partir de un array de datos
    public function __construct($data) {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->category = $data['category'];
        $this->releaseAtLibrary = $data['relase_at_library'];
        $this->releaseDate = $data['release_date'];
        $this->aviable = $data['aviable'];
    }

    // Aquí podrían añadirse métodos adicionales relacionados con una tarea individual
}