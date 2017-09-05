<?php
/**
 * Created by PhpStorm.
 * User: marci
 * Date: 21/08/2017
 * Time: 15:05
 */

namespace model;

use model\dao\UsuarioDAO;
use model\validator\UsuarioValidate;
use util\DataConversor;
use util\Mensagem;
use util\Token;
use view\View;

class Usuario
{
    private $id;
    private $nome;
    private $avatar;
    private $isControleDosPais;
    private $ultimosAssistidos;
    private $senha;
    private $email;
    private $dataNascimento;
    private $dataCriacao;
    private $dataAlteracao;
    private $status;
    private $minhaLista;

    function __construct()
    {
//        $this->minhaLista = new MinhaLista();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * @return mixed
     */
    public function getisControleDosPais()
    {
        return $this->isControleDosPais;
    }

    /**
     * @param mixed $isControleDosPais
     */
    public function setIsControleDosPais($isControleDosPais)
    {
        $this->isControleDosPais = $isControleDosPais;
    }

    /**
     * @return mixed
     */
    public function getUltimosAssistidos()
    {
        return $this->ultimosAssistidos;
    }

    /**
     * @param mixed $ultimosAssistidos
     */
    public function setUltimosAssistidos($ultimosAssistidos)
    {
        $this->ultimosAssistidos = $ultimosAssistidos;
    }

    /**
     * @return MinhaLista
     */
    public function getMinhaLista(): MinhaLista
    {
        return $this->minhaLista;
    }

    /**
     * @param MinhaLista $minhaLista
     */
    public function setMinhaLista(MinhaLista $minhaLista)
    {
        $this->minhaLista = $minhaLista;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
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
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    /**
     * @param mixed $dataNascimento
     */
    public function setDataNascimento($dataNascimento)
    {
        $this->dataNascimento = $dataNascimento;
    }

    /**
     * @return mixed
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * @param mixed $dataCriacao
     */
    public function setDataCriacao($dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;
    }

    /**
     * @return mixed
     */
    public function getDataAlteracao()
    {
        return $this->dataAlteracao;
    }

    /**
     * @param mixed $dataAlteracao
     */
    public function setDataAlteracao($dataAlteracao)
    {
        $this->dataAlteracao = $dataAlteracao;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function listar()
    {
        return UsuarioDAO::retreave($this);
    }

    public function cadastrar()
    {
        UsuarioDAO::retreaveByEmail($this);
        if (UsuarioDAO::getRows() == 0) {
            $this->senha = password_hash($this->senha, PASSWORD_DEFAULT);
            return UsuarioDAO::create($this);
        }
        return Mensagem::error("usuario-ja-cadastrado", 500);

    }

    public function deletar()
    {
        return UsuarioDAO::delete($this);

    }

    public function alterar()
    {
        return UsuarioDAO::update($this);
    }

    public function login()
    {
        $usuario = UsuarioDAO::login($this);
        if (UsuarioDAO::getRows() == 1) {
            $token = new Token(); // se senha digitada for igual a true retorna um token
            $token = $token->gerarToken('admin', $usuario['nome'], $usuario['email']);
            return $token;
        }
        return Mensagem::error("erro-inesperado-login", 500);
    }
}