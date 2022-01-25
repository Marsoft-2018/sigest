<?php 
    function periodoMin($centro){
        $pMin = 0;
        
        $sql_periodoRango = mysql_query("SELECT MIN(AJ.`periodo`) AS periodoMin FROM ajustes AJ WHERE AJ.`idCentro`='$centro';");//Obtengo el periodo max y el periodo min

        while($pr = mysql_fetch_array($sql_periodoRango)){
            $pMin = $pr[0];
        }
        return $pMin;
    }
    
    function periodoMax($centro){
        $pMax=0;
        
        $sql_periodoRango = mysql_query("SELECT MAX(AJ.`periodo`) AS periodoMax FROM ajustes AJ WHERE AJ.`idCentro`='$centro';");//Obtengo el periodo max

        while($pr = mysql_fetch_array($sql_periodoRango)){
            $pMax = $pr[0];
        }
        return $pMax;
    }