<?php

namespace App;


class Model
{
    protected static $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
    protected static $table = '';
    protected static $checkUrlExists = true;

    public function urlToShortCode()
    {
        if (false == empty($this->long_url)) {
            if (false != $this->validateUrlFormat($this->long_url)) {
                if (self::$checkUrlExists) {
                    if ($this->verifyUrlExists($this->long_url)) {
                        $shortCode = $this->urlExistsInDb($this->long_url);
                        if ($shortCode == false) {
                            $shortCode = $this->createShortCode();
                        }

                        return $shortCode;
                    }
                }
            }
        }
    }

    protected function validateUrlFormat($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL,
            FILTER_FLAG_HOST_REQUIRED);
    }

    protected function verifyUrlExists($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (!empty($response) && $response != 404);
    }

    protected function urlExistsInDb($url)
    {
        $db = new Db;
        $query = 'SELECT * FROM ' . static::$table .
            ' WHERE long_url = :long_url LIMIT 1';

        $params[':long_url'] = $url;

        $result = $db->query($query, $params, static::class);

        return (true == empty($result)) ? false : $result[0];
    }

    protected function createShortCode()
    {
        $this->insertUrlInDb();

        $this->convertIntToShortCode();

        $this->insertShortCodeInDb();

        return $this;
    }

    protected function insertUrlInDb()
    {
        $db = new Db;

        $this->date = $_SERVER["REQUEST_TIME"];

        $sql = 'INSERT INTO ' . static::$table ;
        $props = get_object_vars($this);

        $fieds = [];
        $bield = [];
        $data = [];
        foreach ($props as $name => $value){
            if ('id' == $name || 'short_url' == $name){
                continue;
            }
            $fieds[] = $name;
            $bield[] = ':' . $name;
            $data[':' . $name] = $value;
        }

        $sql .= ' (' . implode(', ', $fieds ) . ') VALUE (' . implode(', ', $bield) . ')';

        $db->execute($sql, $data);
        $this->id = $db->lastInsertId();

        return $this->id;
    }

    protected function convertIntToShortCode()
    {
        $id = intval($this->id);

        if ($id > 0) {

            $length = strlen(self::$chars);
            // Проверяем, что длина строки
            // больше минимума - она должна быть
            // больше 10 символов
            if ($length > 9) {

                $code = "";
                $length = $length - 1;

                while ($id > $length) {
                    // Определяем значение следующего символа
                    // в коде и подготавливаем его
                    $code = self::$chars[fmod($id, $length)] .
                        $code;
                    // Сбрасываем $id до оставшегося значения для конвертации
                    $id = floor($id / $length);
                }

                // Оставшееся значение $id меньше, чем
                // длина self::$chars
                $code = self::$chars[$id] . $code;

                $this->short_url = $code;
            }
        }

        return $this->short_url;
    }

    protected function insertShortCodeInDb()
    {
        if($this->id != null && $this->short_url != null){
            $db = new Db;
            $sql = 'UPDATE ' . static::$table ;
            $props = get_object_vars($this);

            $fieds = [];
            $data = [];
            foreach ($props as $name => $value){
                if ('id' == $name){
                    $fieldid = $name . ' = :' . $name;
                    $data[':' . $name] = $value;
                    continue;
                } elseif ('long_url' == $name || 'date' == $name)
                {
                    continue;
                }
                $fieds[] = $name . ' = :' . $name;
                $data[':' . $name] = $value;
            }

            $sql .= ' SET ' . implode(', ', $fieds). ' WHERE ' .$fieldid. ' ';

            $db->execute($sql, $data);
        }
    }

    public function shortCodeToUrl() {
        if (false == empty($this->short_url)) {
            $urlRow = $this->getUrlFromDb();
        }

        return $urlRow[0];
    }

    protected function getUrlFromDb() {
        $db = new Db;
        $sql = 'SELECT * FROM '. static::$table;

        $props = get_object_vars($this);

        $keys = array_keys($props);

        $bield = ':' . $keys[2];
        $data[':' . $keys[2]] = $props['short_url'];

        $sql .= ' WHERE short_url = ' . $bield;

        return $db->query($sql, $data, static::class);

    }

    public static function findAll()
    {
        $db = new Db;
        $sql = 'SELECT * FROM '. static::$table;
        return $db->query($sql, [], static::class);
    }

    public function delete()
    {
        $db = new Db;

        $sql = 'DELETE FROM ' . static::$table ;

        $props = get_object_vars($this);

        $keys = array_keys($props);

        $bield = ':' . $keys[0];
        $data[':' . $keys[0]] = $props['id'];

        $sql .= ' WHERE id = ' . $bield;

        $db->execute($sql, $data);
    }

    public static function findById($id)
    {
        $db = new Db;
        $bield[':id'] = $id;
        $sql = 'SELECT * FROM '. static::$table . ' WHERE id = :id';
        $result = $db->query($sql, $bield, static::class);
        return $result[0];
    }
}