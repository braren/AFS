<?php

/**
 * Clase de conexi&oacute;n intermedia entre TMDb y AFS
 * Created by: braren
 * Date: 03/02/16
 * Time: 23:10
 */
use Httpful\Request as RequestHttpful;

require __DIR__ . '/../src/jsonTools.class.php';

/**
 * Class httpClient
 */
class httpClient
{

    var $base_url = 'http://api.themoviedb.org/3/',
        $api_key = '?api_key=b8b8c49595b54014377ba887eb958c09';

    function __construct()
    {
    }

    /**
     * Obtiene la informaci&oacute;n completa del actor
     * @param $idActor Actor Id
     * @return string
     */
    function getFullActorInfo($idActor)
    {
        /**
         * Obtengo la informaci&oacute;n del actor
         */
        $itActor = $this->getActorById($idActor);
        $itFilmography = $this->getFilmographyByActor($idActor);

        /**
         * Ordeno la filmografia descendente por fecha
         */
        $jsonTools = new jsonTools();
        $castSort = $jsonTools->sortByDate($itFilmography->body->cast);

        /**
         * Genero el nuevo objeto JSON con toda la info del actor
         */
        $actorInfo = array(
            'id' => $itActor->body->id,
            'name' => $itActor->body->name,
            'profile_path' => $itActor->body->profile_path,
            'birthday' => $itActor->body->birthday,
            'place_of_birth' => $itActor->body->place_of_birth,
            'biography' => $itActor->body->biography,
            'cast' => $castSort);
        return json_encode($actorInfo);
    }

    /**
     * Obtiene sugerencias al escribir el actor
     * @param $query Nombre del actor a consultar
     * @return \Httpful\Response
     */
    function getSuggestions($query)
    {
        $uri = $this->base_url . 'search/person' . $this->api_key . '&query=' . str_replace(' ', '%20', $query);
        $response = RequestHttpful::get($uri)->send();

        $ltsData = json_decode(json_encode($response->body->results), true);
        $ltsSuggestions[] = null;

        if (is_array($ltsData) || is_object($ltsData)) {
            foreach ($ltsData as &$data) {
                $actorInfo = array(
                    'id' => $data['id'],
                    'name' => $data['name']);
                array_push($ltsSuggestions, $actorInfo);
            }
        }

        return json_encode($ltsSuggestions);
    }

    /**
     * Obtiene la información b&aacute;sica del actor
     * @param $idActor Actor Id
     * @return \Httpful\Response
     */
    private function getActorById($idActor)
    {
        $uri = $this->base_url . 'person/' . $idActor . $this->api_key;
        return RequestHttpful::get($uri)->send();
    }

    /**
     * Obtiene la filmograf&iacute;a completa de un actor
     * @param $idActor
     * @return \Httpful\Response
     */
    private function getFilmographyByActor($idActor)
    {
        $uri = $this->base_url . 'person/' . $idActor . '/movie_credits' . $this->api_key;
        return RequestHttpful::get($uri)->send();
    }
}
