<?php
Class UsersGataway
{
    private PDO $conn;
    
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }
    public function getAll():array
    {
        $sql = "Select * from users;";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function get(string $id_user):array | false
    {
        $sql = "select * from users where id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id_user, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;

    }
    public function create(array $data):string{
        $sql = "insert into users (name, email, password) 
        VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name" , $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":email" , $data["email"], PDO::PARAM_STR);
        $psw = password_hash($data["password"], PASSWORD_DEFAULT);
        $stmt->bindValue(":password" ,$psw , PDO::PARAM_STR);
        $stmt->execute();
        // Retourne l'identifiant de la dernière ligne insérée ou la valeur d'une séquence
        return $this->conn->lastInsertId();
    }
    public function update(array $data ,string $id_user):string   
    {
        $sql = "UPDATE users SET name = :name, email = :email  WHERE id = :id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id" , $id_user, PDO::PARAM_INT);        
        $stmt->bindValue(":name" , $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":email" , $data["email"], PDO::PARAM_STR);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }
    public function delete($id):int
    {
        $sql = "DELETE FROM users 
        WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id" , $id, PDO::PARAM_INT); 
        $stmt->execute();
        return $stmt->rowCount();
    }
}