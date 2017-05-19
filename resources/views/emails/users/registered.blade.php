@component('mail::message')
# Bem Vindo {{$user->name}}!

Seu cadastro no nosso sistema foi concluído com sucesso, entretanto, precisamos ainda avaliar
os dados enviados.

Fique atento à sua caixa de entrada, pois em breve irá receber um novo
email com a confirmação dos seus dados de acesso e um link para ativação da sua conta.

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
