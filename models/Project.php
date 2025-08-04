<?php
require_once __DIR__ . '/../config/Database.php';

//Clase Project para la persistencia de datos
class Project 
{
    private $db;//Propiedad para almacenar la conexion a la base de datos

    //Constructor que inicializa la conexion a la base de datos
    public function __construct()
    {
        $this->db = Database::getConnection();//Accede al metodo estatico getConection de la clase Database
    }

    //Metodo para obtener todos loc proyectos
    public function getAll()
    {
        $stmt = $this->db->query("SELECT id, name, description FROM projects");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);//Retorna un array asociativo con todos los proyectos utilizando la clase PDO
    }

    //Metodo para obtener un proyecto por ID
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT id, name, description FROM projects WHERE id = ?");
        $stmt->execute(['$id']);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Metodo para crear un proyecto a travez del endpoin
    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO projects (name, description) VALUES (?, ?)");
        return $stmt->execute([$data['name'], $data['description']]);
    }
}