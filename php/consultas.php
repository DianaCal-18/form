<?php

class Consultas {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerLibros() {
        $query = "SELECT titulo, tipo, precio, notas FROM titulos";
        $stmt = $this->conexion->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerAutores() {
        $query = "SELECT nombre,apellido,telefono FROM autores";
        $statement = $this->conexion->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertarContacto($nombre, $correo, $asunto, $comentario) {
        $fecha = date("Y-m-d H:i:s");
        $query = "INSERT INTO contacto (fecha, nombre, correo, asunto, comentario) VALUES (:fecha, :nombre, :correo, :asunto, :comentario)";
        $statement = $this->conexion->prepare($query);
        $statement->bindParam(':fecha', $fecha);
        $statement->bindParam(':nombre', $nombre);
        $statement->bindParam(':correo', $correo);
        $statement->bindParam(':asunto', $asunto);
        $statement->bindParam(':comentario', $comentario);
        return $statement->execute();
    }
    public function obtenerMensajes() {
      $query = "SELECT * FROM contacto";
      $statement = $this->conexion->prepare($query); 
      $statement->execute();
      return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  public function actualizarContacto($id, $nombre, $correo, $asunto, $comentario) {
    $query = "UPDATE contacto SET nombre = :nombre, correo = :correo, asunto = :asunto, comentario = :comentario WHERE id = :id";
    $statement = $this->conexion->prepare($query);
    $statement->bindParam(':nombre', $nombre);
    $statement->bindParam(':correo', $correo);
    $statement->bindParam(':asunto', $asunto);
    $statement->bindParam(':comentario', $comentario);
    $statement->bindParam(':id', $id);
    return $statement->execute();
}

public function eliminarContacto($id) {
    $query = "DELETE FROM contacto WHERE id = :id";
    $statement = $this->conexion->prepare($query);
    $statement->bindParam(':id', $id);
    return $statement->execute();
}

public function obtenerContactoPorId($id) {
    $query = "SELECT * FROM contacto WHERE id = :id";
    $statement = $this->conexion->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}
}
?>