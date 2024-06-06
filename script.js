function calcularIMC() {
    var peso = parseFloat(document.getElementById('peso').value);
    var altura = parseFloat(document.getElementById('altura').value);

    var imc = peso / (altura * altura);
    var classificacao = '';

    if (imc < 18.5) {
        classificacao = 'Abaixo do Peso';
    } else if (imc < 25) {
        classificacao = 'Peso Normal';
    } else if (imc < 30) {
        classificacao = 'Sobrepeso';
    } else if (imc < 35) {
        classificacao = 'Obesidade Grau I';
    } else if (imc < 40) {
        classificacao = 'Obesidade Grau II';
    } else {
        classificacao = 'Obesidade Grau III';
    }

    document.getElementById('resultado').innerHTML = `Seu IMC é ${imc.toFixed(2)} - ${classificacao}`;
}