<style>
    .langs {
        position: fixed;
        z-index: 99999;
        bottom: 10%;
        left:0;
        width:40px;
        height:85px;
        padding:5px;
        background: #5B22FF;
        opacity: 0.7;

        border-radius: 0px 20px 20px 0px;
        -moz-border-radius: 0px 20px 20px 0px;
        -webkit-border-radius: 0px 20px 20px 0px;
        border: 0px solid #000000;
    }
    .langs img {
        max-width:100%;
    }
    .langs:hover {
        opacity: 1;
    }
    .langs a {
        display: block;
        margin-top:5px;
    }
</style>

<div class="langs">
    <a href="{{ route('language.set', ['code' => 'ru']) }}">
        <img src="/assets/images/langs/ru.png" alt="">
    </a>
    <a href="{{ route('language.set', ['code' => 'en']) }}">
        <img src="/assets/images/langs/en.png" alt="">
    </a>
</div>