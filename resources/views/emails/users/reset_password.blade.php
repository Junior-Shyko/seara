@component('mail::message')
# Olá {{$user->name}}!

Você está recebendo esse email porque recebemos uma requisição de redefinição de senha para sua
conta.

@component('mail::button', ['url' => $url])
Redefinir senha
@endcomponent

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
