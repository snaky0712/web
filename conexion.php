<?php

try
        
        {
            $conexion = new PDO ('mysql:host=localhost; dbname=bigbase','root','');
        }

        catch (PDOException $e)
        
        {
            echo "Error ". $e -> getMessage();
        }

?>