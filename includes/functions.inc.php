<?php

function db_connect()
{
    static $connection;
    if(! isset($connection))
    {
        $config = parse_ini_file('config.ini');
        $connection = mysqli_connect(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['db_name'],
            $config['db_port']
        );
    }
    if($connection === false)
    {
        return mysqli_connect_error();
    }
    return $connection;
}


function db_query($query)
{
    $connection = db_connect();
    $result = mysqli_query($connection,$query);
    return $result;
}

function db_error()
{
    $connection = db_connect();
    mysqli_error($connection);
    // return $mysqli_error;
}
/**
 * @return false if the result is not fetched
 * @return multi-dimensional array with the rresult was found
 */

function db_select($query)
{
    $rows = array();
    $result = db_query($query);
    if($result === false)
    {
        return false;
    }
    while($row = mysqli_fetch_assoc($result))
    {
        $rows[] = $row;
    }
    return $rows;
}

function dd($data)
{
    die(var_dump($data));
}
function myDate($d,$format='Y-m-d')
{
    return date($format,strtotime($d));
}

function getOldValue($data,$key,$defaultValue = "")
{
    if(isset($data[$key]))
    {
        return $data[$key];
    }
    return $defaultValue;
}
function redirect($url)
{
    header("Location:$url");
    //in php the function used for to redirect is header.
}

