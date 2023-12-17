<?php

function ibgeEstados()
{
    // Verificar se cURL está disponível
    if (!function_exists('curl_init')) {
        return "Erro: cURL não está disponível no seu servidor.";
    }

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://servicodados.ibge.gov.br/api/v1/localidades/estados",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    // Tratamento de erros
    if ($err) {
        return "Erro cURL: $err";
    }

    // Verificar se a resposta é válida antes de tentar decodificar em JSON
    if (!empty($response)) {
        return json_decode($response, true);
    } else {
        return "Erro: Resposta vazia da API.";
    }
}


function ibgeMunicipios()
{
    // Verificar se cURL está disponível
    if (!function_exists('curl_init')) {
        return "Erro: cURL não está disponível no seu servidor.";
    }

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://servicodados.ibge.gov.br/api/v1/localidades/municipios",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    // Tratamento de erros
    if ($err) {
        return "Erro cURL: $err";
    }

    // Verificar se a resposta é válida antes de tentar decodificar em JSON
    if (!empty($response)) {
        return json_decode($response, true);
    } else {
        return "Erro: Resposta vazia da API.";
    }
}
