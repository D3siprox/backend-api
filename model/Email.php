<?php
/**
 * Created by PhpStorm.
 * User: marci
 * Date: 21/10/2017
 * Time: 13:50
 */

namespace model;


use util\Mail;

class Email
{
    private $mail;
    private $assunto;
    private $para;
    private $template;
    private $variaveisTemplate;

        /**
     * Email constructor.
     */
    public function __construct()
    {
        $this->mail = new Mail();
    }

    /**
     * @param mixed $assunto
     */
    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;
        $this->mail->setAssunto($this->assunto);
    }

    /**
     * @param mixed $para
     */
    public function setPara($para)
    {
        $this->para = $para;
        $this->mail->setPara($this->para);
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        $this->mail->setTemplate($this->template);
    }

    /**
     * @param mixed $variaveisTemplate
     */
    public function setVariaveisTemplate($variaveisTemplate)
    {
        $this->variaveisTemplate = $variaveisTemplate;
        $this->mail->setVariaveisTemplate($this->variaveisTemplate);
    }

    public function enviar(){
        $this->mail->enviar();
    }


}