// Carrega as máscaras de todos os campos com base na classe deles
function loadMasks(){
    // Máscara de números
    $(".inputNumber").each((i, singleElement) => {
        maskElementNumber(singleElement);
    })
}

// Carrega máscara de números com casas decimais e pontos de milhar
function maskElementNumber(element){
    $(element).maskMoney({thousands: ".", decimal: ","});
    element.value = element.value !== "" ? maskNumber(parseFloat(element.value)) : "";
}

// Retorna o número com as cadas decimais corretas
function maskNumber(value, decimalPlaces){
    if (typeof decimalPlaces == 'undefined' || decimalPlaces == 0){
        decimalPlaces = 2;
    }  

    return parseFloat(value.toFixed(decimalPlaces).toLocaleString('pt-br', {minimumFractionDigits: decimalPlaces}));
}

// Retira os pontos de milhar e define a vírgula da casa decimal como ponto
function unMaskNumber(value){
    return value.replace(/(\.)/g, '').replace(/,/g, '.');
}

// Autoload das máscaras
loadMasks();