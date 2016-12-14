<?php

/**
 * Created by PhpStorm.
 * User: Maurizio
 * Date: 14/12/2016
 * Time: 16:09
 */
class Account
{
    private $username;
    private $password;
    private $nome;
    private $cognome;
    private $dataDiNascita;
    private $domicilio;
    private $residenza;
    private $email;
    private $tipo;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return Account
     */
    public function setUsername(String $username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Account
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     * @return Account
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * @param mixed $cognome
     * @return Account
     */
    public function setCognome($cognome)
    {
        $this->cognome = $cognome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataDiNascita()
    {
        return $this->dataDiNascita;
    }

    /**
     * @param mixed $dataDiNascita
     * @return Account
     */
    public function setDataDiNascita($dataDiNascita)
    {
        $this->dataDiNascita = $dataDiNascita;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * @param mixed $domicilio
     * @return Account
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResidenza()
    {
        return $this->residenza;
    }

    /**
     * @param mixed $residenza
     * @return Account
     */
    public function setResidenza($residenza)
    {
        $this->residenza = $residenza;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Account
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     * @return Account
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }
}