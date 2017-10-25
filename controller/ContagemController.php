<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 19/10/2017
 * Time: 16:19
 */

namespace controller;


use model\Contagem;
use util\DataConversor;
use util\Token;

class ContagemController implements IController
{
    private $token;

    public function __construct()
    {
        $this->token = new Token();
        $this->token = $this->token->token();
    }


    public function post()
    {
        $data = new DataConversor();
        $data = $data->converter();
        $contagem = new Contagem();
        if (isset($data['filmeId'])) $contagem->setFilmeId($data['filmeId']);
        if (isset($data['episodioId'])) $contagem->setEpisodioId($data['episodioId']);
        if (isset($data['episodioTemporadaId'])) $contagem->setEpisodioTemporadaId($data['episodioTemporadaId']);
        if (isset($data['episodioSerieId'])) $contagem->setEpisodioSerieId($data['episodioSerieId']);
        $contagem->setTipo($data['tipo']);
        $contagem->setUsuarioId($this->token['usuario']->id);
        $contagem->aumentar();
    }

    public function get($params = [])
    {

        $contagem = new Contagem();
        if ($this->token['permissao'] === 'admin') {
            $contagem->setPermicao(true);
        }
        $contagem->recuperar();

    }

    public function put($params = [])
    {
        // TODO: Implement put() method.
    }

    public function delete($params = [])
    {
        $data = new DataConversor();
        $data = $data->converter();
        if (isset($data['tipo'])){
            $contagem = new Contagem();
            $contagem->setTipo($data['tipo']);
            $contagem->setUsuarioId($this->token['usuario']->id);
            $contagem->diminuir();
        }
    }
}