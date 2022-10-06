<template>
    <div id="error" class="container SizeNotFound">
        <div class="text">
            <h1 class="text-center">Ops. la pagina che stai cercando probabilmente non esiste</h1>
        </div>
        <div class="row justify-content-between align-items-center">
            <div id="NotFound" class="col-6">
                <img src="./../../../img/PageNotFound.png" alt="PageNotFound">
            </div>
            <div class="BackToHome col-3">
                <h3 class="display-3"><a href="/">Torna alla Home</a> </h3>
            </div>
        </div>
        
    </div>
</template>

<style lang="scss" scoped>
.SizeNotFound{
    height: calc(100vh - 170px);
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
}
a{
    color: #3471eb;
}
</style>