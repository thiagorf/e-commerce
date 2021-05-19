<template>
    <div class="spinner-container">
        <div class="spinner">
        </div>
    </div>
</template>
<script>
export default {
    name: 'Spinner'
}
</script>
<style lang="scss" scoped>
@import './../../sass/variables';
.spinner-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 600px;
}
.spinner {
    //margin: 0 auto;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 12px solid #FFF;
    border-top: 12px solid $button-color;
    animation: spin 2s linear infinite;
}
@keyframes spin {
    0% {transform: rotate(0deg);}
    100% {transform: rotate(360deg);}
}
</style>