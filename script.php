<?php

require_once 'bootstrap.php';

$continua = true;

while($continua)
{
    $urls = $entityManager->getRepository('Urls')->findAll();

    $count_finish = 0;

    foreach($urls as $url)
    {
        if($url->getVisited() == "no")
        {
            $conteudo_pagina = file_get_contents($url->getUrl());

            preg_match_all('/<a href=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?>/i', $conteudo_pagina, $resultados_urls);

            preg_match_all('/\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $conteudo_pagina, $resultados_emails);

            if(empty($resultados_urls[1]))
            {
                //para o processo caso não houver mais links novos
                echo "teste";
                $continua = false;
            }
            else
            {
                foreach($resultados_urls[1] as $chave=>$resultado)
                {

                    $temp_resultado = (!preg_match('#^(ht|f)tps?://#', $resultado))
                    ? 'http://' . $resultado
                    : $resultado;

                    //completa o link caso não esteja completo
                    if (filter_var($temp_resultado, FILTER_VALIDATE_URL))
                    {
                        $url_string = $resultado;
                    }
                    else
                    {
                        $url_string = $url->getUrl() . $resultado;
                    }

                    //procura a url no banco
                    $url_exist = $entityManager->getRepository('Urls')->findOneBy(array('url' => $url_string));

                    //verifica se a url já está no banco, caso não, inclui a nova
                    if(empty($url_exist))
                    {
                        $urls_entity = new Urls;
                        $urls_entity->setUrl($url_string);
                        $urls_entity->setVisited('no');
                        $entityManager->persist($urls_entity);
                        $entityManager->flush();

                    }

                    $continua = false;
                }

            }

            if(!empty($resultados_emails[0]))
            {
                echo print_r($resultados_emails[0]);
                foreach($resultados_emails[0] as $chave=>$resultado)
                {

                    //procura o email no banco
                    $email_exist = $entityManager->getRepository('Emails')->findOneBy(array('email' => $resultado));

                    //verifica se o email já está no banco, caso não, inclui o novo
                    if(empty($email_exist))
                    {
                        $emails_entity = new Emails;
                        $emails_entity->setEmail($resultado);
                        $entityManager->persist($emails_entity);
                        $entityManager->flush();

                    }
                }

            }

            //setar url como visitada
            $id = $url->getId();
            $update = $entityManager->find('Urls', $id);
            $update->setVisited('yes');
            $entityManager->persist($update);
            $entityManager->flush();
        }

        else
        {
            $count_finish ++;

        }

        
    }

    if($count_finish == count($urls))
    {
        $continua = false;
    }
    

}


