<?php

class Usuario{
    private $id = 0, $nome = "", $email = "", $senha = ""; 

    public function getId():int{
        return($this->id);
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getNome():string{
        return($this->nome);
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getSenha():string{
        return($this->senha);
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function getEmail():string{
        return($this->email);
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setData($data = []){
        $this->setId($data["ADM_ID"]);
        $this->setNome($data["ADM_NOME"]);
        $this->setEmail($data["ADM_EMAIL"]);
        $this->setSenha($data["ADM_SENHA"]);
    }

    public function unsetData(){
        $this->setId(0);
        $this->setNome("");
        $this->setEmail("");
        $this->setSenha("");
    }

    public function getUsuarios(){
        $sql = new Sql();

        $query = "SELECT * FROM ADMINISTRADOR";

        $data = $sql->select($query);

        return($data);
    }

    public function loadById(){
        $sql = new Sql();

        $query = "SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :ID";
        $params = [
            ":ID"=>$this->getId()
        ];

        $data = $sql->select($query, $params);

        if(count($data) == 0){
            $response = json_encode(["msg"=>"Usuário inválido!"]);
        }else{
            $this->setData($data[0]);

            $response = json_encode(["msg"=>"OK!"]);
        }

        return($response);
    }

    public function login(){
        $sql = new Sql();

        $query = "SELECT * FROM ADMINISTRADOR WHERE ADM_EMAIL = :EMAIL AND ADM_SENHA = :SENHA";
        $params = [
            ":EMAIL"=>$this->getEmail(),
            ":SENHA"=>$this->getSenha()
        ];

        $data = $sql->select($query, $params);

        if(count($data) == 0){
            $response = json_encode(["msg"=>"Usuário inválido!"]);
        }else{
            $this->setId($data[0]["ADM_ID"]);
            $this->loadById();

            $response = json_encode(["msg"=>"Conectado com sucesso!"]);
        }

        return($response);
    }

    public function insert(){
        $sql = new Sql();

        $query = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA) VALUES (:NOME, :EMAIL, :SENHA)";

        $params = [
            ":NOME"=>$this->getNome(),
            ":EMAIL"=>$this->getEmail(),
            ":SENHA"=>$this->getSenha(),
        ];

        $sql->executeQuery($query, $params);
        $this->setId($sql->returnLastId());

        if($this->getId() == 0){
            $response = json_encode(["msg"=>"Erro ao cadastrar usuário!"]);
        }else{
            $this->loadById();

            $response = json_encode(["msg"=>"OK!"]);
        }

        return($response);
    }

    public function update(){
        $sql = new Sql();

        $query = "UPDATE ADMINISTRADOR SET ADM_NOME = :NOME, ADM_EMAIL = :EMAIL, ADM_SENHA = :SENHA WHERE ADM_ID = :ID";

        $params = [
            ":ID"=>$this->getId(),
            ":NOME"=>$this->getNome(),
            ":EMAIL"=>$this->getEmail(),
            ":SENHA"=>$this->getSenha()
        ];

        $sql->executeQuery($query, $params);

        $this->loadById();

        $response = json_encode(["msg"=>"OK!"]);

        return($response);
    }

    public function delete(){
        $sql = new Sql();

        $query = "DELETE FROM ADMINISTRADOR WHERE ADM_ID = :ID";

        $params = [
            ":ID"=>$this->getId()
        ];

        $sql->executeQuery($query, $params);

        $this->unsetData();
        $response = json_encode(["msg"=>"OK!"]);

        return($response);
    }

    public function __toString():string{
        return(json_encode([
            "id"=>$this->getId(),
            "nome"=>$this->getNome(),
            "email"=>$this->getEmail(),
            "senha"=>$this->getSenha()
        ]));
    }
}