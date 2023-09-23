<div class="loader-container">
    <div class="loader"></div>
</div>

<style>
    .loader-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loader {
        border: 10px solid #f3f3f3;
        border-top: 10px solid rgba(7, 3, 114, 0.9);
        border-radius: 50%;
        margin-top: 22%;
        margin-left: 50%;
        width: 70px;
        height: 70px;
        animation: loading 0.75s ease infinite;
    }

    @keyframes loading {
        0% { transform: rotate(0turn); }
        100% { transform: rotate(1turn); }
    }
</style>