<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 23/10/2017
 * Time: 19:55
 */

namespace model\dao;

use model\Lista;
use phiber\Phiber;
use util\IflixException;


class ListaDAO implements IDAO
{

    private static $rows;

    /**
     * @return mixed
     */
    public static function getRows()
    {
        return self::$rows;
    }


    /**
     * @param Lista $lista
     * @return bool
     * @throws IflixException
     */
    static function create($lista)
    {


        $phiber = new Phiber();
        $phiber->setTable("minha_lista_" . $lista->getVideo()->getTipo());
        $phiber->setFields(["usuario_id", $lista->getVideo()->getTipo() . "_id"]);
        $phiber->setValues([$lista->getUsuario()->getId(), $lista->getVideo()->getId()]);
        if ($phiber->create()) {
            return true;
        };
        throw new IflixException("Algo de errado aconteceu com o ListaDAO");
    }

    /**
     * @param Lista $lista
     * @return array
     * @throws IflixException
     */
    static function retreave($lista)
    {

        $phiber = new Phiber();
        $sql = "SELECT " . $lista->getVideo()->getTipo() . "_id AS id, nome, classificacao, ";
        if ($lista->getVideo()->getTipo() == 'filme') {
            $sql .= "caminho, duracao, ";
        }
        $sql .= "sinopse, thumbnail, genero_id, status
FROM " . $lista->getVideo()->getTipo() . " 
  INNER JOIN  minha_lista_" . $lista->getVideo()->getTipo() . " 
    ON " . $lista->getVideo()->getTipo() . "_id =  " . $lista->getVideo()->getTipo() . ".id
WHERE usuario_id = :condition_usuario_id";
        $phiber->writeSQL($sql);
        $phiber->bindValue("condition_usuario_id", $lista->getUsuario()->getId());
        $phiber->execute();
        return $phiber->fetchAll();

    }

    /**
     * @param $lista
     * @return mixed|void
     */
    static function update($lista)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param Lista $lista
     * @return boolean
     */
    static function delete($lista)
    {
        $phiber = new Phiber();
        $phiber->setTable("minha_lista_" . $lista->getVideo()->getTipo());
        $restrictionIdVideo = $phiber->restrictions->equals($lista->getVideo()->getTipo() . "_id", $lista->getVideo()->getId());
        $restrictionUsuario = $phiber->restrictions->equals("usuario_id", $lista->getUsuario()->getId());
        $restriction = $phiber->restrictions->and($restrictionIdVideo, $restrictionUsuario);
        $phiber->add($restriction);
        return $phiber->delete();
    }


    /**
     * @param Lista $lista
     * @return array
     */
    static function retornaListaWhereVideoAndUsuario($lista)
    {
        $phiber = new Phiber();
        $phiber->setTable("minha_lista_" . $lista->getVideo()->getTipo());
        $restrictionIdVideo = $phiber->restrictions->equals($lista->getVideo()->getTipo() . "_id", $lista->getVideo()->getId());
        $restrictionUsuario = $phiber->restrictions->equals("usuario_id", $lista->getUsuario()->getId());
        $restriction = $phiber->restrictions->and($restrictionIdVideo, $restrictionUsuario);
        $phiber->add($restriction);

        $r = $phiber->select();
        self::$rows = $phiber->rowCount();
        return $r;
    }
}