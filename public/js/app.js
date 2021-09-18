$(document).ready(function () {
    $("[name='cpf']").mask('###.###.###-##');
    $("[name='cpf']").attr('maxlength','14');
    $("[name='cpf']").attr('minlength','14');
    $("[name='cnpj']").mask('##.###.###/####-##');
    $("[name='cnpj']").attr('maxlength','18');
    $("[name='cnpj']").attr('minlength','18');
    $("[name='telephone']").mask('(##) #.####-####');
    $("[name='telephone']").attr('maxlength','16');
    $("[name='telephone']").attr('minlength','16');
    $("[name='cep']").mask('##.###-###');
    $("[name='cep']").attr('maxlength','10');
    $("[name='cep']").attr('minlength','10');
})
