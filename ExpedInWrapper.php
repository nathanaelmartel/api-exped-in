<?php

namespace ExpedIn;

class ExpedInWrapper
{
    public $path = '';
    public $key = '';

    public function __construct($params)
    {
        if (isset($params['key'])) {
            $this->key = $params['key'];
        }

        if (isset($params['url'])) {
            $this->path = rtrim($params['url'], '/');
        }

        if ('' == $this->path) {
            return false;
        }

        if ('' == $this->key) {
            return false;
        }

        return true;
    }

    public function getOrders()
    {
        return $this->call('/order');
    }

    public function getOrder($uid)
    {
        return $this->call('/order/'.urlencode($uid));
    }

    public function setOrder(array $order)
    {
        return $this->call('/order/new', $order);
    }

    public function getProducts()
    {
        return $this->call('/product');
    }

    public function getProduct($uid)
    {
        return $this->call('/product/'.urlencode($uid));
    }

    public function getOrderssupplier($args = [])
    {
        return $this->call('/orderSupplier?'.http_build_query($args));
    }

    public function getOrdersupplier($uid)
    {
        return $this->call('/orderSupplier/'.urlencode($uid));
    }

    public function setOrdersupplier(array $order)
    {
        $result = $this->call('/orderSupplier/new', $order);

        return $result;
    }

    public function call($url, $posts = [], $headers = [])
    {
        $ch = curl_init();
        $url = $this->path.$url;

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(sprintf('Authorization: Bearer %s', $this->key)));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (count($posts) > 0) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($posts));
        }
        curl_setopt($ch, CURLOPT_REFERER, 'https://www.exped-in.com');

        curl_setopt($ch, CURLOPT_HEADER, 1);

        $result = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);

        $result_array = json_decode(trim($body), true);
        if (json_last_error()) {
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            var_dump($header);
            var_dump($body);
            throw new \Exception(json_encode($header."\n".$body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT));
        }
        curl_close($ch);
        /*
                if (0 != $result_array['error']) {
                    throw new \Exception(json_encode($result_array, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT));
                }*/

        return $result_array;
    }
}
