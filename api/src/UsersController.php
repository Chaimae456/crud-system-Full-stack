<?php 

Class UsersController{
    public function __construct(private UsersGataway $gatawa)
    {

    }
    public function progressRequest(string $method ,?string $id): void
    {
        if($id === null){
            if($method == "GET"){
                echo json_encode($this->gatawa->getAll());
            }
            elseif($method == "POST"){
                $data = json_decode(file_get_contents("php://input"),true);
                $error = $this->getValidationErrors($data);
                if(!empty($error))
                {
                    $this->responceErrorValidation($error);
                    return;
                }
                $id = $this->gatawa->create($data);
                $this->responceCreated($id);
            }
            else{
                $this->responceMethodNotAllowed("GET, POST");
            }
        }else{
            $user = $this->gatawa->get($id);
            if($user === false){
                $this->responceNotFound($id);
                return;
            }
            switch($method) {
                case "GET":
                    echo json_encode($user);
                    break;
                case "POST":
                    $data = json_decode(file_get_contents("php://input"),true);
                    if(empty($data))
                    {
                    print_r($data);
                    echo "array is empty";
                    }else{
                        $error = $this->getValidationErrorsForUpdate($data);
                        if(!empty($error))
                        {
                            $this->responceErrorValidation($error);
                                return;
                        }
                        $this->gatawa->update($data , $id);
                        $this->responceUpdated($id);
                    }
                    break;
                case "DELETE":
                    $row =$this->gatawa->delete($id);
                    if($row == 1)
                    {
                        $this->responceDelete($id);
                    }else{
                        echo json_encode(["message" =>"Something went wrong try again later !"]);
                    }
                    break;
                default: 
                    $this->responceMethodNotAllowed("GET, DELETE, PATCH");
            }
        }
    } 

private function responceMethodNotAllowed(string $allowed_methods): void {
                http_response_code(405);
                header("Allow: $allowed_methods");
}
private function responceNotFound(string $id):void
{
    http_response_code(404);
    echo json_encode(["message" =>"User with ID $id not Found"]);

}
private function responceCreated(string $id):void
{
    http_response_code(201);
    echo json_encode(["message" =>"user Well created" , "id" => $id]);

}
private function responceUpdated(string $id):void
{
    http_response_code(200);
    echo json_encode(["message" =>"user Well Updated" , "id" => $id]);

}
private function responceDelete(string $id):void
{
    http_response_code(200);
    echo json_encode(["message" =>"user Well Deleted" , "id" => $id]);

}
private function responceErrorValidation(array $error): void {
                http_response_code(422);
                echo json_encode(["Error"=> $error]);
}
private function getValidationErrors(array $data):array
{
    $errors = [];
    if(empty($data['name']) || empty($data['email']) || empty($data['password']))
    {
        $errors[] = "All Field are required";
    }
    if(!filter_var($data['email'] , FILTER_VALIDATE_EMAIL))
    {
        $errors[] = "invalide Email Adress";
    }
    if(strlen($data['password']) < 8){
        $errors[] = "Your password must be more the 8 characters";
    }
    return $errors;

}
private function getValidationErrorsForUpdate(array $data):array
{
    $errors = [];
    if(empty($data['name']) || empty($data['email']))
    {
        $errors[] = "All Field are required";
    }
    if(!filter_var($data['email'] , FILTER_VALIDATE_EMAIL))
    {
        $errors[] = "invalide Email Adress";
    }
    return $errors;
}



}
