<?php // Shadowbox ?>

<div id="shadow-box">
    <div id="dialogo">
        <h1></h1>
        
        <button class="confirmar">Confirmar</button>
        <button class="rechazar">Rechazar</button>
    </div> <!-- /dialogo -->
</div> <!-- /shadow-box -->

<style>
#shadow-box {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgb(255, 255, 255);
    background: rgba(255, 255, 255, 0.8);
}

#dialogo {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    position: absolute;
    top: 50%;
    left: 50%;
    width: 250px;
    height: 250px;
    margin: -125px 0 0 -125px;
    padding: 20px;
    background: #FFF;
}
</style>